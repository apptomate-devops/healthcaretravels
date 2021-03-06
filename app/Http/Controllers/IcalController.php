<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;

class IcalController extends BaseController
{
    //
    public function ical($id, Request $request)
    {
        //
        if (empty($id)) {
            return;
        }

        $bookings = DB::table('property_booking')
            ->leftjoin('users', 'users.id', '=', 'property_booking.traveller_id')
            ->leftjoin('property_list', 'property_list.id', '=', 'property_booking.property_id')
            ->where('property_booking.client_id', CLIENT_ID)
            ->where('property_booking.property_id', $id)
            ->whereDate('property_booking.end_date', '>=', Carbon::now())
            ->where('property_booking.status', 2)
            ->select(
                'property_booking.start_date',
                'property_booking.end_date',
                'property_list.title',
                'users.first_name',
                'users.last_name',
            )
            ->get();

        // only display confirmed bookings

        $vCalendar = new \Eluceo\iCal\Component\Calendar(BASE_URL);
        $vCalendar->setMethod('PUBLISH');

        foreach ($bookings as $booking) {
            $traveler_name = Helper::get_user_display_name($booking);
            $booking_event = new \Eluceo\iCal\Component\Event();
            $booking_event
                ->setDtStart(new \DateTime($booking->start_date))
                ->setDtEnd(new \DateTime($booking->end_date))
                ->setNoTime(true)
                ->setSummary($booking->title . "booked by" . $traveler_name);

            $vCalendar->addComponent($booking_event);
        }

        header('Content-Type: text/calendar; charset=utf-8');
        header('Content-Disposition: attachment; filename="cal.ics"');
        echo $vCalendar->render();
    }
}
