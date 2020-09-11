<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\BaseController;

class PaymentController extends BaseController
{
    public function completed_payment(Request $request)
    {
        # code...
        $data = DB::table('property_booking')
            ->join('property_booking_price', 'property_booking_price.property_booking_id', '=', 'property_booking.id')
            ->join('property_list', 'property_list.id', '=', 'property_booking.property_id')
            ->join('users as traveller', 'traveller.id', '=', 'property_booking.traveller_id')
            ->join('users as owner', 'owner.id', '=', 'property_booking.owner_id')
            ->join('property_room', 'property_room.property_id', '=', 'property_list.id')
            ->where('property_booking.payment_done', '=', ONE)
            ->select(
                'property_booking.*',
                'property_list.*',
                'property_booking_price.*',
                'traveller.profile_image as traveller_image',
                'owner.profile_image as owner_image',
                'owner.first_name as owner_fname',
                'owner.phone as phone',
                'traveller.first_name as traveller_fname',
                'owner.last_name as owner_lname',
                'traveller.last_name as traveller_lname',
                'property_booking.id as p_id',
                'property_booking.status as booking_status',
            )
            ->get();
        return view('Admin.completedpayment', compact('data'));
    }

    public function cancelledpayment(Request $request)
    {
        # code...
        $data = DB::table('property_booking')
            ->join('property_booking_price', 'property_booking_price.property_booking_id', '=', 'property_booking.id')
            ->join('property_list', 'property_list.id', '=', 'property_booking.property_id')
            ->join('users as traveller', 'traveller.id', '=', 'property_booking.traveller_id')
            ->join('users as owner', 'owner.id', '=', 'property_booking.owner_id')
            ->join('property_room', 'property_room.property_id', '=', 'property_list.id')
            ->where('property_booking.payment_done', '=', 2)
            ->select(
                'property_booking.*',
                'property_list.*',
                'property_booking_price.*',
                'traveller.profile_image as traveller_image',
                'owner.profile_image as owner_image',
                'owner.first_name as owner_fname',
                'owner.phone as phone',
                'owner.id as owner_id',
                'traveller.id as traveler_id',
                'traveller.first_name as traveller_fname',
                'owner.last_name as owner_lname',
                'traveller.last_name as traveller_lname',
                'property_booking.id as p_id',
                'property_booking.status as booking_status',
            )
            ->get();
        return view('Admin.cancelledpayment', compact('data'));
    }
}
