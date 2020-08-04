<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use DateTime;
use Session;
use App\Models\Users;
use App\Models\PropertyAminities;
use App\Models\PropertyList;
use App\Models\PropertyRating;
use App\Models\OwnerRating;
use App\Models\Couponecode;
use App\Models\PropertyBookingPrice;
use App\Models\EmailConfig;
use App\Models\GuestInformations;
use App\Models\Propertybooking;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Mail;

class PropertyController extends BaseController
{
    public function cancel_booking(Request $request, $id)
    {
        $user_id = $request->session()->get('user_id');
        if (!$user_id) {
            return redirect()->intended('login');
        }
        if ($request->session()->get('role_id') == 1) {
            $user_id = $request->session()->get('user_id');
            $user = DB::table('users')
                ->where('client_id', CLIENT_ID)
                ->where('id', $user_id)
                ->first();
            $booking = DB::table('property_booking')
                ->where('booking_id', $id)
                ->leftjoin('property_list', 'property_list.id', '=', 'property_booking.property_id')
                ->leftjoin('users', 'users.id', '=', 'property_booking.traveller_id')
                ->select(
                    'users.first_name',
                    'users.last_name',
                    'property_list.title',
                    'property_booking.*',
                    'users.email',
                )
                ->first();
            // print_r($booking);exit;
            $mail_data = [
                'owner_name' => $user->first_name . " " . $user->last_name,
                'booking_id' => $booking->booking_id,
                'property' => $booking->title,
                'start_date' => date("m-d-Y", strtotime($booking->start_date)),
                'end_date' => date("m-d-Y", strtotime($booking->end_date)),
                'mail_to' => 'admin',
                'traveler' => $booking->first_name . " " . $booking->last_name,
            ];
            // $this->send_email('guru@sparkouttech.com', 'mail.cancel_booking', $mail_data);
            $this->send_email('info@healthcaretravels.com', 'mail.cancel_booking', $mail_data);
            if ($booking->email) {
                $mail_data1 = [
                    'owner_name' => $user->first_name . " " . $user->last_name,
                    'booking_id' => $booking->booking_id,
                    'property' => $booking->title,
                    'start_date' => date("m-d-Y", strtotime($booking->start_date)),
                    'end_date' => date("m-d-Y", strtotime($booking->end_date)),
                    'mail_to' => 'traveller',
                    'traveler' => $booking->first_name . " " . $booking->last_name,
                ];
                $this->send_email($booking->email, 'mail.cancel_booking', $mail_data1);
            }

            if ($user->email) {
                $mail_data2 = [
                    'owner_name' => $user->first_name . " " . $user->last_name,
                    'booking_id' => $booking->booking_id,
                    'property' => $booking->title,
                    'start_date' => date("m-d-Y", strtotime($booking->start_date)),
                    'end_date' => date("m-d-Y", strtotime($booking->end_date)),
                    'mail_to' => 'owner',
                    'traveler' => $user->first_name . " " . $booking->last_name,
                ];
                $this->send_email($user->email, 'mail.cancel_booking', $mail_data2);
            }

            $upd = DB::table('property_booking')
                ->where('booking_id', $id)
                ->update(['status' => 8]);
        } else {
            $upd = DB::table('property_booking')
                ->where('booking_id', $id)
                ->update(['status' => 8]);
        }

        return back()->with('success', 'Booking Cancelled successfully!');
    }

    public function favorites(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $role_id = $request->session()->get('role_id');

        $properties = DB::table('user_favourites')
            ->join('property_list', 'property_list.id', '=', 'user_favourites.property_id')
            ->join(
                'property_short_term_pricing',
                'property_short_term_pricing.property_id',
                '=',
                'user_favourites.property_id',
            )
            ->join('property_room', 'property_room.property_id', '=', 'user_favourites.property_id')
            ->where('property_list.client_id', '=', CLIENT_ID)
            ->where('user_favourites.user_id', '=', $user_id)
            ->get();

        $properties_near = [];
        foreach ($properties as $property) {
            $property->description = substr($property->description, 0, 170);
            $property->description .= '...';
            $pd = DB::table('property_images')
                ->where('property_images.client_id', '=', CLIENT_ID)
                ->where('property_images.property_id', '=', $property->property_id)
                ->orderBy('property_images.sort', 'asc')
                ->get();

            foreach ($pd as $images) {
                $img_url = $images->image_url;
                $property->image_url = $img_url;
            }

            $propertys = [];
            $propertysd = [];
            $propertys['image_url'] = STATIC_IMAGE;
            if (count($pd) == 0) {
                $propertysd[] = $propertys;
                $property->property_images = $propertysd;
                $property->image_url = STATIC_IMAGE;
            } else {
                $property->property_images = $pd;
            }

            $properties_near[] = $property;
        }

        return view('owner.favourites', ['properties' => $properties_near, 'role_id' => $role_id]);
    }

    public function owner_update_booking(Request $request)
    {
        DB::table('property_booking')
            ->where('booking_id', $request->booking_id)
            ->update(['status' => $request->status]);
        if ($request->status == 4) {
            $booking = DB::table('property_booking')
                ->where('booking_id', $request->booking_id)
                ->leftjoin('property_list', 'property_list.id', '=', 'property_booking.property_id')
                ->leftjoin('users', 'users.id', '=', 'property_booking.traveller_id')
                ->select(
                    'users.first_name',
                    'users.last_name',
                    'property_list.title',
                    'property_booking.*',
                    'users.email',
                )
                ->first();
            $user = DB::table('users')
                ->where('client_id', CLIENT_ID)
                ->where('id', $booking->owner_id)
                ->first();
            $mail_data = [
                'owner_name' => $user->first_name . " " . $user->last_name,
                'booking_id' => $booking->booking_id,
                'property' => $booking->title,
                'mail_to' => 'traveller',
                'traveler' => $booking->first_name . " " . $booking->last_name,
            ];
            $this->send_email($booking->email, 'mail.cancel_booking', $mail_data);
        }
        return response()->json(['status' => 'SUCCESS']);
    }

    public function search_property(Request $request)
    {
        $request_data = $request->all();
        $room_types = DB::table('property_room_types')->get();
        $lat_lng = [];
        $lat_lng_url = urlencode(serialize($lat_lng));

        if ($request->formatted_address) {
            $request->place = $request->formatted_address;
        }
        $source_lat = $request->lat;
        $source_lng = $request->lng;
        $page = $request->page ?: 1;
        $items_per_page = 100;
        $offset = ($page - 1) * $items_per_page;
        $property_list_obj = new PropertyList();
        $query = $property_list_obj
            ->join('users', 'users.id', '=', 'property_list.user_id')
            ->join('property_room', 'property_room.property_id', '=', 'property_list.id')
            ->join('property_short_term_pricing', 'property_short_term_pricing.property_id', '=', 'property_list.id')
            ->select('property_list.*', 'property_room.*', 'property_short_term_pricing.*')
            ->where('property_list.is_complete', '=', ACTIVE)
            ->where('property_list.status', '=', 1)
            ->where('property_list.property_status', '=', 1);
        if (!empty($source_lng) && !empty($source_lat)) {
            $query
                ->selectRaw(
                    "(6371 * acos(cos(radians(" .
                        $source_lat .
                        "))* cos(radians(`lat`))
                            * cos(radians(`lng`) - radians(" .
                        $source_lng .
                        ")) + sin(radians(" .
                        $source_lat .
                        "))
                            * sin(radians(`lat`)))) as distance",
                )
                ->having('distance', '<=', RADIUS)
                ->orderBy('distance');
        }
        $where = [];
        if (Session::has('role_id')) {
            if (Session::get('role_id') == 3) {
                $where[] = 'property_list.property_type_rv_or_home = 1';
            } else {
                $where[] = 'property_list.property_type_rv_or_home = 2';
            }
        }
        if ($request->guests != "") {
            $where[] = 'property_list.total_guests >= "' . $request->guests . '" ';
        }
        if ($request->roomtype != "") {
            $where[] = 'property_list.room_type = "' . $request->roomtype . '" ';
        }
        if ($request->bookingmode != "") {
            $where[] = 'property_list.is_instant = "' . $request->bookingmode . '" ';
        }
        if ($request->minprice != "" && $request->maxprice != "") {
            $where[] =
                'property_short_term_pricing.price_per_night BETWEEN "' .
                $request->minprice .
                '" and "' .
                $request->maxprice .
                '" ';
        }

        if ($request->minprice != "" && $request->maxprice == "") {
            $where[] = 'property_short_term_pricing.price_per_night <= "' . $request->minprice . '" ';
        }
        if ($request->minprice == "" && $request->maxprice != "") {
            $where[] = 'property_short_term_pricing.price_per_night <= "' . $request->maxprice . '" ';
        }

        $dataWhere = implode(" and ", $where);
        if ($dataWhere != "") {
            $query->whereRaw($dataWhere);
        }
        $total_count = count($query->get());
        $query = $query->skip($offset)->take($items_per_page);
        $nearby_properties = $query->get();
        $total_properties = count($nearby_properties);
        foreach ($nearby_properties as $key => $value) {
            $image = DB::table('property_images')
                ->where('property_id', $value->property_id)
                ->first();
            $value->image_url = isset($image->image_url) ? $image->image_url : '';
        }
        return view('search_property')
            ->with('properties', $nearby_properties)
            ->with('total_count', $total_count)
            ->with('location_url', $lat_lng_url)
            ->with('request_data', $request_data)
            ->with('total_properties', $total_properties)
            ->with('next', $page)
            ->with('room_types', $room_types);
    }
}
