<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class TransactionController extends BaseController
{
    public function transaction_history(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $users_property = DB::table('property_list')
            ->where('user_id', $user_id)
            ->where('client_id', CLIENT_ID)
            ->select('id', 'title')
            ->get();

        $payment_methods = DB::table('payment_method')
            ->where('user_id', $user_id)
            ->where('account_number', '!=', 0)
            ->select('id', 'account_number')
            ->get();

        $payment_dones = DB::table('property_booking')

            ->join('property_list', 'property_list.id', '=', 'property_booking.property_id')
            ->where('property_list.user_id', '=', $user_id)
            ->get();
        return view('owner.transaction_history', [
            'payment_dones' => $payment_dones,
            'users_property' => $users_property,
            'payment_methods' => $payment_methods,
        ]);
    }
}
