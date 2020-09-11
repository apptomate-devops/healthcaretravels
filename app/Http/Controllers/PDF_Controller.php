<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Users;

class PDF_Controller extends BaseController
{
    public function invoice($booking_id, Request $request)
    {
        $data = DB::table('property_booking')
            ->join('property_list', 'property_list.id', '=', 'property_booking.property_id')
            ->join('property_booking_price', 'property_booking_price.property_booking_id', '=', 'property_booking.id')
            ->where('property_booking.client_id', CLIENT_ID)
            ->where('property_booking.booking_id', $booking_id)
            ->first();
        $traveller = DB::select("SELECT first_name,last_name FROM users WHERE id = $data->traveller_id");
        $data->traveller_name = $traveller[0]->first_name . " " . $traveller[0]->last_name;
        return view('pdf.invoice', ['data' => $data]);
    }
}
