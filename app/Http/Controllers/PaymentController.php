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
        $user_id = $request->session()->get('user_id');

        if ($user_id != $request->id) {
            // Do not allow other user to access booking details
            return view('general_error', ['message' => 'Invalid Access']);
        }

        $user = Users::find($request->id);
        if (empty($user)) {
            return response()->json(['success' => false, 'error' => 'The user you are looking for does not exists!']);
        }

        $userPayload = $this->dwolla->getCustomerPayload($user, $request);
        if ($user->dwolla_customer) {
            // Customer has been created already and id is stored in DB
            $resCustomer = new \stdClass();
            $customer_id = $this->dwolla->verifyCustomer($user->dwolla_customer, $userPayload);
            $resCustomer->id = $customer_id;
        } else {
            // Check if email already registered on Dwolla
            $isExistingCustomer = $this->dwolla->findCustomerByEmail($request->dwolla_emaill);
            if ($isExistingCustomer) {
                $resCustomer = $isExistingCustomer;
                $customer_id = $this->dwolla->verifyCustomer($isExistingCustomer->id, $userPayload);
                $user->dwolla_customer = $customer_id;
                $user->save();
            } else {
                $user->dwolla_address = $request->dwolla_address;
                $user->dwolla_city = $request->dwolla_city;
                $user->dwolla_state = $request->dwolla_state;
                $user->dwolla_pin_code = $request->dwolla_pin_code;
                $user->dwolla_ssn = $request->dwolla_ssn;
                // TODO: to be used with user payload
                $resCustomer = $this->dwolla->createCustomerForUser($request->id, $user);
            }
        }

        if (isset($resCustomer) && $resCustomer->id) {
            $res = $this->dwolla->getFundingSourceToken($request->id);
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
