<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Users;
use DB;
use Carbon\Carbon;

class UsersController extends BaseController
{
    //

    public function index(Request $request)
    {
        $users = DB::table('ad_users')->get();
        return view('Admin.admin-users', compact('users'));
    }

    public function add(Request $request)
    {
        $pages = DB::table('ad_pages')->get();
        return view('Admin.add-admin-user', compact('pages'));
    }
    public function change_status($id, $status)
    {
        echo $id;
    }

    public function approve($type)
    {
        $rowsUpdated = Users::where('role_id', '=', $type)
            ->where('is_verified', '=', 0)
            ->whereDate('created_at', Carbon::today())
            ->update(['is_verified' => 1]);
        return back()->with('approved', $rowsUpdated);
    }

    public function update_notes($id, Request $request)
    {
        $data = $request->responses;
        error_log(json_encode($data));
        Users::where('id', '=', $id)->update(['admin_notes' => $data['note']]);
    }
}
