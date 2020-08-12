<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Users;
use App\Http\Controllers\Validator;
use DB;
use \stdClass;

class OwnerController extends BaseController
{
    public function calender(Request $request)
    {
        # code...

        $user_id = $request->session()->get('user_id');
        $properties = DB::table('property_list')
            ->where('user_id', $user_id)
            ->select('id', 'title')
            ->get();

        if ($request->id) {
            $property_rate = DB::table('property_short_term_pricing')
                ->where('property_id', $request->id)
                ->select('price_per_night')
                ->first();
            // print_r($property_rate);exit;

            $list = [];

            $month = date('m');
            $year = date('Y');
            $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            for ($d = 1; $d <= $days; $d++) {
                $time = mktime(12, 0, 0, $month, $d, $year);
                if (date('m', $time) == $month) {
                    $list[$d]['date'] = date('Y-m-d', $time);
                }
                $list[$d]['price'] = $property_rate->price_per_night;
            }
            $id = $request->id;
            $icals = DB::table('third_party_calender')
                ->where('property_id', '=', $id)
                ->get();
            $events = DB::table('property_booking')
                ->where('client_id', '=', CLIENT_ID)
                ->where('property_id', '=', $id)
                ->get();
            $block_events = DB::table('property_blocking')
                ->where('client_id', '=', CLIENT_ID)
                ->where('property_id', '=', $id)
                ->get();
            $special_price = DB::table('property_special_pricing')
                ->where('client_id', '=', CLIENT_ID)
                ->where('property_id', '=', $id)
                ->get();

            //print_r($special_price);
            $dates = [];

            for ($i = 0; $i < count($special_price); $i++) {
                $dates[$i]['date'] = $special_price[$i]->start_date;
                $dates[$i]['price'] = $special_price[$i]->price_per_night;
            }

            //print_r($dates);exit;

            $finn = [];
            $finn = array_merge($dates, $list);
            // print_r($finn);exit;
            $res = [];
            $val = [];
            foreach ($finn as $key => $index) {
                if (!in_array($index['date'], $val)) {
                    if ($index['date']) {
                        $val[] = $index['date'];
                        $res[] = $index;
                    }
                }
            }

            foreach ($events as $key => $value) {
                if ($value->is_instant < 2) {
                    $value->booked_on = APP_BASE_NAME;
                } else {
                    $value->booked_on = 'Airbnb';
                }
            }

            return view('owner.calender', compact('properties', 'id', 'events', 'icals', 'block_events', 'res'));
        }
        $events = [];
        $icals = [];
        $id = 0;
        $property_rate = new stdClass();
        $property_rate->price_per_night = 0;
        $res = [];
        $block_events = [];
        $special_price = [];
        //print_r($events);exit;
        // print_r($icals);
        // print_r($properties);
        // echo $id;exit;
        return view('owner.calender', compact('properties', 'id', 'events', 'icals', 'block_events', 'res'));
    }

    public function special_price(Request $request)
    {
        $properties = DB::table('property_list')
            ->where('client_id', CLIENT_ID)
            ->where('user_id', $request->session()->get('user_id'))
            ->where('is_complete', 1)
            ->get();
        $special_price = DB::table('property_special_pricing')
            ->where('property_special_pricing.client_id', CLIENT_ID)
            ->join('property_list', 'property_special_pricing.property_id', '=', 'property_list.id')
            ->where('property_special_pricing.owner_id', $request->session()->get('user_id'))
            ->select('property_special_pricing.*', 'property_list.title')
            ->limit(5)
            ->orderBy('property_special_pricing.id', 'desc')
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
            'special_price' => $special_price,
            'blocking' => $blocking,
        ]);
    }

    public function special_price_details(Request $request)
    {
        $special_price = DB::table('property_special_pricing')
            ->where('property_special_pricing.client_id', CLIENT_ID)
            ->join('property_list', 'property_special_pricing.property_id', '=', 'property_list.id')
            ->where('property_special_pricing.owner_id', $request->session()->get('user_id'))
            ->select('property_special_pricing.*', 'property_list.title')
            ->get();
        $blocking = DB::table('property_blocking')
            ->where('property_blocking.client_id', CLIENT_ID)
            ->join('property_list', 'property_blocking.property_id', '=', 'property_list.id')
            ->where('property_blocking.owner_id', $request->session()->get('user_id'))
            ->select('property_blocking.*', 'property_list.title')
            ->get();
        return view('owner.special_price_details', ['special_price' => $special_price, 'blocking' => $blocking]);
    }
}
