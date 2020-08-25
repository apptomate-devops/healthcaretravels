<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Calendar;
use App\Bookings;
use DB;

class CalenderController extends BaseController
{
    public function add_calender(Request $request, $property_id)
    {
        //
        if ($request->ical_name || $request->ical_url || $property_id) {
            return response()->json(['status' => 'FAILED', 'message' => 'Please fill all the details']);
        }

        $data = [];
        $data['property_id'] = $property_id;
        $data['third_party_name'] = $request->ical_name;
        $data['third_party_url'] = $request->ical_url;
        $data['status'] = ONE;
        DB::table('third_party_calender')->insert($data);
        return response()->json(['status' => 'SUCCESS']);
    }

    public function test_mail(Request $request)
    {
        $profile_pic = $request->profile_image;

        $image_parts = explode(";base64,", $profile_pic);
        $image_type_aux = explode("image/", $image_parts[0]);

        $image_base64 = base64_decode($image_type_aux[0]);
        $path_url = 'public/uploads/';
        $file = $path_url . uniqid() . '.png';
        file_put_contents($file, $image_base64);
        echo BASE_URL . $file;
        $html =
            "<!DOCTYPE html><html><head><title>Test</title></head><body><center><h2>Hello World</h2></center></body></html>";
        //mail("siva@sparkouttech.com","TEST HTML MAIL",$html);
    }

    public function calender()
    {
        # code...
        $events = [];

        $events[] = \Calendar::event(
            'Event One', //event title
            false, //full day event?
            '2015-02-11T0800', //start time (you can also use Carbon instead of DateTime)
            '2015-02-12T0800', //end time (you can also use Carbon instead of DateTime)
            0, //optionally, you can specify an event ID
        );

        $events[] = \Calendar::event(
            "Valentine's Day", //event title
            true, //full day event?
            new \DateTime('2015-02-14'), //start time (you can also use Carbon instead of DateTime)
            new \DateTime('2015-02-14'), //end time (you can also use Carbon instead of DateTime)
            'stringEventId', //optionally, you can specify an event ID
        );

        $calendar = \Calendar::addEvents($events) //add an array with addEvents
            ->setOptions([
                //set fullcalendar options
                'firstDay' => 1,
            ])
            ->setCallbacks([
                //set fullcalendar callback options (will not be JSON encoded)
                'viewRender' => 'function() {alert("Callbacks!");}',
            ]);

        return view('calender.index', compact('calendar'));
    }

    public function block_booking(Request $request)
    {
        DB::table('property_blocking')->insert([
            'client_id' => CLIENT_ID,
            'owner_id' => $request->session()->get('user_id'),
            'start_date' => $request->start,
            'end_date' => $request->end,
            'booked_on' => $request->title,
            'property_id' => $request->pro_id,
        ]);
        $events = DB::table('property_blocking')
            ->where('client_id', '=', CLIENT_ID)
            ->where('property_id', '=', $request->pro_id)
            ->get();
    }
}
