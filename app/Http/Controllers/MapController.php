<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class MapController extends BaseController
{
    public function single_marker($lat, $lng, $pets_allowed, Request $request)
    {
        $hospitals = $this->yelp_hospitals($lat, $lng);
        $pets = $this->yelp_pets($lat, $lng);
        $array = [];
        foreach ($hospitals->businesses as $hospital) {
            $arr['name'] = $hospital->name;
            $arr['image_url'] = $hospital->image_url;
            $arr['url'] = $hospital->url;
            $arr['lat'] = $hospital->coordinates->latitude;
            $arr['lang'] = $hospital->coordinates->longitude;
            $arr['address'] = $hospital->location->display_address[0];
            $arr['display_phone'] = $hospital->display_phone;
            $arr['distance'] = round($hospital->distance / 1000) . " Km From this Property";

            array_push($array, $arr);
        }
        $pet_place = [];
        foreach ($pets->businesses as $pets) {
            $arr1['name'] = $pets->name;
            $arr1['image_url'] = $pets->image_url;
            $arr1['url'] = $pets->url;
            $arr1['lat'] = $pets->coordinates->latitude;
            $arr1['lang'] = $pets->coordinates->longitude;
            $arr1['address'] = $pets->location->display_address[0];
            $arr1['display_phone'] = $pets->display_phone;
            $arr1['distance'] = round($pets->distance / 1000) . " Km From this Property";

            array_push($pet_place, $arr1);
        }

        return view('map.single_marker', [
            'lat' => $lat,
            'lng' => $lng,
            'hospitals' => $array,
            'pet_place' => $pet_place,
            'pets_allowed' => $pets_allowed,
        ]);
    }

    public function multiple_marker($url, Request $request)
    {
        $results = unserialize(urldecode($url));
        $final_results = [];
        $t = [];
        foreach ($results as $result) {
            $property = DB::table('property_images')
                ->where('client_id', CLIENT_ID)
                ->where('property_id', $result['id'])
                ->first();
            $propertys = DB::table('property_list')
                ->where('client_id', CLIENT_ID)
                ->where('id', $result['id'])
                ->first();
            $title = $propertys ? $propertys->title : "";
            $image_url = $property ? $property->image_url : "";
            $t = [
                'title' => $title,
                'image_url' => $image_url,
                'id' => $result['id'],
                'lat' => $result['lat'],
                'lng' => $result['lng'],
                'price' => $result['price'],
            ];
            $final_results[] = $t;
        }
        //print_r($final_results);exit;
        return view('map.multiple_marker')->with('results', $final_results);
    }
}
