<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use DB;

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
        # code...
        $pages = DB::table('ad_pages')->get();
        return view('Admin.add-admin-user', compact('pages'));
    }
    public function change_status($id, $status)
    {
        echo $id;
    }
}
