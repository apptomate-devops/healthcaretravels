<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use DB;

class OwnerController extends BaseController
{
    public function get_my_properties(Request $request)
    {
        # code...
        $user_id = $request->header('authId');

        $properties = DB::table('property_list')
            ->where('property_list.client_id', '=', CLIENT_ID)
            ->where('property_list.user_id', '=', $user_id)
            ->get();

        $properties_near = [];
        foreach ($properties as $property) {
            $property->description = substr($property->description, 0, 170);
            $property->description .= '...';

            $pd = DB::table('property_images')
                ->where('property_images.client_id', '=', CLIENT_ID)
                ->where('property_images.property_id', '=', $property->property_id)
                ->orderBy('property_images.sort', 'asc')
                ->orderBy('property_images.is_cover', 'desc')
                ->get();

            foreach ($pd as $images) {
                $img_url = $images->image_url;
                $property->image_url = $img_url;
            }

            $propertys = [];
            $propertysd = [];
            if (count($pd) > 0) {
                $propertys['image_url'] = $pd[ZERO]->image_url;
            } else {
                $propertys['image_url'] = STATIC_IMAGE;
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

        return response()->json(['status' => true, 'properties' => $properties_near]);
    }
}
