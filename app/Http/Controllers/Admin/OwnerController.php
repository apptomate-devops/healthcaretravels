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
    public function co_host(Request $request)
    {
        $travellers = $this->db
            ::table('users')
            ->where('role_id', FOUR)
            ->get();
        return view('Admin.co_host', compact('travellers'));
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
        $data = $this->user
            ::leftJoin('user_role', 'users.role_id', '=', 'user_role.id')
            ->leftJoin('ad_users', 'users.approved_by', '=', 'ad_users.id')
            ->select('users.*', 'user_role.role', 'ad_users.name as approved_by_name')
            ->where('users.id', $request->id)
            ->first();
        $document = DB::table('documents')
            ->select('documents.*', 'ad_users.name as approved_by_name')
            ->leftJoin('ad_users', 'ad_users.id', '=', 'documents.approved_by')
            ->where('user_id', $request->id)
            ->get();
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
            'other_listing_link' => 'Other Listing Link',
            'agency_website' => 'Agency Website',
            'website' => 'Website',
            'property_tax_url' => 'Property tax url',
        ];
        $fields_to_omit = [
            'id',
            'client_id',
            'social_id',
            'password',
            'auth_token',
            'device_token',
            'role_id',
            'rep_code',
            'is_encrypted',
            'airbnb_link',
            'home_away_link',
            'vrbo_link',
            'other_listing_link',
            'agency_website',
            'property_tax_url',
            'status',
            'otp',
            'reset_date',
            'reset_password_token',
            'login_type',
            'denied_count',
            'ethnicity',
            'dwolla_email',
            'dwolla_last_name',
            'dwolla_first_name',
        ];
        return view('Admin.single-user', [
            'data' => $data,
            'document' => $document,
            'total_posted' => $total_posted,
            'total_booking' => $total_booking,
            'user_links' => $user_links,
            'fields_to_omit' => $fields_to_omit,
        ]);
    }
}
