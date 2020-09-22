<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use DB;

class BookingController extends BaseController
{
    public function index(Request $request)
    {
        $limit = 100;
        $skip = ($request->page || 0) * $limit;

        $bookings = DB::table('property_booking')
            ->select(
                'property_booking.*',
                'owner.first_name as owner_first_name',
                'traveller.first_name as traveller_first_name',
                'owner.last_name as owner_last_name',
                'traveller.last_name as traveller_last_name',
                'property.title as property_title',
            )
            ->leftJoin('users as owner', 'owner.id', '=', 'property_booking.owner_id')
            ->leftJoin('users as traveller', 'traveller.id', '=', 'property_booking.traveller_id')
            ->leftJoin('property_list as property', 'property.id', '=', 'property_booking.property_id')
            ->orderBy('property_booking.id', 'desc')
            ->paginate(100);

        // $booking_count = DB::table('property_booking')->count();

        return view('Admin.bookings', compact('bookings'));
    }

    public function booking_details(Request $request)
    {
        $booking = DB::table('property_booking')
            ->select(
                'property_booking.*',
                'owner.first_name as owner_first_name',
                'traveller.first_name as traveller_first_name',
                'owner.last_name as owner_last_name',
                'traveller.last_name as traveller_last_name',
                'property.title as property_title',
            )
            ->leftJoin('users as owner', 'owner.id', '=', 'property_booking.owner_id')
            ->leftJoin('users as traveller', 'traveller.id', '=', 'property_booking.traveller_id')
            ->leftJoin('property_list as property', 'property.id', '=', 'property_booking.property_id')
            ->orderBy('property_booking.id', 'desc')
            ->where('property_booking.id', '=', $request->id)
            ->first();

        $booking_transactions = DB::table('booking_payments')
            ->where('booking_payments.booking_row_id', '=', $request->id)
            ->get();

        return view('Admin.booking_detail', compact('booking', 'booking_transactions'));
    }
}
