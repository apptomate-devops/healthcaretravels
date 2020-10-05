<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\PropertyBooking;
use App\Models\BookingPayments;

use DB;
use Helper;

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
        $booking = PropertyBooking::find($request->id);
        $owner = $booking->owner;
        $traveler = $booking->traveler;
        $property = $booking->property;
        if ($booking->cancelled_by == 'Admin') {
            $cancelled_by = 'Admin';
        } elseif ($booking->cancelled_by == $owner->id) {
            $cancelled_by = $owner->first_name . ' ' . $owner->last_name;
        } else {
            $cancelled_by = $traveler->first_name . ' ' . $traveler->last_name;
        }
        $booking_transactions = BookingPayments::where('booking_row_id', $request->id)->get();

        return view(
            'Admin.booking_detail',
            compact('booking', 'booking_transactions', 'owner', 'traveler', 'property', 'cancelled_by'),
        );
    }

    public function settle_deposit(Request $request)
    {
        $id = $request->id;
        $booking = PropertyBooking::find($id);
        if (empty($booking)) {
            return back()->with([('success')->false, 'errorMessage' => 'No such booking exists!']);
        }
        if ($booking->is_deposit_handled) {
            Logger::error('Security deposit was already handled: ' . $id);
            return back()->with(['success' => false, 'errorMessage' => 'Security deposit was already handled']);
        }
        if ($request->traveler_cut + $request->owner_cut != $booking->security_deposit) {
            return back()->with([
                'success' => false,
                'errorMessage' => 'Sum of owner and traveler cut should be equal to Security deposit',
            ]);
        }
        $booking->should_auto_deposit = 0;
        $booking->is_deposit_handled_by_admin = 1;
        $booking->traveler_cut = $request->traveler_cut;
        $booking->owner_cut = $request->owner_cut;
        $booking->admin_remarks = $request->admin_remarks;
        $booking->traveler_remarks = $request->traveler_remarks;
        $booking->owner_remarks = $request->owner_remarks;
        $booking->save();
        $res = Helper::processSecurityDepositForBooking($booking->id);
        return back()->with($res);
    }
}
