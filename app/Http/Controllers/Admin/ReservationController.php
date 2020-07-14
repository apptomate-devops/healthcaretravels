<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use DB;
use App\Users;
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
            ->join('property_short_term_pricing', 'property_short_term_pricing.property_id', '=', 'property_list.id')
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
                'property_short_term_pricing.price_per_extra_guest',
                'property_short_term_pricing.*',
                'traveller.role_id as traveller_role',
                'traveller.name_of_agency',
            )
            ->get();

        // echo json_encode($data2);
        return view('Admin.reservations', compact('data'));
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
            ->join('property_short_term_pricing', 'property_short_term_pricing.property_id', '=', 'property_list.id')
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
            ->join(
                'property_short_term_pricing',
                'property_short_term_pricing.property_id',
                '=',
                'property_booking.property_id',
            )
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
