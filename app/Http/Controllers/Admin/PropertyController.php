<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use DB;
use Log;

class PropertyController extends BaseController
{
    public function index(Request $Request)
    {
        $properties = $this->propertyList
            ->join('users as owner', 'owner.id', '=', 'property_list.user_id')
            ->where('property_list.status', '=', 1)
            ->select(
                'property_list.id',
                'property_list.title',
                'owner.first_name',
                'owner.last_name',
                'property_list.room_type',
                'property_list.created_at',
                'property_list.property_status',
                'property_list.verified',
            )
            ->get();
        return view('Admin.property', compact('properties'));
    }

    public function status_update(Request $request)
    {
        $update = $this->propertyList->where('id', $request->id)->update(['property_status' => $request->status]);
        if ($request->status == 1) {
            $update = $this->propertyList->where('id', $request->id)->update(['is_complete' => $request->status]);
        }
        if ($request->status == 5) {
            $this->propertyList->where('id', $request->id)->delete();
            $this->shor_term_pricing->where('property_id', $request->id)->delete();
            $this->PropertyImage->where('property_id', $request->id)->delete();
        }
        return response()->json(['status' => true, 'success_message' => 'Status updated successfully']);
    }
}
