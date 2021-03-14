<?php

namespace App\Http\Controllers;
use App\Helper\Helper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use ICal\ICal;
use App\Http\Controllers\Validator;
use App\Models\Users;
use App\Models\PropertyBlocking;
use App\Services\Logger;
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
            ->where('property_list.client_id', '=', CLIENT_ID)
            ->where('property_list.user_id', $user_id)
            ->where('property_list.is_complete', '=', 1)
            ->where('property_list.property_status', '=', 1)
            ->where('property_list.status', '=', 1)
            ->where('property_list.is_disable', '=', 0)
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
                ->where('property_booking.status', '=', 2)
                ->select(
                    'property_booking.start_date',
                    'property_booking.end_date',
                    //                    DB::raw('DATE_FORMAT(property_booking.start_date, "%M %d, %Y") as start_date'),
                    //                    DB::raw('DATE_FORMAT(property_booking.end_date, "%M %d, %Y") as end_date'),
                    'traveller.first_name',
                    'traveller.last_name',
                )
                ->get();
            $block_events = DB::table('property_blocking')
                ->where('client_id', '=', CLIENT_ID)
                ->where('property_id', '=', $id)
                ->select(
                    'property_blocking.start_date',
                    'property_blocking.end_date',
                    'property_blocking.booked_on',
                    //                    'property_booking.is_instant',
                    //                    DB::raw('DATE_FORMAT(property_blocking.start_date, "%M %d, %Y") as start_date'),
                    //                    DB::raw('DATE_FORMAT(property_blocking.end_date, "%M %d, %Y") as end_date'),
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

            //            foreach ($booked_events as $key => $value) {
            //                if ($value->is_instant < 2) {
            //                    $value->booked_on = APP_BASE_NAME;
            //                } else {
            //                    $value->booked_on = 'Airbnb';
            //                }
            //            }
            $booked_events->booked_on = APP_BASE_NAME;
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

    public function add_calender_blocking($fileOrurl, $property_id, $owner_id)
    {
        $ical = new ICal($fileOrurl, [
            'defaultSpan' => 2, // Default value
            'defaultTimeZone' => 'UTC',
            'defaultWeekStart' => 'MO', // Default value
            'disableCharacterReplacement' => false, // Default value
            'filterDaysAfter' => null, // Default value
            'filterDaysBefore' => null, // Default value
            'skipRecurrence' => false, // Default value
        ]);
        $entries = [];
        foreach ($ical->cal as $key => $value) {
            if ($key == 'VEVENT' && !empty($value)) {
                foreach ($value as $key => $data) {
                    // getting start date
                    $start_date = explode('T', $data['DTSTART'])[0];
                    // getting end date
                    $end_date = explode('T', $data['DTEND'])[0];
                    $desc = $data['SUMMARY'] ?? $data['DESCRIPTION'];
                    array_push($entries, [
                        'start_date' => $start_date,
                        'end_date' => $end_date,
                        'booked_on' => $desc,
                        'is_admin' => 0,
                        'property_id' => $property_id,
                        'owner_id' => $owner_id,
                        'client_id' => CLIENT_ID,
                    ]);
                }
            }
        }
        Logger::info(json_encode($entries));
        PropertyBlocking::insert($entries);
    }

    public function upload_calender(Request $request)
    {
        $property_id = $request->property_id;
        $owner_id = $request->session()->get('user_id');
        $ical_url = $request->ical_url;
        if ($property_id) {
            try {
                if ($request->hasfile('calender_files')) {
                    foreach ($request->file('calender_files') as $file) {
                        $this->add_calender_blocking($file, $property_id, $owner_id);
                    }
                    return response()->json([
                        'success' => true,
                        'error' => 'Calender has been uploaded',
                    ]);
                } elseif ($ical_url) {
                    $this->add_calender_blocking($ical_url, $property_id, $owner_id);
                    return response()->json([
                        'success' => true,
                        'error' => 'Calender has been uploaded',
                    ]);
                } else {
                    Logger::info('No calender files or url are provided');
                    return response()->json([
                        'success' => false,
                        'error' => 'No calender files or url are provided',
                    ]);
                }
            } catch (\Throwable $th) {
                Logger::info(json_encode($th->getMessage()));
                return response()->json([
                    'success' => false,
                    'error' => $th->getMessage() || 'No calender files or url are provided',
                ]);
            }
        } else {
            Logger::info('Property id was not found');
            return response()->json([
                'success' => false,
                'error' => 'Property id was not found',
            ]);
        }
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
            ->where('property_booking.owner_id', $request->session()->get('user_id'))
            ->where('property_booking.status', '!=', 0);

        if ($from && $to) {
            $fromDate = date('Y-m-d', $from);
            $toDate = date('Y-m-d', $to);

            $data->whereRaw(
                '(property_booking.start_date between "' .
                    $fromDate .
                    '" and "' .
                    $toDate .
                    '" OR property_booking.end_date between "' .
                    $fromDate .
                    '" and "' .
                    $toDate .
                    '" OR "' .
                    $fromDate .
                    '" between property_booking.start_date and property_booking.end_date)',
            );
            // TODO: check if date should fall between selected range then change line to (property_booking.start_date <= $fromDate AND property_booking.end_date >= $toDate)
            //            $data->whereBetween('property_booking.start_date', [$from, $to]);
        }
        $data = $data
            ->where('property_booking.funding_source', '!=', '')
            ->select('property_list.title', 'property_booking.*')
            ->get();

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
                ->orderBy('is_cover', 'desc')
                ->first();
            $datum->image_url = '';
            if ($image) {
                $datum->image_url = $image->image_url;
            }
            //            if ($traveller->role_id != 2) {
            $datum->traveller_name = Helper::get_user_display_name($traveller);
            //            } else {
            //                $datum->traveller_name = $traveller->name_of_agency;
            //            }
            $datum->start_date = Carbon::parse($datum->start_date)->format('m/d/Y');
            $datum->end_date = Carbon::parse($datum->end_date)->format('m/d/Y');
            $datum->bookStatus = Helper::get_traveller_status(
                $datum->status,
                $datum->start_date,
                $datum->end_date,
                $datum->cancellation_requested,
            );
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
            ->leftjoin('property_room', 'property_room.property_id', '=', 'property_list.id')
            ->where('property_list.is_disable', '=', ZERO)
            ->where('property_list.client_id', '=', CLIENT_ID)
            ->where('property_list.property_status', '=', 1)
            ->where('property_list.status', '=', 1)
            ->where('property_list.is_complete', '=', ACTIVE)
            ->where('property_list.user_id', $id)
            ->select(
                'property_list.*',
                'property_room.property_size',
                'property_room.bathroom_count',
                'property_room.bedroom_count',
                'property_room.bed_count',
                'property_room.common_spaces',
            )
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
                ->where('property_id', $property->id)
                ->orderBy('is_cover', 'desc')
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
