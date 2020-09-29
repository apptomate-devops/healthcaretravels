<?php

namespace App\Http\Controllers\Admin;

use App\Models\PropertyBooking;
use App\Services\Logger;
use Illuminate\Http\Request;
use DB;
use App\Models\Users;
use App\Http\Controllers\BaseController;

class ReservationController extends BaseController
{
    public function index(Request $request)
    {
        # code...
        $data = DB::table('property_booking')
            ->join('property_booking_price', 'property_booking_price.property_booking_id', '=', 'property_booking.id')
            ->join('property_list', 'property_list.id', '=', 'property_booking.property_id')
            ->join('users as traveller', 'traveller.id', '=', 'property_booking.traveller_id')
            ->join('users as owner', 'owner.id', '=', 'property_booking.owner_id')
            ->join('property_room', 'property_room.property_id', '=', 'property_list.id')
            ->where('property_booking.is_instant', '=', ZERO)
            ->where('property_booking.status', '>=', 2)
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
                'traveller.role_id as traveller_role',
                'traveller.name_of_agency',
            )
            ->get();

        // echo json_encode($data2);
        return view('Admin.reservations', compact('data'));
    }

    public function cancellation_requests(Request $request)
    {
        $data = DB::table('property_booking')
            ->join('users as traveller', 'traveller.id', '=', 'property_booking.traveller_id')
            ->join('users as owner', 'owner.id', '=', 'property_booking.owner_id')
            ->leftjoin('users as requester', 'requester.id', '=', 'property_booking.cancelled_by')
            ->where('property_booking.cancellation_requested', '>=', 1)
            ->select(
                'property_booking.*',
                'owner.first_name as owner_first_name',
                'owner.last_name as owner_last_name',
                'traveller.first_name as traveller_first_name',
                'traveller.last_name as traveller_last_name',
                'requester.first_name as requester_first_name',
                'requester.last_name as requester_last_name',
                'property_booking.id as p_id',
            )
            ->get();
        return view('Admin.cancellation_requests', compact('data'));
    }

    public function cancellation_request_details(Request $request)
    {
        $data = PropertyBooking::where('booking_id', $request->booking_id)->first();
        if (empty($data)) {
            return back()->withErrors(['Booking you are looking for does not exists!']);
        }
        $booking = PropertyBooking::find($data->id);
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
        return view(
            'Admin.cancellation_request_details',
            compact('booking', 'property', 'traveler', 'owner', 'cancelled_by'),
        );
    }

    public function update_cancellation_request_status(Request $request)
    {
        $data = PropertyBooking::where('booking_id', $request->booking_id)->first();
        $status = $request->status;
        if (empty($data)) {
            return back()->with(['success' => false, 'errorMessage' => 'Booking you are looking for does not exists!']);
        }
        if ($status == 2) {
            $refund_amount = $request->refund_amount;
            // TODO: Process refund for cancellation
        }

        PropertyBooking::where('booking_id', $request->booking_id)->update(['cancellation_requested' => $status]);
        return back()->with([
            'success' => true,
            'successMessage' => 'Status updated Successfully!!!',
        ]);
    }

    public function booking_cancellation_admin(Request $request)
    {
        $data = PropertyBooking::where('booking_id', $request->booking_id)->first();
        $status = 2;
        if (empty($data)) {
            return back()->with([
                'success_cancel_booking' => false,
                'errorMessage' => 'Booking you are looking for does not exists!',
            ]);
        }

        $refund_amount = $request->refund_amount;
        // TODO: Process refund for cancellation

        PropertyBooking::where('booking_id', $request->booking_id)->update([
            'cancellation_requested' => $status,
            'cancellation_reason' => $request->cancellation_reason,
            'cancellation_explanation' => $request->cancellation_explanation,
            'cancelled_by' => 'Admin',
            'already_checked_in' => $request->checked_in,
        ]);

        // send email to traveller/owner if admin cancels request

        $bookingModel = PropertyBooking::find($data->id);
        $owner = $bookingModel->owner;
        $traveller = $bookingModel->traveler;
        $property = $bookingModel->property;

        $title = APP_BASE_NAME . "Admin cancelled booking";
        $subject = "Booking Cancelled";
        $mail_data = [
            'property_title' => $property->title,
            'check_in' => date('d-m-Y', strtotime($data->start_date)),
            'check_out' => date('d-m-Y', strtotime($data->check_out)),
            'traveler_name' => $traveller->username,
            'owner_name' => $owner->username,
        ];
        $this->send_custom_email($owner->email, $subject, 'mail.admin-cancel-booking', $mail_data, $title);
        $this->send_custom_email($traveller->email, $subject, 'mail.admin-cancel-booking', $mail_data, $title);

        return back()->with([
            'success_cancel_booking' => true,
            'successMessage' => 'Booking cancelled Successfully!!!',
        ]);
    }

    public function booking_status_update(Request $request)
    {
        $update = DB::table('property_booking')
            ->where('booking_id', $request->id)
            ->update(['payment_done' => $request->status]);
        return response()->json(['status' => true, 'success_message' => 'Status updated successfully']);
    }

    public function send_invoice($booking_id, $property_id)
    {
        DB::table('property_booking')
            ->where('booking_id', $booking_id)
            ->update(['status' => 3]);
        $property = DB::table('property_list')
            ->leftjoin('users', 'users.id', '=', 'property_list.user_id')
            ->where('property_list.id', '=', $property_id)
            ->get();
        $property->images = DB::table('property_images')
            ->where('property_images.property_id', '=', $property_id)
            ->select('image_url')
            ->orderBy('property_images.sort', 'asc')
            ->get();

        $property->aminities = DB::table('property_amenties')
            ->where('property_amenties.property_id', '=', $property_id)
            ->get();
        $data = DB::table('property_booking')
            ->join('property_list', 'property_list.id', '=', 'property_booking.property_id')
            ->join('property_images', 'property_images.property_id', '=', 'property_booking.property_id')
            ->join('property_booking_price', 'property_booking_price.property_booking_id', '=', 'property_booking.id')
            ->where('property_booking.client_id', CLIENT_ID)
            ->where('property_booking.booking_id', $booking_id)
            ->first();
        $traveller = DB::select(
            "SELECT concat(first_name,last_name) as name,email FROM users WHERE id = $data->traveller_id",
        );
        // print_r($traveller);exit;
        $data->traveller_name = $traveller[0]->name;

        $mail_data = [
            'name' => $data->traveller_name,
            'text' => '',
            'property' => $property,
            'data' => $data,
            'text' => '',
        ];

        $title = APP_BASE_NAME . ' - Sent you an Invoice';
        $subject = APP_BASE_NAME . ' - Sent you an Invoice';
        $this->send_custom_email($traveller[0]->email, $subject, 'mail.invoice-mail', $mail_data, $title);
        return redirect('admin/reservations');
    }
}
