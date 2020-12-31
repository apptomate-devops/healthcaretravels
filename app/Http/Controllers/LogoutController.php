<?php

namespace App\Http\Controllers;

use App\Services\Logger;
use Illuminate\Http\Request;
use Session;
use Auth;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        try {
            if (Auth::check()) {
                Auth::logout();
            }
            $request->session()->flush();
            return redirect('/');
        } catch (\Exception $ex) {
            Logger::error('Error trying logout' . $ex->getMessage());
        }
    }

    public function is_user_active(Request $request)
    {
        $user = $request->session()->get('user_id');
        if (!$user) {
            return response()->json(['status' => 'failed']);
        } else {
            return response()->json(['status' => 'success']);
        }
    }
}
