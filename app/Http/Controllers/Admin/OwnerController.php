<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\BaseController;
use DB;

class OwnerController extends BaseController
{
    //index
    public function index(Request $request)
    {
        $travellers = $this->db
            ::table('users')
            ->where('role_id', ONE)
            ->get();
        return view('Admin.owner', compact('travellers'));
    }

    public function status_update(Request $request)
    {
        // return $request->all();
        // $travellers = $this->db::table('users')->where('id',$request->id)->update(['status'=>$request->status]);
        // return response()->json(['status'=>true,'success_message'=>'Status updated successfully']);

        if ($request->status == 0 || $request->status == 1) {
            $travellers = $this->db
                ::table('users')
                ->where('id', $request->id)
                ->update(['status' => $request->status]);
            return back()
                ->with('error', 'Status updated successfully')
                ->with('status', 'info');
            // return response()->json(['status'=>true,'success_message'=>'Status updated successfully'],200);
        }
        if ($request->status == 2) {
            DB::table('users')
                ->where('id', $request->id)
                ->delete();
            return back()
                ->with('error', 'user deleted successfully')
                ->with('status', 'danger');
            // return response()->json(['status'=>true,'success_message'=>'Status updated successfully'],200);
        }
    }
    public function single_user(Request $request)
    {
        $data = $this->user::where('id', $request->id)->first();
        $document = DB::table('documents')
            ->where('user_id', $request->id)
            ->get();
        $mobile = DB::table('verify_mobile')
            ->where('user_id', $request->id)
            ->first();
        $total_posted = DB::table('property_list')
            ->where('user_id', $request->id)
            ->count();
        $total_booking = DB::table('property_booking')
            ->where('traveller_id', $request->id)
            ->count();
        $user_links = [
            'airbnb_link' => 'Airbnb Link',
            'home_away_link' => 'Home Away Link',
            'vrbo_link' => 'Vrbo Link',
            'agency_website' => 'Agency Website',
            'website' => 'Website',
            'property_tax_url' => 'Property tax url',
        ];
        return view('Admin.single-user', [
            'data' => $data,
            'document' => $document,
            'total_posted' => $total_posted,
            'total_booking' => $total_booking,
            'mobile' => $mobile,
            'user_links' => $user_links,
        ]);
    }
}
