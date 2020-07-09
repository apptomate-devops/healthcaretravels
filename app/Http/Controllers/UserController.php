<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\EmailConfig;
use App\Models\Users;
use DB;
use Log;
use Mail;

class UserController extends BaseController
{
    public function login(Request $request)
    {
        $constants = $this->constants();

        $agency = DB::table('agency')->get();
        $occupation = DB::table('occupation')->get();
        $data = [];
        return view('login', [
            'constants' => $constants,
            'agency' => $agency,
            'data' => $data,
            'occupation' => $occupation,
        ]);
    }
}
