<?php

namespace App\Http\Controllers;

use App\Models\PropertyList;
use Illuminate\Http\Request;
use App\Models\PropertyBooking;
use App\Services\Logger;
use App\Models\Users;
use App\Models\BookingPayments;
use App\Models\DwollaEvents;
use App\Jobs\ProcessPayment;
use Carbon\Carbon;
use Helper;

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

    public function delete_funding_source(Request $request)
    {
        $id = $request->session()->get('user_id');
        $funding_source = $request->fundingSource;
        $user = Users::find($id);
        if (empty($user)) {
            return response()->json(['success' => false, 'error' => 'User does not exists!']);
        }
        try {
            $this->dwolla->deleteFundingSource($funding_source);
            $funding_sources = $this->dwolla->getFundingSourcesForCustomer($user->dwolla_customer);
            $user->default_funding_source =
                count($funding_sources) > 0 ? $funding_sources[0]->_links->self->href : null;
            $user->save();
        } catch (\Throwable $th) {
            Logger::error('Error in deleting funding source for user: ' . $id);
            return response()->json(['success' => false, 'error' => $th->getMessage()]);
        }
        return response()->json(['success' => true, 'funding_sources' => $funding_sources]);
    }

    public function add_funding_source(Request $request)
    {
        $id = $request->session()->get('user_id');
        $default_funding_source = $request->fundingSource;
        $fromProfile = $request->fromProfile;
        $user = Users::find($id);
        if (empty($user)) {
            return response()->json(['success' => false, 'error' => 'User does not exists!']);
        }
        $user->default_funding_source = $default_funding_source;
        $user->save();
        $request->session()->put('user_funding_source', $default_funding_source);
        $funding_sources = $this->dwolla->getFundingSourcesForCustomer($user->dwolla_customer);
        if ($fromProfile) {
            try {
                $bookings = PropertyBooking::getActiveBookingForUser($id);
                $activeBookings = $bookings->filter(function ($booking) {
                    return in_array($booking->status, [2, 3]);
                });
                $activeBookings->each(function ($booking) use ($id, $default_funding_source) {
                    $is_owner = $booking->owner_id == $id ? 1 : 0;
                    $updateBooking = PropertyBooking::where('id', $booking->id);
                    if ($is_owner) {
                        $updateBooking->update(['owner_funding_source' => $default_funding_source]);
                    } else {
                        $updateBooking->update(['funding_source' => $default_funding_source]);
                    }
                    $failedPayments = $booking->payments->where('status', PAYMENT_FAILED)->where('is_owner', $is_owner);
                    $failedPayments->each(function ($payment) {
                        Logger::info('Retrying payment for payment id: ' . $payment->id);
                        $scheduledTime = now()->addSeconds(5);
                        ProcessPayment::dispatch($payment->id)
                            ->delay($scheduledTime)
                            ->onQueue(PAYMENT_QUEUE);
                    });
                });
            } catch (\Exception $ex) {
                Logger::error('Error scheduling failed payments. EX: ' . $ex->getMessage());
            }
        }
        return response()->json(['success' => true, 'funding_sources' => $funding_sources]);
    }

    public function dwolla_webhook(Request $request)
    {
        Helper::setConstantsHelper();
        $proposedSignature = $request->header('X-Request-Signature-SHA-256');
        $eventType = $request->header('x-dwolla-topic');
        $payloadBody = json_encode($request->all(), JSON_UNESCAPED_SLASHES);
        $requiredEvents = ['transfer_completed', 'transfer_cancelled', 'transfer_failed'];
        Logger::info('Webhook called: eventType: ' . $eventType);
        Logger::info('ProposedSignature: ' . $proposedSignature);
        Logger::info('payload: ' . $payloadBody);
        $willBeUsed = in_array($eventType, $requiredEvents);
        $validation = $this->dwolla->verify_gateway_signature($proposedSignature, $payloadBody);
        if (!$validation['is_valid']) {
            // Note: Check me in the logs
            Logger::error('Failed to verify dwolla signature');
            // TODO: enable error when confirmed signatures are working
            // return response()->json(['success' => true, 'message' => 'Failed to verify dwolla signature']);
        }
        $event = new DwollaEvents();
        try {
            $event->dwolla_id = $request->id;
            $event->resource_id = $request->resourceId;
            $event->timestamp = $request->timestamp;
            $event->links = json_encode($request->_links);
            $event->dwolla_created = $request->created;
            $event->topic = $eventType;
            $event->proposed_signature = $proposedSignature;
            $event->generated_signature = $validation['generated_signature'];
            $event->is_valid_request = $validation['is_valid'];
            $event->is_used = $willBeUsed;
            $event->save();
        } catch (\Exception $ex) {
            Logger::error('Error in saving dwolla event: ' . $ex->getMessage());
        }
        if (!$willBeUsed) {
            return response()->json(['success' => true, 'message' => 'Unused event received']);
        }
        $resourceId = $request->resourceId;
        $payment = BookingPayments::getByTransactionId($resourceId);
        $paymentBooking = null;
        $fundingSource = null;
        $booking = null;
        if (empty($payment)) {
            $booking = PropertyBooking::findByResourceId($resourceId);
            if (empty($booking)) {
                return response()->json(['success' => false, 'message' => 'resource id does not exists!']);
            }
        }
        if ($payment) {
            $paymentBooking = $payment->booking;
            $fundingSource = $payment->is_owner
                ? $paymentBooking->owner_funding_source
                : $paymentBooking->funding_source;
        }
        $requestTime = Carbon::parse($request->timestamp)->toDateTimeString();
        switch ($eventType) {
            case 'transfer_cancelled':
            case 'transfer_failed':
                if ($payment) {
                    $payment->failed_time = $requestTime;
                    $payment->is_cleared = -1;
                    $payment->status = PAYMENT_FAILED;
                    $payment->failed_count += 1;
                    $payment->save();
                    Helper::send_payment_email($payment, $fundingSource, false);
                } elseif ($booking) {
                    if ($booking->owner_deposit_transfer_id == $resourceId) {
                        $booking->owner_deposit_failed_at = $requestTime;
                    } elseif ($booking->traveler_deposit_transfer_id == $resourceId) {
                        $booking->traveler_deposit_failed_at = $requestTime;
                    } elseif ($booking->cancellation_refund_transfer_id == $resourceId) {
                        $booking->cancellation_refund_failed_at = $requestTime;
                        $booking->cancellation_refund_status = PAYMENT_FAILED;
                    }
                    $booking->save();
                }
                break;
            case 'transfer_completed':
                if ($payment) {
                    $payment->confirmed_time = $requestTime;
                    $payment->is_cleared = 1;
                    $payment->status = PAYMENT_SUCCESS;
                    $payment->save();
                    // Scheduling payment for owner when payment is successful from traveler
                    if (!$payment->is_owner) {
                        // Finding related owner payment:
                        $ownerPayment = BookingPayments::where('booking_id', $payment->booking_id)
                            ->where('is_owner', 1)
                            ->where('payment_cycle', $payment->payment_cycle)
                            ->first();
                        $dueTime = Carbon::parse($ownerPayment->due_time);
                        if ($dueTime->lte(now())) {
                            $dueTime = now();
                        }
                        ProcessPayment::dispatch($ownerPayment->id)
                            ->delay($dueTime)
                            ->onQueue(PAYMENT_QUEUE);
                    }
                    Helper::send_payment_email($payment, $fundingSource, true);
                } elseif ($booking) {
                    if ($booking->owner_deposit_transfer_id == $resourceId) {
                        $booking->owner_deposit_confirmed_at = $requestTime;
                    } elseif ($booking->traveler_deposit_transfer_id == $resourceId) {
                        $booking->traveler_deposit_confirmed_at = $requestTime;
                        $traveller = $booking->traveler;
                        Helper::send_custom_email(
                            $traveller->email,
                            'Security Deposit Return',
                            'mail.security-deposit-refund',
                            ['name' => \App\Helper\Helper::get_user_display_name($traveller)],
                            'Payment Processed',
                        );
                    } elseif ($booking->cancellation_refund_transfer_id == $resourceId) {
                        $booking->cancellation_refund_confirmed_at = $requestTime;
                        $booking->cancellation_refund_status = PAYMENT_SUCCESS;
                    }
                    $booking->save();
                }
                break;
            default:
                Logger::info('Not required event received');
                break;
        }
        return response()->json(['isValidRequest' => $validation['is_valid']]);
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
            $transferDetails = $this->dwolla->createTransferToMasterDwolla($user->default_funding_source, 20);
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
    public function get_payment_options(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $user = Users::find($user_id);
        if (empty($user)) {
            return view('general_error', ['message' => 'We can’t find user.']);
        }
        $funding_sources = $this->dwolla->getFundingSourcesForCustomer($user->dwolla_customer);

        // TODO: get transaction history
        // TODO: confirm if owner can also book property

        $all_bookings = PropertyBooking::whereIn('status', [2, 4])
            ->where(function ($q) use ($user_id) {
                $q->where('traveller_id', $user_id)->orWhere('owner_id', $user_id);
            })
            ->select('booking_id', 'traveller_id', 'owner_id', 'property_id')
            ->get();
        $all_payments = [];
        foreach ($all_bookings as $booking) {
            $is_owner = (int) ($booking->owner_id == $user_id);
            $booking_details = PropertyBooking::where('booking_id', $booking->booking_id)->first();
            $property_details = PropertyList::find($booking->property_id);
            $payments = BookingPayments::where('booking_id', $booking->booking_id)
                ->where('is_owner', $is_owner)
                ->where('is_cleared', 1)
                ->get();
            $cleaning_fee = $booking_details->cleaning_fee ?? $property_details->cleaning_fee;
            $security_deposit = $booking_details->security_deposit ?? $property_details->security_deposit;

            foreach ($payments as $payment) {
                $payment->confirmed_time = Carbon::now();
                $transaction_record['transaction_date'] = Carbon::parse($payment->confirmed_time)->toDateString();
                $transaction_record['name'] = 'Housing Payment';
                $transaction_record['booking_id'] = $payment->booking_id;

                if ($is_owner) {
                    $transaction_record['payment'] = $payment->total_amount - $payment->service_tax;
                    $transaction_record['status'] = 'Credited';

                    if ($payment->payment_cycle == 1) {
                        // For cleaning fee entry
                        $cleaning_fee_record['name'] = 'Cleaning Fee';
                        $cleaning_fee_record['payment'] = $cleaning_fee;
                        $cleaning_fee_record['status'] = 'Credited';
                        $cleaning_fee_record['booking_id'] = $payment->booking_id;
                        $cleaning_fee_record['transaction_date'] = $transaction_record['transaction_date'];
                        array_push($all_payments, $cleaning_fee_record);

                        $transaction_record['payment'] = $payment->total_amount - $payment->service_tax - $cleaning_fee;
                    }
                } else {
                    $transaction_record['payment'] = $payment->total_amount;
                    $transaction_record['status'] = 'Debited';

                    if ($payment->payment_cycle == 1) {
                        // For cleaning fee entry
                        $cleaning_fee_record['name'] = 'Cleaning Fee';
                        $cleaning_fee_record['payment'] = $cleaning_fee;
                        $cleaning_fee_record['status'] = 'Debited';
                        $cleaning_fee_record['booking_id'] = $payment->booking_id;
                        $cleaning_fee_record['transaction_date'] = $transaction_record['transaction_date'];
                        array_push($all_payments, $cleaning_fee_record);

                        // For Security Deposit entry
                        $security_deposit_record['name'] = 'Security Deposit';
                        $security_deposit_record['payment'] = $security_deposit;
                        $security_deposit_record['status'] = 'Debited';
                        $security_deposit_record['booking_id'] = $payment->booking_id;
                        $security_deposit_record['transaction_date'] = $transaction_record['transaction_date'];
                        array_push($all_payments, $security_deposit_record);

                        // For Service fee entry
                        $service_tax_record['name'] = $payment['payment_cycle'] == 1 ? 'Service Fee' : 'Processing Fee';
                        $service_tax_record['payment'] = $payment->service_tax;
                        $service_tax_record['status'] = 'Debited';
                        $service_tax_record['booking_id'] = $payment->booking_id;
                        $service_tax_record['transaction_date'] = $transaction_record['transaction_date'];
                        array_push($all_payments, $service_tax_record);

                        $transaction_record['payment'] = $payment->total_amount - $security_deposit - $cleaning_fee;
                    }

                    // TODO: Add security deposit details here when handled
                }

                array_push($all_payments, $transaction_record);
            }
        }

        return view('payments.payment_options', [
            'user' => $user,
            'funding_sources' => $funding_sources,
            'all_payments' => $all_payments,
        ]);
    }
}
