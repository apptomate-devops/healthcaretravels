<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IcalController extends BaseController
{
    //
    public function ical($id, Request $request)
    {
        //
        $vCalendar = new \Eluceo\iCal\Component\Calendar(
            'https://holidaykeepers.com/ical/?ical=7958b1a42e0b57448e7cdaada56990c3',
        );
        $vEvent = new \Eluceo\iCal\Component\Event();
        $vEvent
            ->setDtStart(new \DateTime('2012-12-24'))
            ->setDtEnd(new \DateTime('2012-12-24'))
            ->setNoTime(true)
            ->setSummary('Christmas');
        $vCalendar->addComponent($vEvent);
        header('Content-Type: text/calendar; charset=utf-8');
        header('Content-Disposition: attachment; filename="cal.ics"');
        echo $vCalendar->render();
    }
}
