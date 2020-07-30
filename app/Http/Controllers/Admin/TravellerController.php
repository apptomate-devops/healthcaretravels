<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class TravellerController extends BaseController
{
    //
    public function index(Request $request)
    {
        $travellers = $this->db
            ::table('users')
            ->where('role_id', ZERO)
            ->get();
        //print_r($travellers);exit;
        return view('Admin.travellers', compact('travellers'));
    }

    public function rv_travellers(Request $request)
    {
        $travellers = $this->db
            ::table('users')
            ->where('role_id', THREE)
            ->get();
        return view('Admin.rv_travellers', compact('travellers'));
    }

    public function agency(Request $request)
    {
        $agencyes = $this->db
            ::table('users')
            ->where('role_id', TWO)
            ->get();
        return view('Admin.agency', compact('agencyes'));
    }
}
