<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use DateTime;
use Session;
use App\Models\Users;
use App\Models\Propertyamenties;
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
    public function __construct(Users $users, PropertyList $property_list)
    {
        $this->users = $users;
        $this->property_list = $property_list;
    }
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

    public function inbox_traveller(Request $request)
    {
        $user_id = $request->session()->get('user_id');

        $request_chats = DB::table('request_chat')
            ->where('client_id', '=', CLIENT_ID)
            ->where('request_chat.traveller_id', '=', $user_id)
            ->get();
        foreach ($request_chats as $request_chat) {
            $request_chat->traveller = DB::table('users')
                ->where('client_id', '=', CLIENT_ID)
                ->where('id', $request_chat->traveller_id)
                ->first();
            $request_chat->owner = DB::table('users')
                ->where('client_id', '=', CLIENT_ID)
                ->where('id', $request_chat->owner_id)
                ->first();
            $request_chat->chat_key = 'request_chat';
            $request_chat->last_message = $this->get_firebase_last_message('request_chat', $request_chat->id);
        }

        $instant_chats = DB::table('instant_chat')
            ->where('client_id', '=', CLIENT_ID)
            ->where('instant_chat.traveller_id', '=', $user_id)
            ->get();
        foreach ($instant_chats as $request_chat) {
            $request_chat->traveller = DB::table('users')
                ->where('client_id', '=', CLIENT_ID)
                ->where('id', $request_chat->traveller_id)
                ->first();
            $request_chat->owner = DB::table('users')
                ->where('client_id', '=', CLIENT_ID)
                ->where('id', $request_chat->owner_id)
                ->first();
            $request_chat->chat_key = 'instant_chat';
            $request_chat->last_message = $this->get_firebase_last_message('instant_chat', $request_chat->id);
        }

        $personal_chats = DB::table('personal_chat')
            ->where('client_id', '=', CLIENT_ID)
            ->where('personal_chat.traveller_id', '=', $user_id)
            ->where('traveler_visible', 1)
            ->get();
        foreach ($personal_chats as $request_chat) {
            $request_chat->traveller = DB::table('users')
                ->where('client_id', '=', CLIENT_ID)
                ->where('id', $request_chat->traveller_id)
                ->first();
            $request_chat->owner = DB::table('users')
                ->where('client_id', '=', CLIENT_ID)
                ->where('id', $request_chat->owner_id)
                ->first();
            $request_chat->chat_key = 'personal_chat';
            $request_chat->last_message = $this->get_firebase_last_message('personal_chat', $request_chat->id);
        }

        $results = [];
        $results[] = $request_chats;
        $results[] = $instant_chats;
        $results[] = $personal_chats;

        $f_result = $results[0];

        return view('traveller.inbox-listing', ['properties' => $results]);
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

    public function traveller_fire_chat($id, Request $request)
    {
        if ($request->fbkey == "personal_chat") {
            $property = DB::table('personal_chat')
                ->where('id', $id)
                ->first();
            // echo json_encode($property);exit;
            $traveller = DB::table('users')
                ->where('client_id', '=', CLIENT_ID)
                ->where('id', $property->traveller_id)
                ->first();
            $owner = DB::table('users')
                ->where('client_id', '=', CLIENT_ID)
                ->where('id', $property->owner_id)
                ->first();
            return view('traveller.fire_chat', [
                'owner' => $owner,
                'traveller' => $traveller,
                'id' => $id,
                'traveller_id' => $property->traveller_id,
            ]);
        }
        if ($request->fbkey == "request_chat") {
            $property = DB::table('request_chat')
                ->where('id', $id)
                ->first();
            $traveller = DB::table('users')
                ->where('client_id', '=', CLIENT_ID)
                ->where('id', $property->traveller_id)
                ->first();

            $owner = DB::table('users')
                ->where('client_id', '=', CLIENT_ID)
                ->where('id', $property->owner_id)
                ->first();
            //dd($owner->id);
            return view('traveller.fire_chat', [
                'owner' => $owner,
                'traveller' => $traveller,
                'id' => $id,
                'traveller_id' => $traveller->id,
                'owner_id' => $owner->id,
            ]);
        }
        $property = DB::table('property_booking')
            ->where('client_id', '=', CLIENT_ID)
            ->where('id', $id)
            ->first();
        $traveller = DB::table('users')
            ->where('client_id', '=', CLIENT_ID)
            ->where('id', $property->traveller_id)
            ->first();
        $owner = DB::table('users')
            ->where('client_id', '=', CLIENT_ID)
            ->where('id', $property->owner_id)
            ->first();
        //echo json_encode($traveller); exit;

        return view('traveller.fire_chat', ['owner' => $owner, 'traveller' => $traveller, 'id' => $id]);
    }

    public function add_property(Request $request)
    {
        $client_id = CLIENT_ID;
        $property_id = $request->session()->get('property_id');
        if ($property_id) {
            $property_details = DB::table('property_list')
                ->where('client_id', '=', CLIENT_ID)
                ->where('id', '=', $property_id)
                ->first();
            return view('owner.add_property')
                ->with('client_id', $client_id)
                ->with('property_details', $property_details);
        } else {
            return view('owner.add_property')->with('client_id', $client_id);
        }
    }

    public function add_new_property(Request $request)
    {
        if (!$request->user_id) {
            $request->user_id = $request->session()->get('user_id');
        }

        $property_id = $request->session()->get('property_id');
        if ($property_id) {
            $new_property = PropertyList::find($property_id);
        } else {
            $new_property = new PropertyList();
        }
        $new_property->client_id = $request->client_id;
        $new_property->user_id = $request->user_id;

        $new_property->address = $request->streetname ? $request->streetname : "";
        $new_property->location = urldecode($request->mlocation);
        $new_property->city = $request->city;
        $new_property->state = $request->state;
        $new_property->building_number = $request->building_number;
        $new_property->zip_code = $request->zip_code;
        $new_property->stage = 1;

        //Get LatLong From Address
        $address =
            $request->location .
            "," .
            $new_property->address .
            "," .
            $new_property->city .
            "," .
            $new_property->state .
            "," .
            $new_property->zip_code;
        $formattedAddr = str_replace(' ', '+', $address);

        if ($request->mlat != "") {
            $new_property->lat = $request->mlat;
        }

        if ($request->mlng != "") {
            $new_property->lng = $request->mlng;
        }

        $new_property->save();

        if (isset($request->save)) {
            session()->forget('property_id');
            $url = BASE_URL . "owner/calender?id=" . $new_property->id;
        } else {
            $url = BASE_URL . 'owner/add-new-property/2/' . $new_property->id;
        }

        return redirect($url);
    }

    public function property_next($stage, $property_id, Request $request)
    {
        //ical
        $property_details = DB::table('property_list')
            ->where('client_id', '=', CLIENT_ID)
            ->where('id', '=', $property_id)
            ->first();
        $request->session()->put('property_id', $property_id);
        if (!$property_details) {
            return back()->with('error', 'Wrong information try again');
        }
        switch ($stage) {
            case 2:
                $property_room = DB::table('property_room')
                    ->where('property_id', $property_id)
                    ->first();
                $property_data = DB::table('property_list')
                    ->where('client_id', '=', CLIENT_ID)
                    ->where('id', '=', $property_id)
                    ->first();
                $stage_update = DB::table('property_list')
                    ->where('client_id', '=', CLIENT_ID)
                    ->where('id', '=', $property_id)
                    ->update(['on_stage' => 2]);

                $room_types = DB::table('property_room_types')->get();
                $property_types = DB::table('property_types')->get();
                $client_id = CLIENT_ID;
                //code to be executed if n=label1; ->with('stage',$stage)
                $property_bedrooms = DB::table('property_bedrooms')
                    ->where('property_id', $property_id)
                    ->where('is_common_space', 0)
                    ->select(
                        DB::raw('GROUP_CONCAT(bed_type) as bed_types'),
                        DB::raw('GROUP_CONCAT(count) as counts'),
                        'bedroom_number',
                        DB::raw('SUM(count) as total'),
                    )
                    ->groupBy('bedroom_number')
                    ->get();

                $common_space = DB::table('property_bedrooms')
                    ->where('property_id', $property_id)
                    ->where('is_common_space', '!=', 0)
                    ->select(
                        DB::raw('GROUP_CONCAT(bed_type) as bed_types'),
                        DB::raw('GROUP_CONCAT(count) as counts'),
                        'bedroom_number',
                        DB::raw('SUM(count) as total'),
                    )
                    ->groupBy('bedroom_number')
                    ->get();

                //print_r($common_space);
                // print_r($property_bedrooms); exit;
                $final = [];
                foreach ($property_bedrooms as $val) {
                    $final[$val->bedroom_number] = [];
                    $bed_type = explode(",", $val->bed_types);
                    $bed_count = explode(",", $val->counts);
                    for ($i = 0; $i < count($bed_type); $i++) {
                        if ($bed_type[$i] == "double_bed") {
                            $final[$val->bedroom_number]['double_bed'] = $bed_count[$i];
                        }
                        if ($bed_type[$i] == "queen_bed") {
                            $final[$val->bedroom_number]['queen_bed'] = $bed_count[$i];
                        }
                        if ($bed_type[$i] == "single_bed") {
                            $final[$val->bedroom_number]['single_bed'] = $bed_count[$i];
                        }
                        if ($bed_type[$i] == "sofa_bed") {
                            $final[$val->bedroom_number]['sofa_bed'] = $bed_count[$i];
                        }
                        if ($bed_type[$i] == "bunk_bed") {
                            $final[$val->bedroom_number]['bunk_bed'] = $bed_count[$i];
                        }
                    }
                    $final[$val->bedroom_number]["total"] = $val->total;
                    $bed_type = [];
                    $bed_count = [];
                }

                //$common_spc=array();
                if (count($common_space) > 0) {
                    $c_beds = explode(",", $common_space[0]->bed_types);
                    $c_count = explode(",", $common_space[0]->counts);
                    //print_r($c_count);
                    for ($i = 0; $i < count($c_beds); $i++) {
                        if ($c_beds[$i] == "queen_bed") {
                            $common_spc['queen_bed'] = $c_beds[$i];
                            $common_spc['queen_bed'] = $c_count[$i];
                        }
                        if ($c_beds[$i] == "double_bed") {
                            $common_spc['double_bed'] = $c_beds[$i];
                            $common_spc['double_bed'] = $c_count[$i];
                        }
                        if ($c_beds[$i] == "single_bed") {
                            $common_spc['single_bed'] = $c_beds[$i];
                            $common_spc['single_bed'] = $c_count[$i];
                        }
                        if ($c_beds[$i] == "sofa_bed") {
                            $common_spc['sofa_bed'] = $c_beds[$i];
                            $common_spc['sofa_bed'] = $c_count[$i];
                        }
                        if ($c_beds[$i] == "bunk_bed") {
                            $common_spc['bunk_bed'] = $c_beds[$i];
                            $common_spc['bunk_bed'] = $c_count[$i];
                        }
                        $common_spc['total'] = $common_space[0]->total;
                    }
                }

                //print_r($final);exit;

                // print_r($property_details);exit;
                //print_r($final);exit;
                $array = json_decode(json_encode($property_bedrooms), true);
                $guest_count = DB::table('settings')
                    ->where('param', 'guest_count')
                    ->select('value')
                    ->first();
                $bed_count = DB::table('settings')
                    ->where('param', 'bedroom_count')
                    ->select('value')
                    ->first();
                //print_r($common_spc);exit;

                // print_r($property_data);exit;
                return view('owner.add-property.2', [
                    'property_details' => $property_details,
                    'property_room' => $property_room,
                ])
                    ->with('stage', $stage)
                    ->with('property_data', $property_data)
                    ->with('client_id', $client_id)
                    ->with('room_types', $room_types)
                    ->with('property_types', $property_types)
                    ->with('property_bedrooms', $final)
                    ->with('common_spc', isset($common_spc) ? $common_spc : [])
                    ->with('guest_count', isset($guest_count->value) ? $guest_count->value : '')
                    ->with('bed_count', isset($bed_count->value) ? $bed_count->value : '');

                break;

            case 3:
                $property_data = DB::table('property_list')
                    ->where('client_id', '=', CLIENT_ID)
                    ->where('id', '=', $property_id)
                    ->first();

                $stage_update = DB::table('property_list')
                    ->where('client_id', '=', CLIENT_ID)
                    ->where('id', '=', $property_id)
                    ->update(['on_stage' => 3]);
                $client_id = CLIENT_ID;
                //code to be executed if n=label2;
                return view('owner.add-property.3', ['property_details' => $property_details])
                    ->with('stage', $stage)
                    ->with('property_data', $property_data)
                    ->with('client_id', $client_id);
                break;

            case 4:
                $stage_update = DB::table('property_list')
                    ->where('client_id', '=', CLIENT_ID)
                    ->where('id', '=', $property_id)
                    ->update(['on_stage' => 4]);
                $property_data = DB::table('property_list')
                    ->where('client_id', '=', CLIENT_ID)
                    ->where('id', '=', $property_id)
                    ->first();

                $price = DB::table('property_short_term_pricing')
                    ->where('property_id', $request->property_id)
                    ->first();
                // print_r($price);exit;
                $client_id = CLIENT_ID;
                //code to be executed if n=label3;
                return view('owner.add-property.4', [
                    'price' => $price,
                    'property_details' => $property_details,
                    'property_data' => $property_data,
                ])
                    ->with('stage', $stage)
                    ->with('client_id', $client_id);
                break;

            case 5:
                $stage_update = DB::table('property_list')
                    ->where('client_id', '=', CLIENT_ID)
                    ->where('id', '=', $property_id)
                    ->update(['on_stage' => 5]);
                $client_id = CLIENT_ID;
                $property_images = DB::table('property_images')
                    ->where('client_id', '=', CLIENT_ID)
                    ->where('property_id', '=', $property_id)
                    ->get();
                //code to be executed if n=label3;
                $country = DB::table('country')
                    ->where('client_id', '=', CLIENT_ID)
                    ->get();
                $state = DB::table('state')
                    ->where('client_id', '=', CLIENT_ID)
                    ->get();
                //var_dump($property_details); exit;
                return view('owner.add-property.5', [
                    'property_details' => $property_details,
                    'country' => $country,
                    'state' => $state,
                ])
                    ->with('stage', $stage)
                    ->with('client_id', $client_id)
                    ->with('property_images', $property_images);
                break;

            case 6:
                $amenties = Propertyamenties::where('property_id', $property_id)->get();
                $stage_update = DB::table('property_list')
                    ->where('client_id', '=', CLIENT_ID)
                    ->where('id', '=', $property_id)
                    ->update(['on_stage' => 6]);
                $client_id = CLIENT_ID;
                //code to be executed if n=label3;
                // print_r($amenties);exit;
                return view('owner.add-property.6', ['amenties' => $amenties, 'property_details' => $property_details])
                    ->with('stage', $stage)
                    ->with('client_id', $client_id);
                break;

            case 7:
                $events = DB::table('property_booking')
                    ->where('client_id', '=', CLIENT_ID)
                    ->where('property_id', '=', $property_id)
                    ->get();
                $stage_update = DB::table('property_list')
                    ->where('client_id', '=', CLIENT_ID)
                    ->where('id', '=', $property_id)
                    ->update(['on_stage' => 7]);
                $client_id = CLIENT_ID;
                $constants = $this->constants();
                //code to be executed if n=label3;
                return view('owner.add-property.7', [
                    'constants' => $constants,
                    'property_details' => $property_details,
                    'events' => $events,
                ])
                    ->with('stage', $stage)
                    ->with('client_id', $client_id);
                break;

            default:
                //code to be executed if n is different from all labels;
                return back()->with('error', 'Wrong information try again');
        }
    }

    public function property_next2(Request $request)
    {
        // print_r($request->all());exit;
        // print_r($request->all());exit;
        //$new_property = App\PropertyList::find($request->property_id); //new PropertyList($request->property_id);
        DB::table('property_bedrooms')
            ->where('client_id', CLIENT_ID)
            ->where('property_id', $request->property_id)
            ->delete();
        DB::table('property_room')
            ->where('client_id', CLIENT_ID)
            ->where('property_id', $request->property_id)
            ->delete();
        $request->check_in_time = date("H:i:s", strtotime($request->check_in_time));
        $request->check_out_time = date("H:i:s", strtotime($request->check_out_time));
        $countbed = $request->bed_count != "" ? $request->bed_count : 0;
        if (isset($request->room_type) && $request->room_type == "Entire Room") {
            $request->cur_adults = 0;
            $request->cur_child = 0;
            $request->cur_pets = 0;
        }

        DB::table('property_list')
            ->where('id', $request->property_id)
            ->update([
                'room_type' => $request->room_type,
                'property_category' => $request->property_type,
                'property_size' => $request->property_size,
                'total_guests' => $request->guest_count,
                'cur_adults' => $request->cur_adults,
                'cur_child' => $request->cur_child,
                'cur_pets' => $request->cur_pets,
                'stage' => 2,
            ]);

        $property_room = DB::table('property_room')->insert([
            'client_id' => CLIENT_ID,
            'property_id' => $request->property_id,
            'property_size' => $request->property_size ? $request->property_size : 0,
            'bathroom_count' => $request->bathroom_count ? $request->bathroom_count : 0,
            'check_in_time' => $request->check_in_time ? $request->check_in_time : 0,
            'check_out_time' => $request->check_out_time ? $request->check_out_time : 0,
            //'bedroom_count' => $request->no_of_bedrooms,
            'bedroom_count' => count($request->double_bed),
            'bed_count' => $request->bed_count,
            'common_spaces' => $request->common_spaces ? $request->common_spaces : 0,
            'status' => ACTIVE,
        ]);

        for ($i = 0; $i < $request->no_of_bedrooms; $i++) {
            if (isset($request->double_bed[$i])) {
                $double_bed = DB::table('property_bedrooms')->insert([
                    'client_id' => CLIENT_ID,
                    'property_id' => $request->property_id,
                    'bedroom_number' => $i + 1,
                    'bed_type' => "double_bed",
                    'count' => $request->double_bed[$i],
                    'status' => ACTIVE,
                ]);
            }
            if (isset($request->queen_bed[$i])) {
                $double_bed = DB::table('property_bedrooms')->insert([
                    'client_id' => CLIENT_ID,
                    'property_id' => $request->property_id,
                    'bedroom_number' => $i + 1,
                    'bed_type' => "queen_bed",
                    'count' => $request->queen_bed[$i],
                    'status' => ACTIVE,
                ]);
            }
            if (isset($request->single_bed[$i])) {
                $double_bed = DB::table('property_bedrooms')->insert([
                    'client_id' => CLIENT_ID,
                    'property_id' => $request->property_id,
                    'bedroom_number' => $i + 1,
                    'bed_type' => "single_bed",
                    'count' => $request->single_bed[$i],
                    'status' => ACTIVE,
                ]);
            }
            if (isset($request->sofa_bed[$i])) {
                $double_bed = DB::table('property_bedrooms')->insert([
                    'client_id' => CLIENT_ID,
                    'property_id' => $request->property_id,
                    'bedroom_number' => $i + 1,
                    'bed_type' => "sofa_bed",
                    'count' => $request->sofa_bed[$i],
                    'status' => ACTIVE,
                ]);
            }
            if (isset($request->bunk_bed[$i])) {
                $double_bed = DB::table('property_bedrooms')->insert([
                    'client_id' => CLIENT_ID,
                    'property_id' => $request->property_id,
                    'bedroom_number' => $i + 1,
                    'bed_type' => "bunk_bed",
                    'count' => $request->bunk_bed[$i],
                    'status' => ACTIVE,
                ]);
            }

            // common spaces start c_double_bed":["1"],"c_queen_bed":["1"],"c_single_bed":["1"],"c_sofa_bed":[null],"c_bunk_bed":
            if ($i == BLOCK) {
                if ($request->c_double_bed[$i]) {
                    $double_bed = DB::table('property_bedrooms')->insert([
                        'client_id' => CLIENT_ID,
                        'property_id' => $request->property_id,
                        'bedroom_number' => $i + 1,
                        'bed_type' => "double_bed",
                        'count' => $request->c_double_bed[$i],
                        'is_common_space' => ACTIVE,
                        'status' => ACTIVE,
                    ]);
                }
                if ($request->c_queen_bed[$i]) {
                    $double_bed = DB::table('property_bedrooms')->insert([
                        'client_id' => CLIENT_ID,
                        'property_id' => $request->property_id,
                        'bedroom_number' => $i + 1,
                        'bed_type' => "queen_bed",
                        'count' => $request->c_queen_bed[$i],
                        'is_common_space' => ACTIVE,
                        'status' => ACTIVE,
                    ]);
                }
                if ($request->c_single_bed[$i]) {
                    $double_bed = DB::table('property_bedrooms')->insert([
                        'client_id' => CLIENT_ID,
                        'property_id' => $request->property_id,
                        'bedroom_number' => $i + 1,
                        'bed_type' => "single_bed",
                        'count' => $request->c_single_bed[$i],
                        'is_common_space' => ACTIVE,
                        'status' => ACTIVE,
                    ]);
                }
                if ($request->c_sofa_bed[$i]) {
                    $double_bed = DB::table('property_bedrooms')->insert([
                        'client_id' => CLIENT_ID,
                        'property_id' => $request->property_id,
                        'bedroom_number' => $i + 1,
                        'bed_type' => "sofa_bed",
                        'count' => $request->c_sofa_bed[$i],
                        'is_common_space' => ACTIVE,
                        'status' => ACTIVE,
                    ]);
                }
                if ($request->c_bunk_bed[$i]) {
                    $double_bed = DB::table('property_bedrooms')->insert([
                        'client_id' => CLIENT_ID,
                        'property_id' => $request->property_id,
                        'bedroom_number' => $i + 1,
                        'bed_type' => "bunk_bed",
                        'count' => $request->c_bunk_bed[$i],
                        'is_common_space' => ACTIVE,
                        'status' => ACTIVE,
                    ]);
                }
            }

            // common spaces end
        }

        $file_name = 'data/' . $request->property_id . '.json';
        if (file_exists($file_name)) {
            unlink($file_name);
        }
        if (isset($request->save)) {
            session()->forget('property_id');
            $url = BASE_URL . "owner/calender?id=" . $request->property_id;
        } else {
            $url = BASE_URL . 'owner/add-new-property/3/' . $request->property_id;
        }
        return redirect($url);
    }

    public function property_next3(Request $request)
    {
        // print_r($request->all());exit;
        // $insert = DB::table('property_video')
        //         ->insert(['client_id' => CLIENT_ID, 'property_id' => $request->property_id, 'source' => $request->source, 'url' => $request->url, 'sort' => 1, 'status' => 1,]);
        $trash_pickup_days = "";
        if ($request->trash_pickup_days) {
            $trash_pickup_days = implode(',', $request->trash_pickup_days);
        }

        $update = DB::table('property_list')
            ->where('id', $request->property_id)
            ->update([
                'title' => $request->title,
                'description' => $request->description,
                'trash_pickup_days' => $trash_pickup_days,
                'lawn_service' => $request->lawn_service,
                'pets_allowed' => $request->pets_allowed,
                'property_type_rv_or_home' => $request->property_type,
            ]);

        $prop = DB::table('property_list')
            ->where('id', $request->property_id)
            ->first();
        if ($prop->on_stage < 3) {
            $update_on_stage = $this->propertyList->where('id', $request->property_id)->update(['on_stage' => 3]);
        }

        $url = BASE_URL . 'owner/add-new-property/4/' . $request->property_id;
        return redirect($url);
    }

    public function property_next4(Request $request)
    {
        //print_r($request->all());exit;

        DB::table('property_list')
            ->where('id', $request->property_id)
            ->update(['cancellation_policy' => $request->cancellation_policy, 'min_days' => $request->minimumstay]);

        // echo $request->booking_type;exit;
        // if ($request->booking_type) {
        //  echo $request->booking_type;exit;

        // }
        $request->booking_type = (int) $request->booking_type;
        $update_on_stage = DB::table('property_list')
            ->where('id', $request->property_id)
            ->update(['is_instant' => $request->booking_type]);

        $ins = [];
        $ins['client_id'] = CLIENT_ID;
        $ins['property_id'] = $request->property_id;
        $ins['price_per_night'] = $request->price_per_night;
        // $ins['price_more_than_one_week'] = $request->price_more_than_one_week;
        $ins['price_more_than_one_month'] = $request->price_more_than_one_month;
        // $ins['price_per_weekend'] = $request->price_per_weekend;

        // $ins['weekend_days'] = implode(",",$request->weekendays);
        // $ins['tax'] = $request->tax;
        // $ins['cleaning_fee'] = $request->cleaning_fee;
        // $ins['cleaning_fee_type'] = (string) $request->cleaning_fee_type;
        $ins['city_fee'] = $request->city_fee;
        $ins['city_fee_type'] = $request->city_fee_type;
        $ins['is_extra_guest'] = $request->is_extra_guest ? $request->is_extra_guest : '0';
        $ins['price_per_extra_guest'] = $request->price_per_extra_guest;
        $ins['security_deposit'] = $request->security_deposit;
        $ins['check_in'] = $request->check_in;
        $ins['check_out'] = $request->check_out;
        DB::table('property_list')
            ->where('client_id', '=', CLIENT_ID)
            ->where('id', $request->property_id)
            ->update(['house_rules' => $request->house_rules]);
        $val_count = DB::table('property_short_term_pricing')
            ->where('property_id', $request->property_id)
            ->count();
        if ($val_count == ZERO) {
            $insert = DB::table('property_short_term_pricing')->insert($ins);
            DB::table('property_list')
                ->where('id', $request->property_id)
                ->update(['cleaning_type' => $request->cleaning_fee_type]);
            $msg = "Price added successfully";
            $update_on_stage = DB::table('property_list')
                ->where('id', $request->property_id)
                ->update(['on_stage' => 4]);
        } else {
            $update = DB::table('property_short_term_pricing')
                ->where('property_id', $request->property_id)
                ->update($ins);
            DB::table('property_list')
                ->where('id', $request->property_id)
                ->update(['cleaning_type' => $request->cleaning_fee_type]);
            $msg = "Price updated successfully";
        }

        $url = BASE_URL . 'owner/add-new-property/6/' . $request->property_id;
        return redirect($url);
    }

    public function property_next5(Request $request)
    {
        $insert = DB::table('property_list')
            ->where('id', $request->property_id)
            ->update([
                'country' => $request->country_id,
                'state' => $request->state_id,
                'address' => $request->address,
                'zip_code' => $request->zip,
                'lat' => $request->lat,
                'lng' => $request->lng,
                'status' => 1,
                'stage' => 5,
            ]);

        if (isset($request->save)) {
            session()->forget('property_id');
            $url = BASE_URL . "owner/calender?id=" . $request->property_id;
        } else {
            $url = BASE_URL . 'owner/add-new-property/6/' . $request->property_id;
        }

        return redirect($url);
    }

    public function property_next6(Request $request)
    {
        //
        // print_r($request->all());exit;

        DB::table('property_amenties')
            ->where('client_id', CLIENT_ID)
            ->where('property_id', $request->property_id)
            ->delete();
        if ($request->Kitchen) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Kitchen';
            $property_aminities->amenties_icon = 'kitchen_icon';
            $property_aminities->save();
        }
        if ($request->internet) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Internet';
            $property_aminities->amenties_icon = 'Internet_icon';
            $property_aminities->save();
        }
        if ($request->smoking_allowed) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Smoking Allowed';
            $property_aminities->amenties_icon = 'Smoking_Allowed_icon';
            $property_aminities->save();
        }
        if ($request->tv) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Tv';
            $property_aminities->amenties_icon = 'Tv_icon';
            $property_aminities->save();
        }
        if ($request->wheelchair_accessible) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Wheelchair Accessible';
            $property_aminities->amenties_icon = 'Wheelchair_Accessible_icon';
            $property_aminities->save();
        }
        if ($request->elevator_in_building) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Elevator in Building';
            $property_aminities->amenties_icon = 'Elevator_in_building_icon';
            $property_aminities->save();
        }
        if ($request->indoor_fireplace) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Indoor Fireplace';
            $property_aminities->amenties_icon = 'Indoor_Fireplace_icon';
            $property_aminities->save();
        }
        if ($request->heating) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Heating';
            $property_aminities->amenties_icon = 'Heating_icon';
            $property_aminities->save();
        }
        if ($request->essentials) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Essentials';
            $property_aminities->amenties_icon = 'Essentials_icon';
            $property_aminities->save();
        }
        if ($request->door_man) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Doorman';
            $property_aminities->amenties_icon = 'Doorman_icon';
            $property_aminities->save();
        }
        if ($request->pool) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Pool';
            $property_aminities->amenties_icon = 'Pool_icon';
            $property_aminities->save();
        }
        if ($request->washer) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Washer';
            $property_aminities->amenties_icon = 'Washer_icon';
            $property_aminities->save();
        }
        if ($request->hot_tub) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Hot Tub';
            $property_aminities->amenties_icon = 'Hot_Tub_icon';
            $property_aminities->save();
        }
        if ($request->dryer) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Dryer';
            $property_aminities->amenties_icon = 'Dryer_icon';
            $property_aminities->save();
        }
        if ($request->gym) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Gym';
            $property_aminities->amenties_icon = 'Gym_icon';
            $property_aminities->save();
        }
        if ($request->free_parking_on_premises) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Free Parking on Premises';
            $property_aminities->amenties_icon = 'Free_Parking_on_Premises_icon';
            $property_aminities->save();
        }
        if ($request->wireless_internet) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Wireless Internet';
            $property_aminities->amenties_icon = 'Wireless_Internet_icon';
            $property_aminities->save();
        }
        if ($request->pets_allowed) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Pets Allowed';
            $property_aminities->amenties_icon = 'Pets_Allowed_icon';
            $property_aminities->save();
        }
        if ($request->kid_friendly) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Kid Friendly';
            $property_aminities->amenties_icon = 'Kid_Friendly_icon';
            $property_aminities->save();
        }
        if ($request->suitable_for_events) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Suitable for Events';
            $property_aminities->amenties_icon = 'Suitable_for_Events_icon';
            $property_aminities->save();
        }
        if ($request->non_smoking) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Non Smoking';
            $property_aminities->amenties_icon = 'Non_Smoking_icon';
            $property_aminities->save();
        }
        if ($request->phone) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Phone';
            $property_aminities->amenties_icon = 'Phone_icon';
            $property_aminities->save();
        }
        if ($request->projector) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Projector';
            $property_aminities->amenties_icon = 'Projector_icon';
            $property_aminities->save();
        }
        if ($request->restaurant) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Restaurant';
            $property_aminities->amenties_icon = 'Restaurant_icon';
            $property_aminities->save();
        }
        if ($request->air_conditioner) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Air Conditioner';
            $property_aminities->amenties_icon = 'Air_Conditioner_icon';
            $property_aminities->save();
        }
        if ($request->scanner_printer) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Scanner Printer';
            $property_aminities->amenties_icon = 'Scanner_Printer_icon';
            $property_aminities->save();
        }
        if ($request->fax) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Fax';
            $property_aminities->amenties_icon = 'Fax_icon';
            $property_aminities->save();
        }
        if ($request->breakfast_included) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Breakfast Included';
            $property_aminities->amenties_icon = 'Breakfast_Included_icon';
            $property_aminities->save();
        }

        if ($request->Cable) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Cable';
            $property_aminities->amenties_icon = 'cable_icon';
            $property_aminities->save();
        }

        if ($request->pots_and_pans) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Pots and Pans';
            $property_aminities->amenties_icon = 'pots_and_pans_icon';
            $property_aminities->save();
        }

        if ($request->towels) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Towels';
            $property_aminities->amenties_icon = 'Towels_icon';
            $property_aminities->save();
        }

        if ($request->garage) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Garage';
            $property_aminities->amenties_icon = 'Garage_icon';
            $property_aminities->save();
        }

        if ($request->smart_tv) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Smart Tv';
            $property_aminities->amenties_icon = 'Smart_Tv_icon';
            $property_aminities->save();
        }

        if ($request->all_bils_included) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'All Bils Included';
            $property_aminities->amenties_icon = 'All_Bils_Included_icon';
            $property_aminities->save();
        }

        if ($request->security_cameras) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Security Cameras';
            $property_aminities->amenties_icon = 'Security_Cameras_icon';
            $property_aminities->save();
        }

        if ($request->computer) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Computer';
            $property_aminities->amenties_icon = 'Computer_icon';
            $property_aminities->save();
        }

        if ($request->netflix) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Netflix';
            $property_aminities->amenties_icon = 'Netflix_icon';
            $property_aminities->save();
        }

        if ($request->coffee_pot) {
            $property_aminities = new Propertyamenties();
            $property_aminities->client_id = CLIENT_ID;
            $property_aminities->property_id = $request->property_id;
            $property_aminities->amenties_name = 'Coffee Pot';
            $property_aminities->amenties_icon = 'Coffee_Pot_icon';
            $property_aminities->save();
        }

        //        $request_data = print_r($request->all());
        //        LOG::info("Aminities add hitted with data :".$request_data);
        $c_data = DB::table('property_list')
            ->where('client_id', '=', CLIENT_ID)
            ->where('id', $request->property_id)
            ->first();
        DB::table('property_list')
            ->where('client_id', '=', CLIENT_ID)
            ->where('id', $request->property_id)
            ->update(['stage' => 6]);
        if ($c_data->property_type == BLOCK) {
            $url = BASE_URL . 'owner/add-new-property/7/' . $request->property_id;
        } else {
            // DB::table('property_list')->where('client_id', '=', CLIENT_ID)->where('id', $request->property_id)->update(['is_complete' => 1]);
            $url = BASE_URL . "owner/my-properties";
        }

        if (isset($request->save)) {
            session()->forget('property_id');
            $url = BASE_URL . "owner/calender?id=" . $request->property_id;
        } else {
            $url = BASE_URL . 'owner/add-new-property/5/' . $request->property_id;
        }

        return redirect($url);
    }

    public function property_next7(Request $request)
    {
        //
        $property = DB::table('property_list')
            ->where('client_id', '=', CLIENT_ID)
            ->where('id', $request->property_id)
            ->first();
        $role_id = $request->session()->get('role_id');
        $user_id = $request->session()->get('user_id');
        if ($role_id == 2) {
            DB::table('users')
                ->where('id', $request->session()->get('user_id'))
                ->update(['role_id' => ONE]);
            $request->session()->put('role_id', ONE);
        }
        DB::table('property_list')
            ->where('client_id', '=', CLIENT_ID)
            ->where('id', $request->property_id)
            ->update(['is_complete' => 1, 'stage' => 6]);

        $file_name = 'data/' . $request->property_id . '.json';
        if (file_exists($file_name)) {
            unlink($file_name);
        }
        $mail_email = $this->get_email($property->user_id);
        $user = DB::table('users')
            ->where('id', $request->session()->get('user_id'))
            ->first();
        $mail_data = ['name' => $user->first_name . ' ' . $user->last_name];

        $this->send_email_listing($mail_email, 'mail.listing', $mail_data);
        //owner/calender?id=94
        session()->forget('property_id');
        $url = BASE_URL . "owner/calender?id=" . $request->property_id;
        return redirect($url);
    }

    public function my_properties(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $properties = DB::table('property_list')
            ->leftjoin(
                'property_short_term_pricing',
                'property_short_term_pricing.property_id',
                '=',
                'property_list.id',
            )
            ->where('property_list.client_id', '=', CLIENT_ID)
            ->where('property_list.user_id', '=', $user_id)
            ->where('property_list.is_complete', '=', 1)
            ->where('property_list.status', '=', 1)
            ->select(
                'property_list.*',
                'property_short_term_pricing.*',
                'property_list.id as propertyId',
                'property_list.status as propertyStatus',
            )
            ->get();
        $properties_near = [];
        foreach ($properties as $property) {
            $property->description = substr($property->description, 0, 170);
            $property->description .= '...';

            $pd = DB::table('property_images')
                ->where('property_images.client_id', '=', CLIENT_ID)
                ->where('property_images.property_id', '=', $property->propertyId)
                ->orderBy('property_images.sort', 'asc')
                ->get();

            $cover_img = DB::table('property_images')
                ->where('property_images.client_id', '=', CLIENT_ID)
                ->where('property_images.property_id', '=', $property->propertyId)
                ->where('property_images.is_cover', '=', 1)
                ->first();
            // print_r($cover_img);
            // echo count($cover_img)."----".$cover_img->image_url."<br>";
            foreach ($pd as $images) {
                $img_url = $images->image_url;
                $property->image_url = $img_url;
            }

            $propertys = [];
            $propertysd = [];
            if (count($pd) > 0) {
                if (count($cover_img) == 1) {
                    $property->image_url = $cover_img->image_url;
                } else {
                    $property->image_url = $pd[ZERO]->image_url;
                }
            } else {
                $property->image_url = STATIC_IMAGE;
            }
            if (count($pd) == 0) {
                $propertysd[] = $propertys;
                $property->property_images = $propertysd;
                $property->image_url = STATIC_IMAGE;
            } else {
                $property->property_images = $pd;
            }

            $properties_near[] = $property;
        }

        return view('owner.my_properties', ['properties' => $properties_near]);
    }
}
