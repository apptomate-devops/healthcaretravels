<?php

namespace App\Http\Controllers;

use App\Services\Logger;
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

    public function create_funding_source_token($id)
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

    public function create()
    {
        return view('payment_test');
    }

    public function create_customer_and_funding_source_token(Request $request)
    {
        // TODO: get id value from users session
        $user = Users::find($request->id);
        if (empty($user)) {
            return response()->json(['success' => false, 'error' => 'The user you are looking for does not exists!']);
        }
        $user->dwolla_first_name = $request->dwolla_first_name;
        $user->dwolla_last_name = $request->dwolla_last_name;
        $user->dwolla_email = $request->dwolla_email;
        $resCustomer = $this->dwolla->createCustomerForUser($request->id, $user);
        if (is_string($resCustomer)) {
            $res = $this->dwolla->getFundingSourceToken($request->id);
            if ($res) {
                return response()->json(['success' => true, 'token' => $res->token]);
            }
        }
        return response()->json([
            'success' => false,
            'error' => 'There was an error creating funding source token for you',
        ]);
    }

    public function create_customer_and_funding_source_token_with_validations(Request $request)
    {
        $user = Users::find($request->id);
        if (empty($user)) {
            return response()->json(['success' => false, 'error' => 'The user you are looking for does not exists!']);
        }
        if ($user->dwolla_customer) {
            $resCustomer = new \stdClass();
            $resCustomer->id = $user->dwolla_customer;
        } else {
            $isExistingCustomer = $this->dwolla->findCustomerByEmail($request->dwolla_emaill);
            if ($isExistingCustomer) {
                $resCustomer = $isExistingCustomer;
                $user->dwolla_customer = $isExistingCustomer->id;
                $user->save();
                // TODO: update customer details if we allow user to modify it's detail while adding bank account
            } else {
                $user->dwolla_first_name = $request->dwolla_first_name;
                $user->dwolla_last_name = $request->dwolla_last_name;
                $user->dwolla_email = $request->dwolla_email;
                $resCustomer = $this->dwolla->createCustomerForUser($request->id, $user);
            }
        }

        if (isset($resCustomer) && $resCustomer->id) {
            $res = $this->dwolla->getFundingSourceToken($request->id);
            Logger::info(' =========================== ' . json_encode($res));
            if ($res && isset($res->token)) {
                return response()->json(['success' => true, 'token' => $res->token]);
            }
        }
        return response()->json([
            'success' => false,
            'error' => 'There was an error creating funding source token for you',
        ]);
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

    public function transfer(Request $request)
    {
        $user = Users::find(27);
        $transferDetails = $this->dwolla->createTransferToMasterDwolla($user->default_funding_source, 1000);
        return response()->json(['success' => true, 'transfer' => $transferDetails]);
    }
}
