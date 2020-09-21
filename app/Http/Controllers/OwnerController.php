<?php

namespace App\Http\Controllers;
use App\Helper\Helper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Users;
use App\Http\Controllers\Validator;
use DB;
use \stdClass;

class OwnerController extends BaseController
{
    public function owner_profile(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        if (!$user_id) {
            return redirect('/login')->with('error', 'Session timeout login again');
        }
        print_r($user_id);
        exit();
        $client_id = $this->get_client_id();
        $user_detail = DB::table('users')
            ->where('client_id', '=', $client_id)
            ->where('id', '=', $user_id)
            ->first();

        foreach ($user_detail as $key => $value) {
            if ($value == '0' && $key !== 'role_id') {
                $user_detail->$key = "";
            }
        }

        $agency = DB::table('agency')
            ->orderBy('name', 'ASC')
            ->get();
        $occupation = DB::table('occupation')
            ->orderBy('name', 'ASC')
            ->get();

        return view('profile', [
            'user_detail' => $user_detail,
            'country_codes' => $country_codes,
            'agency' => $agency,
            'occupation' => $occupation,
        ]);
    }
    public function calender(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $properties = DB::table('property_list')
            ->where('user_id', $user_id)
            ->select('id', 'title')
            ->orderBy('title', 'ASC')
            ->get();

        if ($request->id) {
            $property_details = DB::table('property_list')
                ->where('id', $request->id)
                ->first();
            $property_title = $property_details->title ?? '';
            $list = [];

            $month = date('m');
            $year = date('Y');
            $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            for ($d = 1; $d <= $days; $d++) {
                $time = mktime(12, 0, 0, $month, $d, $year);
                if (date('m', $time) == $month) {
                    $list[$d]['date'] = date('Y-m-d', $time);
                }
                $list[$d]['price'] = Helper::get_daily_price($property_details->monthly_rate);
            }
            $id = $request->id;
            $icals = DB::table('third_party_calender')
                ->where('property_id', '=', $id)
                ->get();
            $booked_events = DB::table('property_booking')
                ->leftjoin('users as traveller', 'traveller.id', '=', 'property_booking.traveller_id')
                ->where('property_booking.client_id', '=', CLIENT_ID)
                ->where('property_booking.property_id', '=', $id)
                ->where('property_booking.payment_done', '=', 1)
                ->select(
                    DB::raw('DATE_FORMAT(property_booking.start_date, "%M %d, %Y") as start_date'),
                    DB::raw('DATE_FORMAT(property_booking.end_date, "%M %d, %Y") as end_date'),
                    'traveller.username',
                )
                ->get();
            $block_events = DB::table('property_blocking')
                ->where('client_id', '=', CLIENT_ID)
                ->where('property_id', '=', $id)
                ->select(
                    'property_booking.is_instant',
                    DB::raw('DATE_FORMAT(property_blocking.start_date, "%M %d, %Y") as start_date'),
                    DB::raw('DATE_FORMAT(property_blocking.end_date, "%M %d, %Y") as end_date'),
                )
                ->get();

            $res = [];
            $val = [];
            foreach ($list as $key => $index) {
                if (!in_array($index['date'], $val)) {
                    if ($index['date']) {
                        $val[] = $index['date'];
                        $res[] = $index;
                    }
                }
            }

            foreach ($booked_events as $key => $value) {
                if ($value->is_instant < 2) {
                    $value->booked_on = APP_BASE_NAME;
                } else {
                    $value->booked_on = 'Airbnb';
                }
            }

            return view(
                'owner.calender',
                compact('properties', 'id', 'booked_events', 'icals', 'block_events', 'res', 'property_title'),
            );
        }
        $booked_events = [];
        $icals = [];
        $id = 0;
        $property_rate = new stdClass();
        $property_rate->price_per_night = 0;
        $res = [];
        $block_events = [];
        $property_title = '';
        return view(
            'owner.calender',
            compact('properties', 'id', 'booked_events', 'icals', 'block_events', 'res', 'property_title'),
        );
    }

    public function my_bookings(Request $request)
    {
        $from = strtotime($request->start_date);
        $to = strtotime($request->end_date);
        DB::table('property_booking')
            ->where('property_booking.owner_id', $request->session()->get('user_id'))
            ->update(['owner_notify' => 0]);
        $data = DB::table('property_booking')
            ->join('property_list', 'property_list.id', '=', 'property_booking.property_id')
            ->where('property_booking.owner_id', $request->session()->get('user_id'));
        if ($from && $to) {
            $fromDate = date('Y-m-d', $from);
            $toDate = date('Y-m-d', $to);

            $data->whereRaw(
                'property_booking.start_date between "' .
                    $fromDate .
                    '" and "' .
                    $toDate .
                    '" OR
                             property_booking.end_date between "' .
                    $fromDate .
                    '" and "' .
                    $toDate .
                    '" OR
                             "' .
                    $fromDate .
                    '" between property_booking.start_date and property_booking.end_date',
            );
            // TODO: check if date should fall between selected range then change line to (property_booking.start_date <= $fromDate AND property_booking.end_date >= $toDate)
            //            $data->whereBetween('property_booking.start_date', [$from, $to]);
        }
        $data = $data->select('property_list.title', 'property_booking.*')->get();

        $booking_requests = [];
        $my_bookings = [];
        foreach ($data as $datum) {
            $traveller = DB::table('users')
                ->where('client_id', CLIENT_ID)
                ->where('id', $datum->traveller_id)
                ->first();
            $image = DB::table('property_images')
                ->where('client_id', CLIENT_ID)
                ->where('property_id', $datum->property_id)
                ->first();
            $datum->image_url = $image->image_url;
            if ($traveller->role_id != 2) {
                $datum->traveller_name = $traveller->username;
            } else {
                $datum->traveller_name = $traveller->name_of_agency;
            }
            $datum->start_date = Carbon::parse($datum->start_date)->format('m/d/Y');
            $datum->end_date = Carbon::parse($datum->end_date)->format('m/d/Y');
            $datum->bookStatus = Helper::get_traveller_status($datum->status, $datum->start_date, $datum->end_date);
            if ($datum->status < 2) {
                array_push($booking_requests, $datum);
            } else {
                array_push($my_bookings, $datum);
            }
        }

        return view('owner.my_bookings')->with(compact('booking_requests', 'my_bookings'));
    }

    public function payment_default($id, Request $request)
    {
        DB::table('payment_method')
            ->where('client_id', '=', CLIENT_ID)
            ->where('user_id', $request->session()->get('user_id'))
            ->where('is_default', ZERO)
            ->update(['is_default' => ONE]);
        DB::table('payment_method')
            ->where('client_id', '=', CLIENT_ID)
            ->where('id', $id)
            ->update(['is_default' => ZERO]);
        $url = BASE_URL . 'owner/payment-method';
        return redirect($url);
    }

    public function payment_method_index(Request $request)
    {
        $payment_method = DB::table('payment_method')
            ->where('client_id', '=', CLIENT_ID)
            ->where('user_id', '=', $request->session()->get('user_id'))
            ->orderBy('is_default', 'asc')
            ->get();
        return view('owner.payment_method', ['payment_method' => $payment_method]);
    }

    public function property_owner_profile($id, Request $request)
    {
        $user = DB::table('users')
            ->where('id', $id)
            ->first();
        if (empty($user)) {
            return view('general_error', ['message' => 'We can’t find the profile you’re looking for.']);
        }
        $properties = DB::table('property_list')
            ->join('property_room', 'property_room.property_id', '=', 'property_list.id')
            ->where('property_list.user_id', $id)
            ->get();
        $current_date = date('Y-m-d H:i:s');

        $avg_rating = DB::select(
            "SELECT AVG(A.review_rating) as avg_rating FROM property_review A, property_list B, users C WHERE C.id = B.user_id AND A.property_id = B.id AND C.id = $id",
        );
        $ratng = $avg_rating[0]->avg_rating;
        foreach ($properties as $property) {
            $date2 = date_create($property->created_at);
            $date1 = date_create($current_date);
            $diff = date_diff($date2, $date1);
            $property->diff = $diff->days;

            $property->images = DB::table('property_images')
                ->where('property_id', $property->property_id)
                ->get();
        }
        return view('properties.owner_profile', [
            'avg_rating' => $ratng,
            'current_date' => $current_date,
            'user' => $user,
            'properties' => $properties,
        ]);
    }

    public function special_price(Request $request)
    {
        $properties = DB::table('property_list')
            ->where('client_id', CLIENT_ID)
            ->where('user_id', $request->session()->get('user_id'))
            ->where('is_complete', 1)
            ->orderBy('title', 'ASC')
            ->get();
        $blocking = DB::table('property_blocking')
            ->where('property_blocking.client_id', CLIENT_ID)
            ->join('property_list', 'property_blocking.property_id', '=', 'property_list.id')
            ->where('property_blocking.owner_id', $request->session()->get('user_id'))
            ->select('property_blocking.*', 'property_list.title')
            ->limit(5)
            ->orderBy('property_blocking.id', 'desc')
            ->get();
        return view('owner.special-pricing', [
            'properties' => $properties,
            'blocking' => $blocking,
        ]);
    }

    public function special_price_details(Request $request)
    {
        $blocking = DB::table('property_blocking')
            ->where('property_blocking.client_id', CLIENT_ID)
            ->join('property_list', 'property_blocking.property_id', '=', 'property_list.id')
            ->where('property_blocking.owner_id', $request->session()->get('user_id'))
            ->select('property_blocking.*', 'property_list.title')
            ->get();
        return view('owner.special_price_details', ['blocking' => $blocking]);
    }
}
