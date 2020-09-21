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
}
