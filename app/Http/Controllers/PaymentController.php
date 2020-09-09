<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;

class PaymentController extends BaseController
{
    public function create_customer($id, Request $request)
    {
        // TODO: get id value from users session
        $user = Users::find($id);
        if (empty($user)) {
            return view('general_error', ['message' => 'The user you are looking for does not exists!']);
        }
        $res = $this->dwolla->createCustomerForUser($id);
        dd($res);
    }

    public function get_funding_source_token($id, Request $request)
    {
        $user = Users::find($id);
        if (empty($user)) {
            return view('general_error', ['message' => 'The user you are looking for does not exists!']);
        }
        $res = $this->dwolla->getFundingSourceToken($id);
        dd($res);
    }

    public function create_funding_source($id)
    {
        // TODO: get id value from users session
        $user = Users::find($id);
        if (empty($user)) {
            return view('general_error', ['message' => 'The user you are looking for does not exists!']);
        }
        $res = $this->dwolla->getFundingSourceToken($id);
        if ($res) {
            return view('payment_test', ['token' => $res->token]);
        }
        return view('general_error', ['message' => 'There was an error creating funding source token for you']);
    }

    public function add_funding_source(Request $request)
    {
        // TODO: get id value from users session
        $id = $request->id;
        $default_funding_source = $request->fundingSource;
        $user = Users::find($id);
        if (empty($user)) {
            return response()->json(['success' => false, 'error' => 'User does not exists!']);
        }
        $user->default_funding_source = $default_funding_source;
        $user->save();
        return response()->json(['success' => true]);
    }
}
