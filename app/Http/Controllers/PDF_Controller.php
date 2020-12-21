<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\BookingPayments;
use App\Models\PropertyBooking;
use Illuminate\Http\Request;
use DB;
use App\Models\Users;

class PDF_Controller extends BaseController
{
    public function invoice($booking_id, Request $request)
    {
        $data = DB::table('property_booking')
            ->join('property_list', 'property_list.id', '=', 'property_booking.property_id')
            ->where('property_booking.client_id', CLIENT_ID)
            ->where('property_booking.booking_id', $booking_id)
            ->select('property_booking.*', 'property_list.title')
            ->first();
        if (empty($data) || !in_array($data->status, [2, 3])) {
            return view('general_error', ['message' => 'Booking invoice you are looking for does not exists!']);
        }
        $user_id = $request->session()->get('user_id');
        $is_owner = $user_id == $data->owner_id ? 1 : 0;
        $user_role_id = DB::table('users')
            ->where('id', '=', $user_id)
            ->select('role_id')
            ->first();
        $data->role_id = isset($user_role_id) ? $user_role_id->role_id : 0;
        $payment_summary = PropertyController::get_payment_summary($data, $is_owner);
        $data->scheduled_payments = $payment_summary['scheduled_payments'];
        $data->grand_total = $payment_summary['grand_total'];
        $data->is_owner = $is_owner;

        if ($is_owner) {
            $owner = DB::table('users')
                ->where('id', $data->owner_id)
                ->select('first_name', 'last_name')
                ->first();
            $data->name = $owner->first_name . " " . $owner->last_name;
        } else {
            $traveller = DB::table('users')
                ->where('id', $data->traveller_id)
                ->select('first_name', 'last_name')
                ->first();
            $data->name = $traveller->first_name . " " . $traveller->last_name;
        }

        return view('pdf.invoice', ['data' => $data]);
    }
}
