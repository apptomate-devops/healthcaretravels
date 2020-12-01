<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\BaseController;
use App\Models\PropertyRating;
use App\Models\OwnerRating;
use DB;

class PropertyController extends BaseController
{
    private $select_property_room = [
        "property_id",
        "property_size",
        "bathroom_count",
        "check_in_time",
        "check_out_time",
        "bedroom_count",
        "bed_count",
        "common_spaces",
    ];
    private $select_bed_rooms = ['bedroom_number', 'bed_type', 'is_common_space', 'count'];

    public function get_property($property_id, Request $request)
    {
        //

        LOG::info("property get single with id " . $property_id);
        $auth_check = $this->auth_check(
            $request->header('clientId'),
            $request->header('authId'),
            $request->header('authToken'),
        );

        if ($auth_check != ONE && !$request->testing) {
            return response()->json($auth_check);
        }

        $properties = DB::table('property_list')
            ->leftjoin('users', 'users.id', '=', 'property_list.user_id')
            ->leftjoin('property_images', 'property_images.property_id', '=', 'property_list.id')
            ->leftjoin('property_room', 'property_room.property_id', '=', 'property_list.id')
            ->where('property_list.client_id', '=', $request->header('clientId'))
            ->where('property_list.id', '=', $property_id)
            ->select(
                'property_list.id as property_id',
                'property_list.property_category',
                'property_list.room_type',
                'property_list.title',
                'property_list.total_guests',
                'property_list.lat',
                'property_list.lng',
                'property_list.description',
                'property_list.verified',
                'property_list.status',
                'property_list.is_instant',
                'property_list.cancellation_policy',
                'property_list.cancellation_policy',
                'property_list.min_days',
                'users.first_name',
                'users.last_name',
                'users.profile_image',
                'property_images.image_url',
                'property_images.is_cover',
                'property_room.property_size',
                'property_room.bathroom_count',
                'property_room.bedroom_count',
                'property_room.bed_count',
                'property_room.common_spaces',
                'users.languages_known',
                'property_list.pets_allowed',
            )
            ->orderBy('property_images.is_cover', 'desc')
            ->first();

        //        $sql = "UPDATE `property_list` SET `view_count` = `view_count` + 1 WHERE `id` = $property_id";
        //        DB::select($sql);

        foreach ($properties as $key => $value) {
            if (is_null($value)) {
                $array[$key] = "";
            }
        }

        $properties->link = BASE_URL . "property/" . $property_id;
        if ($properties) {
            $bed_list = DB::table('property_bedrooms')
                ->where('property_bedrooms.client_id', '=', $request->header('clientId'))
                ->where('property_bedrooms.property_id', '=', $property_id)
                ->select(
                    'property_bedrooms.bedroom_number',
                    'property_bedrooms.bed_type',
                    'property_bedrooms.is_common_space',
                    'property_bedrooms.count',
                )
                ->orderBy('status', 'ASC')
                ->get();

            foreach ($bed_list as $bed) {
                $bed->count = (string) $bed->count;
                switch ($bed->bed_type) {
                    case "double_bed":
                        $bed->bed_type = "Double Bed";
                        $bed->icon_url = DOUBLE_BED;
                        break;
                    case "queen_bed":
                        $bed->bed_type = "Queen Bed";
                        $bed->icon_url = QUEEN_BED;
                        break;
                    case "single_bed":
                        $bed->bed_type = "Single Bed";
                        $bed->icon_url = SINGLE_BED;
                        break;
                    case "sofa_bed":
                        $bed->bed_type = "Sofa Bed";
                        $bed->icon_url = SOFA_BED;
                        break;
                    case "bunk_bed":
                        $bed->bed_type = "Bunk Bed";
                        $bed->icon_url = BUNK_BED;
                        break;
                    default:
                        $bed->bed_type = "Common Space";
                        $bed->icon_url = COMMON_SPACE_BED;
                }
            }
            $properties->bed_list = $bed_list; //amenities
            $amenties = DB::table('amenities')
                ->where('amenities.client_id', '=', $request->header('clientId'))
                ->where('amenities.property_id', '=', $property_id)
                ->select('amenities.amenties_name', 'amenities.amenties_icon')
                ->get();
            //print_r($amenties); exit;
            $properties->amenties = $amenties;

            $reviews = DB::table('property_rating')
                ->join('users', 'users.id', '=', 'property_rating.user_id')
                ->where('property_rating.client_id', '=', $request->header('clientId'))
                ->where('property_rating.property_id', '=', $property_id)
                ->select(
                    'property_rating.rating',
                    'users.first_name as reviewer_first_name',
                    'users.last_name as reviewer_last_name',
                    'users.profile_image',
                    'property_rating.comments',
                    'property_rating.created_at',
                )
                ->orderBy('property_rating.created_at', 'desc')
                ->limit(1)
                ->get();

            // foreach ($reviews as $r) {
            //     $r->created_at = date('d/m/Y H:i:s', strtotime($r->created_at));
            // }

            if (count($reviews) == 0) {
                $properties->reviews = [];
            } else {
                $properties->reviews = $reviews;
            }

            $rating = DB::table('property_rating')
                ->where('property_rating.client_id', '=', $request->header('clientId'))
                ->where('property_rating.property_id', '=', $property_id)
                ->avg('rating');
            $raters_count = DB::table('property_rating')
                ->where('property_rating.client_id', '=', $request->header('clientId'))
                ->where('property_rating.property_id', '=', $property_id)
                ->count();
            if ($rating > 0) {
                $properties->property_rating = $rating;
                $properties->raters_count = $raters_count;
            } else {
                $properties->property_rating = 0;
                $properties->raters_count = 0;
            }
            $favourite = DB::table('user_favourites')
                ->where('user_favourites.client_id', '=', $request->header('clientId'))
                ->where('user_favourites.user_id', '=', $request->header('authId'))
                ->where('user_favourites.property_id', '=', $property_id)
                ->count();
            if ($favourite != 0) {
                $properties->is_favourite = 1;
            } else {
                $properties->is_favourite = 0;
            }
            $pd = DB::table('property_images')
                ->where('property_images.client_id', '=', $request->header('clientId'))
                ->where('property_images.property_id', '=', $property_id)
                ->orderBy('property_images.sort', 'asc')
                ->orderBy('property_images.is_cover', 'desc')
                ->select('property_images.image_url')
                ->get();
            $properties->property_images = $pd;

            $property_booking = DB::table('property_list')
                ->join('property_booking', 'property_booking.property_id', '=', 'property_list.id')
                ->where('property_list.id', '=', $property_id)
                ->select('property_booking.start_date', 'property_booking.end_date')
                ->get();
            foreach ($property_booking as $r) {
                // $r->created_at = date('d/m/Y H:i:s', strtotime($r->created_at));
                // $r->updated_at = date('d/m/Y H:i:s', strtotime($r->updated_at));
                $r->start_date = date('d/m/Y H:i:s', strtotime($r->start_date));
                $r->end_date = date('d/m/Y H:i:s', strtotime($r->end_date));
            }
            $properties->property_booking = $property_booking;
            $property_blocked = DB::table('property_list')
                ->join('property_blocking', 'property_blocking.property_id', '=', 'property_list.id')
                ->where('property_list.id', '=', $property_id)
                ->select('property_blocking.start_date', 'property_blocking.end_date')
                ->get();
            foreach ($property_blocked as $s) {
                // $r->created_at = date('d/m/Y H:i:s', strtotime($r->created_at));
                // $r->updated_at = date('d/m/Y H:i:s', strtotime($r->updated_at));
                $s->start_date = date('d/m/Y H:i:s', strtotime($s->start_date));
                $s->end_date = date('d/m/Y H:i:s', strtotime($s->end_date));
            }
            $properties->property_blocking = $property_blocked;
            //print_r($property_booking);exit;
            $icals = DB::table('third_party_calender')
                ->where('property_id', '=', $property_id)
                ->get();
            $third_party = [];
            foreach ($icals as $ic) {
                $data = $this->read_ical($ic->third_party_url);
                $j = 0;
                for ($i = 2; $i <= count($data); $i++) {
                    if (isset($data[$i]['DTEND;VALUE=DATE'])) {
                        $third_party[$j]['start_date'] = date(
                            'd/m/Y H:i:s',
                            strtotime($data[$i]['DTSTART;VALUE=DATE']),
                        );
                        $third_party[$j]['end_date'] = date('d/m/Y H:i:s', strtotime($data[$i]['DTEND;VALUE=DATE']));
                    }
                    $j++;
                }
            }
            $properties->icals = $third_party;
        }
        $result = $properties;

        $properties = DB::table('property_list')
            ->leftjoin('property_room', 'property_room.property_id', '=', 'property_list.id')
            ->where('property_list.client_id', '=', $request->header('clientId'))
            ->select(
                'property_list.property_category',
                'property_room.bed_count',
                'property_list.room_type',
                'property_list.room_type',
                'property_list.title',
                'property_list.total_guests',
                'property_list.verified',
                'property_list.id',
                'property_list.lat',
                'property_list.lng',
            )
            ->get();
        if ($request->price_high_to_low) {
            $properties = DB::table('property_list')
                ->where('property_list.client_id', '=', $request->header('clientId'))
                ->leftjoin('property_room', 'property_room.property_id', '=', 'property_list.id')
                ->where('property_list.client_id', '=', $request->header('clientId'))
                ->select(
                    'property_list.property_category',
                    'property_room.bed_count',
                    'property_list.room_type',
                    'property_list.room_type',
                    'property_list.title',
                    'property_list.total_guests',
                    'property_list.verified',
                    'property_list.id',
                )
                ->get();
        }
        if ($request->price_low_to_high) {
            $properties = DB::table('property_list')
                ->where('property_list.client_id', '=', $request->header('clientId'))
                ->leftjoin('property_room', 'property_room.property_id', '=', 'property_list.id')
                ->where('property_list.client_id', '=', $request->header('clientId'))
                ->select(
                    'property_list.property_category',
                    'property_room.bed_count',
                    'property_list.room_type',
                    'property_list.room_type',
                    'property_list.title',
                    'property_list.total_guests',
                    'property_list.verified',
                    'property_list.id',
                )
                ->get();
        }
        //price_per_weekend
        $properties_near = [];
        // print_r($properties); exit;
        // foreach ($properties as $property) {

        //     $review_count = DB::table('property_review')
        //             ->where('property_review.client_id', '=', $request->header('clientId'))
        //             ->where('property_review.property_id', '=', $property->id)
        //             ->count();
        //     if ($review_count) {
        //         $property->review_count = $review_count;
        //     }
        //     else {
        //         $property->review_count = 0;
        //     }

        //     $rating = DB::table('property_rating')
        //             ->where('property_rating.client_id', '=', $request->header('clientId'))
        //             ->where('property_rating.property_id', '=', $property->id)
        //             ->avg('rating');
        //     $raters_count = DB::table('property_rating')
        //             ->where('property_rating.client_id', '=', $request->header('clientId'))
        //             ->where('property_rating.property_id', '=', $property->id)
        //             ->count();
        //     if ($rating) {
        //         $property->property_rating = $rating;
        //         $property->raters_count = $raters_count;
        //     }
        //     else {
        //         $property->property_rating = 0;
        //         $property->raters_count = 0;
        //     }
        //     $pd = DB::table('property_images')
        //             ->where('property_images.client_id', '=', $request->header('clientId'))
        //             ->where('property_images.property_id', '=', $property->id)->orderBy('property_images.sort', 'asc')
        //             ->select('property_images.image_url')
        //             ->get();
        //     $propertys = array();
        //     $propertysd = array();
        //     $propertys['image_url'] = STATIC_IMAGE;
        //     if (count($pd) == 0) {
        //         $propertysd[] = $propertys;
        //         $property->property_images = $propertysd;
        //     }
        //     else {
        //         $property->property_images = $pd;
        //     }

        //     $favourite = DB::table('user_favourites')
        //                     ->where('user_favourites.client_id', '=', $request->header('clientId'))
        //                     ->where('user_favourites.user_id', '=', $request->header('authId'))
        //                     ->where('user_favourites.property_id', '=', $property->id)->count();
        //     if ($favourite != 0) {
        //         $property->is_favourite = 1;
        //     }
        //     else {
        //         $property->is_favourite = 0;
        //     }

        //     if ($properties) {
        //        // print_r($properties);
        //        // print_r($property);exit;
        //        $source_location = $property->location;//$location;
        //        $source_location = urlencode($source_location);
        //        $loc = $property->location;
        //        $property->location = urlencode($property->location);
        //        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" . $source_location . "&destinations=" . $property->location . "&key=AIzaSyB-rD5XU_5kd1vcx_EiOg4syU_honD2XIg";//exit;
        //        $ch = curl_init();
        //        curl_setopt($ch, CURLOPT_URL, $url);
        //        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //        $response = curl_exec($ch);
        //        $response = json_decode($response);
        //        // print_r($response); exit;
        //        // echo $response->rows[0]->elements[0]->status;
        //        // echo (float)$response->rows[0]->elements[0]->distance->text; exit;
        //        if ($response->rows[0]->elements[0]->status != 'ZERO_RESULTS') {
        //            $distance = (float)$response->rows[0]->elements[0]->distance->text;
        //            if ($distance <= $this->get_radius()) {
        //                $property->location = $loc;
        //                $property->property_id = $property->id;
        //                $properties_near[] = $property;
        //            }
        //        }
        //     }
        // }  //array_multisort(array_column($inventory, 'price'), SORT_DESC, $inventory);
        $hospitals = $this->yelp_hospitals($result->lat, $result->lng);
        $nearby_hospital = [];
        for ($j = 0; $j < count($hospitals->businesses); $j++) {
            $nearby_hospital[$j]['latitude'] = $hospitals->businesses[$j]->coordinates->latitude;
            $nearby_hospital[$j]['longitude'] = $hospitals->businesses[$j]->coordinates->longitude;
            $nearby_hospital[$j]['image_url'] = $hospitals->businesses[$j]->image_url;
            $nearby_hospital[$j]['name'] = $hospitals->businesses[$j]->name;
            $nearby_hospital[$j]['distance'] = $hospitals->businesses[$j]->distance / 1000;
            $nearby_hospital[$j]['display_address'] = implode(
                " ",
                $hospitals->businesses[$j]->location->display_address,
            );
            $nearby_hospital[$j]['rating'] = $hospitals->businesses[$j]->rating;
        }

        $pets = $this->yelp_pets($result->lat, $result->lng);

        $nearby_pets = [];
        for ($j = 0; $j < count($pets->businesses); $j++) {
            $nearby_pets[$j]['latitude'] = $pets->businesses[$j]->coordinates->latitude;
            $nearby_pets[$j]['longitude'] = $pets->businesses[$j]->coordinates->longitude;
            $nearby_pets[$j]['image_url'] = $pets->businesses[$j]->image_url;
            $nearby_pets[$j]['name'] = $pets->businesses[$j]->name;
            $nearby_pets[$j]['distance'] = $pets->businesses[$j]->distance / 1000;
            $nearby_pets[$j]['display_address'] = implode(" ", $pets->businesses[$j]->location->display_address);
            $nearby_pets[$j]['rating'] = $pets->businesses[$j]->rating;
        }

        // print_r($nearby_hospital);exit;

        return response()->json([
            'status' => 'SUCCESS',
            'data' => $result,
            'properties_near' => $properties_near,
            'nearby_pets' => $nearby_pets,
            'nearby_hospital' => $nearby_hospital,
        ]);
    }

    public function get_property1(Request $request)
    {
        $data = $this->propertyList
            ->where('id', $request->property_id)
            ->select('user_id', 'country', 'state', 'city', 'address', 'lat', 'lng', 'zip_code')
            ->first();

        return response()->json(['status' => true, 'data' => $data]);
    }

    public function get_property2(Request $request)
    {
        # code...
        $select = ['room_type', 'total_guests as guest_count', 'property_size', 'cur_adults', 'cur_child', 'cur_pets'];

        $data = $this->propertyList
            ->where('property_list.id', '=', $request->property_id)
            ->select($select)
            ->first();
        $data = $this->remove_null_obj($data);

        $rooms = $this->propertyRoom
            ->where('property_id', '=', $request->property_id)
            ->select($this->select_property_room)
            ->get();
        $rooms = $this->remove_null($rooms);
        $data->property_room = $rooms;

        $bed_rooms = $this->propertyBedRooms
            ->where('property_id', '=', $request->property_id)
            ->select($this->select_bed_rooms)
            ->get();
        $bed_rooms = $this->remove_null($bed_rooms);
        $data->property_bedrooms = $bed_rooms;

        return response()->json(['status' => true, 'data' => $data]);
    }

    public function get_property3(Request $request)
    {
        $data = $this->propertyList
            ->where('property_list.id', '=', $request->property_id)
            ->select(
                'property_list.title',
                'property_list.description',
                'property_list.property_size',
                'property_list.trash_pickup_days',
                'property_list.lawn_service',
                'property_list.pets_allowed',
            )
            ->first();

        return response()->json(['status' => true, 'data' => $data]);
    }

    public function get_property4(Request $request)
    {
        $data = $this->propertyList
            ->where('property_list.id', '=', $request->property_id)
            ->select(
                'property_list.cancellation_policy',
                'property_list.monthly_rate',
                'property_list.min_days',
                'property_list.is_instant as booking_type',
                'property_list.house_rules',
            )
            ->first();

        $data->check_in = date('H:i', strtotime($data->check_in));
        $data->check_out = date('H:i', strtotime($data->check_out));
        return response()->json(['status' => true, 'data' => $data]);
    }

    public function add_property1(Request $request)
    {
        # code...

        if (!$request->location) {
            $request->location = "";
        }
        if (!$request->address) {
            $request->address = "";
        }
        $ins_array = [];
        $ins_array['client_id'] = CLIENT_ID;
        $ins_array['user_id'] = $request->user_id;
        $ins_array['country'] = $request->country;
        $ins_array['state'] = $request->state;
        $ins_array['city'] = $request->city;
        $ins_array['address'] = $request->address;
        $ins_array['zip_code'] = $request->zip_code;
        $ins_array['lat'] = $request->lat;
        $ins_array['lng'] = $request->lng;
        if (!$request->property_id) {
            $insert = DB::table('property_list')->insertGetId($ins_array);
            $update_on_stage = $this->propertyList->where('id', $insert)->update(['stage' => 1]);
        } else {
            $update = DB::table('property_list')
                ->where('id', $request->property_id)
                ->update($ins_array);

            $insert = $request->property_id;
        }

        $data = DB::table('property_list')
            ->where('id', $insert)
            ->first();

        $data = $this->remove_null_obj($data);

        return response()->json(['status' => 'SUCCESS', 'data' => $data]);
    }

    public function add_property2(Request $request)
    {
        $request->check_in_time = date("H:i:s", strtotime($request->check_in_time));
        $request->check_out_time = date("H:i:s", strtotime($request->check_out_time));

        if ($request->property_id) {
            $is_old = DB::table('property_room')
                ->where('property_id', $request->property_id)
                ->count();
            DB::table('property_room')
                ->where('property_id', $request->property_id)
                ->delete();
            DB::table('property_bedrooms')
                ->where('property_id', $request->property_id)
                ->delete();
        }

        $p_list = $this->propertyList->where('id', $request->property_id)->first();

        $this->propertyList->where('id', $request->property_id)->update([
            'room_type' => $request->room_type,
            'property_size' => $request->property_size,
            'total_guests' => $request->guest_count,
            'cur_adults' => $request->cur_adults,
            'cur_child' => $request->cur_child,
            'cur_pets' => $request->cur_pets,
        ]);

        $property_room = DB::table('property_room')->insert([
            'client_id' => CLIENT_ID,
            'property_id' => $request->property_id,
            'property_size' => $request->property_size ? $request->property_size : 0,
            'bathroom_count' => $request->bathroom_count ? $request->bathroom_count : 0,
            'check_in_time' => $request->check_in_time ? $request->check_in_time : 0,
            'check_out_time' => $request->check_out_time ? $request->check_out_time : 0,
            'bedroom_count' => $request->no_of_bedrooms,
            'bed_count' => $request->bed_count,
            'common_spaces' => $request->common_spaces ? $request->common_spaces : 0,
            'status' => ACTIVE,
        ]);
        for ($i = 0; $i < $request->no_of_bedrooms; $i++) {
            if ($request->double_bed[$i]) {
                $double_bed = DB::table('property_bedrooms')->insert([
                    'client_id' => CLIENT_ID,
                    'property_id' => $request->property_id,
                    'bedroom_number' => $i + 1,
                    'bed_type' => "double_bed",
                    'count' => $request->double_bed[$i],
                    'status' => ACTIVE,
                ]);
            }
            if ($request->queen_bed[$i]) {
                $double_bed = DB::table('property_bedrooms')->insert([
                    'client_id' => CLIENT_ID,
                    'property_id' => $request->property_id,
                    'bedroom_number' => $i + 1,
                    'bed_type' => "queen_bed",
                    'count' => $request->queen_bed[$i],
                    'status' => ACTIVE,
                ]);
            }
            if ($request->single_bed[$i]) {
                $double_bed = DB::table('property_bedrooms')->insert([
                    'client_id' => CLIENT_ID,
                    'property_id' => $request->property_id,
                    'bedroom_number' => $i + 1,
                    'bed_type' => "single_bed",
                    'count' => $request->single_bed[$i],
                    'status' => ACTIVE,
                ]);
            }
            if ($request->sofa_bed[$i]) {
                $double_bed = DB::table('property_bedrooms')->insert([
                    'client_id' => CLIENT_ID,
                    'property_id' => $request->property_id,
                    'bedroom_number' => $i + 1,
                    'bed_type' => "sofa_bed",
                    'count' => $request->sofa_bed[$i],
                    'status' => ACTIVE,
                ]);
            }
            if ($request->bunk_bed[$i]) {
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
            if ($request->device_type == 2) {
                $des = explode(",", $request->common);
                foreach ($des as $key => $value) {
                    //echo 'Key -'.$key.'&&& value - '.$value;exit;
                    $key = (int) $key;
                    switch ($key) {
                        case 0:
                            $bed_type = "double_bed";
                            break;
                        case 1:
                            $bed_type = "queen_bed";
                            break;
                        case 2:
                            $bed_type = "single_bed";
                            break;
                        case 3:
                            $bed_type = "sofa_bed";
                            break;
                        case 4:
                            $bed_type = "bunk_bed";
                            break;

                        default:
                            # code...
                            break;
                    }
                    $value = (int) $value;
                    if ($value != 0) {
                        $double_bed = DB::table('property_bedrooms')->insert([
                            'client_id' => CLIENT_ID,
                            'property_id' => $request->property_id,
                            'bedroom_number' => $i + 1,
                            'bed_type' => $bed_type,
                            'count' => $value,
                            'is_common_space' => ACTIVE,
                            'status' => 2,
                        ]);
                    }
                }
            } else {
                if ($i == BLOCK) {
                    if ($request->c_double_bed[$i]) {
                        $double_bed = DB::table('property_bedrooms')->insert([
                            'client_id' => CLIENT_ID,
                            'property_id' => $request->property_id,
                            'bedroom_number' => $i + 1,
                            'bed_type' => "double_bed",
                            'count' => $request->c_double_bed[$i],
                            'is_common_space' => ACTIVE,
                            'status' => 2,
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
                            'status' => 2,
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
                            'status' => 2,
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
                            'status' => 2,
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
                            'status' => 2,
                        ]);
                    }
                }
            }
            // common spaces end
        }

        if ($is_old) {
            # code...
        } else {
            if ($p_list->stage < 2) {
                $update_on_stage = $this->propertyList->where('id', $request->property_id)->update(['stage' => 2]);
            }
        }

        $data = DB::table('property_list')
            ->where('id', $request->property_id)
            ->first();
        $data = $this->null_safe($data);
        return response()->json(['status' => 'SUCCESS', 'data' => $data]);
    }

    public function add_property3(Request $request)
    {
        $prop = $this->propertyList->where('id', $request->property_id)->first();
        if ($prop->stage < 3) {
            $update_on_stage = $this->propertyList->where('id', $request->property_id)->update(['stage' => 3]);
        }
        $update = DB::table('property_list')
            ->where('id', $request->property_id)
            ->update([
                'title' => $request->title,
                'description' => $request->description,
                'lawn_service' => $request->lawn_service,
                'trash_pickup_days' => $request->trash_pickup_days,
                'pets_allowed' => $request->pets_allowed,
            ]);
        $data = DB::table('property_list')
            ->where('id', $request->property_id)
            ->first();
        $data = $this->null_safe($data);
        return response()->json(['status' => 'SUCCESS', 'data' => $data]);
    }

    public function add_property4(Request $request)
    {
        # code...
        $this->propertyList
            ->where('id', $request->property_id)
            ->update(['cancellation_policy' => $request->cancellation_policy, 'min_days' => $request->min_days]);

        $request->booking_type = (int) $request->booking_type;
        $update_on_stage = $this->propertyList
            ->where('id', $request->property_id)
            ->update(['is_instant' => $request->booking_type]);

        // $retVal = (condition) ? a : b ;
        // currency , nightly pricing , tax ,security deposit, check in, check out, minimum stay , cancellation policy,

        $ins = [];
        $ins['client_id'] = CLIENT_ID;
        $ins['property_id'] = $request->property_id;

        $ins['price_more_than_one_week'] = $request->price_more_than_one_week ? $request->price_more_than_one_week : "";
        $ins['price_more_than_one_month'] = $request->price_more_than_one_month
            ? $request->price_more_than_one_month
            : "";
        $ins['price_per_weekend'] = $request->price_per_weekend ? $request->price_per_weekend : "";
        $ins['weekend_days'] = $request->weekend_days ? $request->weekend_days : "";
        $ins['cleaning_fee'] = $request->cleaning_fee ? $request->cleaning_fee : "";
        $ins['city_fee'] = $request->city_fee ? $request->city_fee : "";
        $ins['city_fee_type'] = $request->city_fee_type ? $request->city_fee_type : "";
        $ins['price_per_extra_guest'] = $request->price_per_extra_guest ? $request->price_per_extra_guest : "";

        $ins['tax'] = $request->tax;
        $ins['price_per_night'] = $request->price_per_night;
        $ins['security_deposit'] = $request->security_deposit;
        $ins['check_in'] = $request->check_in;
        $ins['check_out'] = $request->check_out;

        $val_count = $this->shor_term_pricing->where('property_id', $request->property_id)->count();
        if ($val_count == ZERO) {
            $insert = $this->shor_term_pricing->insert($ins);
            $this->propertyList->where('id', $request->property_id)->update(['house_rules' => $request->house_rules]);
            $msg = "Price added successfully";
            $update_on_stage = $this->propertyList->where('id', $request->property_id)->update(['stage' => 4]);
        } else {
            $update = $this->shor_term_pricing->where('property_id', $request->property_id)->update($ins);
            $this->propertyList->where('id', $request->property_id)->update(['house_rules' => $request->house_rules]);
            $msg = "Price updated successfully";
        }
        return response()->json(['status' => true, 'success_message' => 'Price updated successfully']);
    }

    public function disable_property($id, Request $request)
    {
        //property_list
        $user_id = $request->header('authId');
        $client_id = $request->header('clientId');
        $user = DB::table('users')
            ->where('client_id', $client_id)
            ->where('id', $user_id)
            ->first();
        $username = Helper::get_user_display_name($user);
        $check = DB::table('property_list')
            ->where('client_id', $client_id)
            ->where('id', $id)
            ->first();
        //print_r($check);exit;
        if ($check->is_disable == 0) {
            $disable = 1;
            $content = "Your Property : " . $check->title . "(Property ID : " . $check->id . ") Has been Disabled.";
        } else {
            $disable = 0;
            $content = "Your Property : " . $check->title . "(Property ID : " . $check->id . ") Has been Enabled.";
        }
        $update = DB::table('property_list')
            ->where('client_id', $client_id)
            ->where('id', $id)
            ->update(['is_disable' => $disable]);
        $mail_email = $this->get_email($check->user_id);
        $mail_data = [
            'username' => $username,
            'content' => $content,
        ];
        $this->send_email($mail_email, 'mail.custom-email', $mail_data);
        if ($disable == 0) {
            return response()->json(['status' => 'SUCCESS', 'message' => 'Your Property Disabled']);
        }
        if ($disable == 1) {
            return response()->json(['status' => 'SUCCESS', 'message' => 'Your Property Enabled']);
        }
    }
    public function delete_property(Request $request)
    {
        $delete = $this->property_amenities->where('property_id', '=', $request->property_id)->delete();
        $delete = $this->property_booking->where('property_id', '=', $request->property_id)->delete();
        $delete = $this->propertyRoom->where('property_id', '=', $request->property_id)->delete();
        $delete = $this->propertyBedRooms->where('property_id', '=', $request->property_id)->delete();
        $delete = $this->propertyList->where('property_list.id', '=', $request->property_id)->delete();
        if ($delete) {
            return response()->json(['status' => true, 'success_message' => 'Property deleted successfully']);
        } else {
            return response()->json(['status' => false, 'error_message' => 'Unable to delete property']);
        }
    }

    public function delete_property_image($id)
    {
        $delete = DB::table('property_images')
            ->where('id', $id)
            ->delete();
        if ($delete) {
            return response()->json(['status' => true, 'success_message' => 'Property Image deleted successfully']);
        } else {
            return response()->json(['status' => false, 'error_message' => 'Unable to delete property Image']);
        }
    }

    public function search_property(Request $request, $location)
    {
        LOG::info("search property hitted");

        $location = urldecode($location);
        $auth_id = $request->header('authId');
        $location = explode(',', $location)[0];

        $where = "A.client_id = " . CLIENT_ID . "";

        if ($request->price_desc) {
            $where .= " ORDER BY B.price_per_night DESC";
        }

        if ($request->price_asc) {
            $where .= " ORDER BY B.price_per_night ASC";
        }

        if ($request->rating) {
            $where .= " ORDER BY property_rating DESC";
        }

        if ($request->reviews) {
            $where .= " ORDER BY review_count DESC";
        }

        if ($request->bed_desc) {
            $where .= " ORDER BY bedroom_count DESC";
        }

        if ($request->bed_asc) {
            $where .= " ORDER BY bedroom_count ASC";
        }

        // TODO: remove property_short_term_pricing from query, use monthly_rate from property_list

        $sql =
            "SELECT A.*,B.price_per_night,B.property_id,
(SELECT room.bed_count FROM property_room room WHERE room.property_id = A.id LIMIT 1) AS bed_count,
(SELECT room.bedroom_count FROM property_room room WHERE room.property_id = A.id LIMIT 1) AS bedroom_count,
(SELECT images.image_url  FROM property_images images WHERE images.property_id = A.id and images.sort = 2 LIMIT 1) AS image_url,
(SELECT count(*)  FROM property_review review WHERE review.property_id = A.id) AS review_count,
(SELECT count(*)  FROM property_rating rating WHERE rating.property_id = A.id) AS raters_count,
(SELECT count(*)  FROM user_favourites favourites WHERE favourites.property_id = A.id AND favourites.user_id = $auth_id) AS is_favourite,
(SELECT IFNULL(AVG(rating),0) FROM property_rating rating_avg WHERE rating_avg.property_id = A.id) AS property_rating
FROM `property_list` A , `property_short_term_pricing` B WHERE  A.status = '1'  AND A.property_status = '1'  AND A.id = B.property_id AND A.is_complete = " .
            ONE .
            " AND (A.city like '%" .
            $location .
            "%' OR A.country like '%" .
            $location .
            "%' OR A.address like '%" .
            $location .
            "%') AND " .
            $where .
            "";

        LOG::info("search property sql " . $sql);
        //echo $sql;exit;
        $properties = DB::select($sql);
        //print_r($properties);exit;
        $properties = $this->remove_null($properties);
        //var_dump($properties);exit;
        //price_per_weekend
        $properties_near = [];
        foreach ($properties as $property) {
            $pd = DB::table('property_images')
                ->where('property_images.client_id', '=', $request->header('clientId'))
                ->where('property_images.property_id', '=', $property->property_id)
                ->orderBy('property_images.sort', 'desc')
                ->orderBy('property_images.is_cover', 'desc')
                ->select('property_images.image_url')
                ->get();
            $propertys = [];
            $propertysd = [];
            $propertys['image_url'] = STATIC_IMAGE;
            if (count($pd) == 0) {
                $propertysd[] = $propertys;
                $property->property_images = $propertysd;
            } else {
                $property->property_images = $pd;
            }

            $source_location = $location;

            $source_location = urlencode($source_location);
            $properties_near[] = $property;
            $url =
                "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" .
                $source_location .
                "&key=AIzaSyCGX6aGjOeMptlBNc0WF3vhm0SPMl1vNBE"; //exit;
            // LOG::info("distance matrix url ".$url);
            // $ch = curl_init();
            // curl_setopt($ch, CURLOPT_URL, $url);
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // $response = curl_exec($ch);
            // $response = json_decode($response);
            // print_r($response);

            // // $stat = $response->rows[0]->elements[0]->status;
            // //    if()
            // // print_r($response); exit;
            // if (isset($response->rows[0]->elements[0]->status) ) {
            //     if($response->rows[0]->elements[0]->status != 'ZERO_RESULTS'){

            //         if (isset($response->rows[0]->elements[0]->distance->text)) {
            //             $distance = (float) $response->rows[0]->elements[0]->distance->text;

            //             if ($distance <= $this->get_radius()) {

            //                 $property->location = $loc;
            //                 $property->property_id = $property->property_id;
            //                 $properties_near[] = $property;

            //             }
            //         }

            //     }

            // }

            //echo ; exit; Gandhipuram,Coimbatore,TamilNadu,India
        }
        ///array_multisort(array_column($properties_near, 'property_rating'), SORT_DESC, $properties_near);

        if (count($properties_near) == 0) {
            return response()->json([
                'status' => 'FAILED',
                'error' => true,
                'message' => 'No properties found',
                'data' => $properties_near,
            ]);
        }

        return response()->json([
            'status' => 'SUCCESS',
            'message' => 'property found',
            'location' => $location,
            'data' => $properties_near,
            'url' => $url,
        ]);
    }
}
