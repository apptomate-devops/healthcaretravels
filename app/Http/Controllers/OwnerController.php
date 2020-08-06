<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Users;
use App\Http\Controllers\Validator;
use DB;
use \stdClass;

class OwnerController extends BaseController
{
    public function owner_profile(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        if (!$user_id) {
            return redirect('/login')->with('error', 'Session timeout login again');
        }
        $client_id = $this->get_client_id();
        $user_detail = DB::table('users')
            ->where('client_id', '=', $client_id)
            ->where('id', '=', $user_id)
            ->first();

        foreach ($user_detail as $key => $value) {
            if ($value == '0') {
                $user_detail->$key = "";
            }
        }

        $agency = DB::table('agency')->get();
        $occupation = DB::table('occupation')->get();

        $country_codes = DB::table('country_code')
            ->where('client_id', '=', $client_id)
            ->get();

        return view('profile', [
            'user_detail' => $user_detail,
            'country_codes' => $country_codes,
            'agency' => $agency,
            'occupation' => $occupation,
        ]);
    }
}
