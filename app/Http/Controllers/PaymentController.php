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
            return response()->json([
                'success' => false,
                'error' => 'Invalid user access',
            ]);
        }

        $user = Users::find($request->id);
        if (empty($user)) {
            return response()->json(['success' => false, 'error' => 'The user you are looking for does not exists!']);
        }

        $userPayload = $this->dwolla->getCustomerPayload($user, $request);
        if ($user->dwolla_customer) {
            // Customer has been created already and id is stored in DB
            $customer_id = $user->dwolla_customer;
        } else {
            // Check if email already registered on Dwolla
            $isExistingCustomer = $this->dwolla->findCustomerByEmail($user->email);
            $activeStatus = ['verified', 'unverified'];
            if ($isExistingCustomer && in_array($isExistingCustomer->status, $activeStatus)) {
                $customer_id = $isExistingCustomer->_links->self->href;
                $user->dwolla_customer = $customer_id;
                $user->save();
            } else {
                // Creating new customer
                // TODO: to be used with user payload
                $customer_id = $this->dwolla->createCustomerForUser($request->id, $user);
            }
        }

        Logger::info('CUSTOMER CREATION RESPONSE' . json_encode($customer_id));
        if (isset($customer_id) && is_string($customer_id)) {
            $res = $this->dwolla->getIAVToken($customer_id);
            if ($res && isset($res->token)) {
                Logger::info('GOT IAV TOKEN:' . $res->token);
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

    public function dwolla_webhook(Request $request)
    {
        $proposedSignature = $request->header('X-Request-Signature-SHA-256');
        $eventType = $request->header('x-dwolla-topic');
        $payloadBody = json_encode($request->all());
        $requiredEvents = ['transfer_completed', 'transfer_cancelled', 'transfer_failed'];
        if (!in_array($eventType, $requiredEvents)) {
            return response()->json(['success' => true, 'message' => 'Unused event received']);
        }
        Logger::info('Webhook called: eventType: ' . $eventType);
        Logger::info('ProposedSignature: ' . $proposedSignature);
        Logger::info('payload: ' . $payloadBody);
        $isValidRequest = $this->dwolla->verify_gateway_signature($proposedSignature, $payloadBody);
        switch ($eventType) {
            case 'transfer_cancelled':
            case 'transfer_failed':
                Logger::info('Handle Error use case');
                break;
            case 'transfer_completed':
                Logger::info('Handle transfer complete use case');
                break;
            default:
                Logger::info('Not required event received');
                break;
        }
        return response()->json(['isValidRequest' => $isValidRequest]);
    }

    public function get_funding_source_details(Request $request)
    {
        $fsUrl = $request->url;
        $transferDetails = $this->dwolla->getFundingSourceDetails($fsUrl);
        if ($transferDetails) {
            return response()->json(['success' => true, 'data' => $transferDetails]);
        }
        return response()->json(['success' => false]);
    }

    public function transfer(Request $request)
    {
        $user = Users::find(27);
        try {
            $transferDetails = $this->dwolla->createTransferToMasterDwolla($user->default_funding_source, 1000);
            return response()->json(['success' => true, 'transfer' => $transferDetails]);
        } catch (\Throwable $th) {
            $message = $th->getMessage();
            if (method_exists($th, 'getResponseBody')) {
                $message = $th->getResponseBody();
            }
            Logger::error('Ex in transfer payment data: ex: ', $message);
            return response()->json(['success' => false, 'message' => $message]);
        }
    }

    public function get_funding_source($fundingSourceUrl)
    {
        try {
            $fundingSource = $this->dwolla->fsApi->id($fundingSourceUrl);
            dd($fundingSource);
        } catch (\Throwable $th) {
            dd($th);
        }
    }
}
