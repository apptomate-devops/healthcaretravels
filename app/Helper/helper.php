<?php

namespace App\Helper;

use DB;
use Mail;
use Carbon\Carbon;
use App\Services\Logger;
use App\Services\Dwolla;
use App\Models\BookingPayments;
use App\Models\PropertyBooking;
use App\Models\Settings;

class Helper
{
    public static function setConstantsHelper()
    {
        if (!defined('GENERAL_MAIL')) {
            Helper::set_settings_constants();
        }
    }

    public static function send_custom_email($email, $subject, $view_name, $data, $title, $from = GENERAL_MAIL)
    {
        Helper::setConstantsHelper();
        $mail_title = $title ?? 'Health Care Travels';
        $mail_from = $from ? $from : GENERAL_MAIL;
        try {
            Mail::send($view_name, $data, function ($message) use ($email, $mail_title, $subject, $mail_from) {
                Logger::info('Sending Mail From: ' . $mail_from . ' To: ' . $email);
                $message->from($mail_from, config('mail.from.name'));
                $message->to($email);
                $message->subject($subject);
            });
        } catch (\Exception $ex) {
            Logger::error('Error sending email to: ' . $email . ' : Error: ' . $ex->getMessage());
            return false;
        }
    }

    public static function generate_idempotency_key($payment)
    {
        $data = [$payment->id, $payment->booking_id, $payment->is_owner];
        return ['Idempotency-Key' => implode("-", $data)];
    }

    public static function generate_idempotency_key_for_deposit($booking, $is_owner = false, $is_refund = false)
    {
        $userId = $is_owner ? $booking->owner_id : $booking->traveller_id;
        $data = [$booking->id, $booking->booking_id, $userId];
        if ($is_refund) {
            array_push($data, 'refund');
        }
        return ['Idempotency-Key' => implode("-", $data)];
    }

    public static function send_payment_email($payment, $fundingSource, $success = false, $is_init = false)
    {
        $dwolla = new Dwolla();
        $booking = $payment->booking;
        $is_owner = boolval($payment->is_owner);
        $user = $is_owner ? $booking->owner : $booking->traveler;
        $name = $user->first_name . ' ' . $user->last_name;
        $fundingSourceDetails = null;
        $subjectDate = Carbon::now()->format('m/d');
        $data = [
            'name' => $name,
            'amount' => $payment->total_amount,
            'booking_id' => $booking->booking_id,
            'deposit' => $is_owner,
        ];
        $mailTemplate = 'mail.payment-failure';
        $fundingSourceDetails = $dwolla->getFundingSourceDetails($fundingSource);
        $subject = 'URGENT: Payment Failure on ' . $subjectDate;
        if ($success) {
            $mailTemplate = 'mail.payment-success';
            $subject = 'Payment Successfully Processed on ' . $subjectDate;
        }
        if ($is_init) {
            $mailTemplate = 'mail.payment-success-init';
            $subject = 'Your ' . ($is_owner ? 'Deposit' : 'Payment') . ' is Processing';
        }
        $data['accountName'] = $fundingSourceDetails->name;
        Helper::send_custom_email($user->email, $subject, $mailTemplate, $data, 'Payment Processed');
    }
    public static function process_booking_payment($booking_id, $payment_cycle, $is_owner = 0)
    {
        Helper::setConstantsHelper();
        $payment = BookingPayments::where('booking_id', $booking_id)
            ->where('payment_cycle', $payment_cycle)
            ->where('is_owner', $is_owner)
            ->first();
        if (empty($payment)) {
            Logger::info('No Payment found for booking: ' . $booking_id . ' :: paymentCycle: ' . $payment_cycle);
            return ['success' => false, 'message' => 'No such payment exists!'];
        }
        $dwolla = new Dwolla();
        $booking = $payment->booking;
        $fundingSource = $booking->funding_source;
        try {
            // Processing first payment cycle from user's side
            Logger::info(
                'Initiating transfer for booking: ' .
                    $booking_id .
                    ' :: paymentCycle: ' .
                    $payment_cycle .
                    ($is_owner ? ' To Owner' : ' From Traveler'),
            );
            // Total amount is rent - service for traveler
            $amount = $payment->total_amount + $payment->service_tax;
            if ($is_owner) {
                // Total amount is rent - service for traveler
                $amount = $payment->total_amount - $payment->service_tax;
                $fundingSource = $booking->owner_funding_source;
            }
            $transferDetails = null;
            $idempotency = Helper::generate_idempotency_key($payment);
            if ($is_owner) {
                $transferDetails = $dwolla->createTransferToCustomer($fundingSource, $amount, $idempotency);
            } else {
                $transferDetails = $dwolla->createTransferToMasterDwolla($fundingSource, $amount, $idempotency);
            }
            Logger::info('Transfer success for booking: ' . $booking_id . ' for payment cycle: ' . $payment_cycle);
            $payment->transfer_url = $transferDetails;
            $payment->transfer_id = basename($transferDetails);
            $payment->processed_time = Carbon::now()->toDateTimeString();
            $payment->is_processed = 1;
            $payment->status = PAYMENT_INIT;
            $payment->save();
            Helper::send_payment_email($payment, $fundingSource, true, true);
            return ['success' => true, 'message' => 'Payment has been processed successfully!'];
        } catch (\Exception $ex) {
            $message = $ex->getMessage();
            if (method_exists($ex, 'getResponseBody')) {
                $message = $ex->getResponseBody();
            }
            Logger::info('Transfer failed for booking: ' . $booking_id . ' for payment cycle: ' . $payment_cycle);
            Logger::info('Transfer failed ex: ' . $message);
            $payment->processed_time = Carbon::now()->toDateTimeString();
            $payment->failed_time = Carbon::now()->toDateTimeString();
            $payment->is_processed = 1;
            $payment->failed_reason = $message;
            $payment->status = PAYMENT_FAILED;
            $payment->failed_count += 1;
            $payment->save();
            Helper::send_payment_email($payment, $fundingSource, false);
            return ['success' => false, 'message' => $message];
        }
    }

    public static function get_price_details($property_details, $check_in, $check_out)
    {
        $current = Carbon::parse($check_in);
        $end = Carbon::parse($check_out);

        // TODO: fix me when displaying details :: We have constants for this and have different values as per user type and payment cycle
        $service_tax_row = DB::table('settings')
            ->where('param', 'service_tax')
            ->first();
        $service_tax = $service_tax_row->value;
        $cleaning_fee = $property_details->cleaning_fee;
        $security_deposit = $property_details->security_deposit;

        $property_details->start_date = $check_in;
        $property_details->end_date = $check_out;
        $property_details->booking_id = $property_details->booking_id ?? '';

        $scheduled_payment_details = Helper::get_months_and_days($property_details);

        $pay_now = $scheduled_payment_details['pay_now'];
        $total_price = $scheduled_payment_details['total_price'];
        $due_on_approve = $total_price - $pay_now;

        $booking_price = [
            'client_id' => CLIENT_ID,
            'service_tax' => $service_tax,
            'initial_pay' => 0,
            'check_in' => $check_in,
            'check_out' => $check_out,
            'cleaning_fee' => $cleaning_fee,
            'security_deposit' => $security_deposit,
            'pay_now' => $pay_now,
            'due_on_approve' => $due_on_approve,
            'total_price' => $total_price,
            'neat_amount' => $scheduled_payment_details['neat_amount'],
            'count_label' => $scheduled_payment_details['count_label'],
            'scheduled_payments' => $scheduled_payment_details['scheduled_payments'],
        ];
        return $booking_price;
    }

    public static function get_months_and_days($booking)
    {
        $all_scheduled_payments = Helper::generate_booking_payments($booking);
        $months = 0;
        $pay_now = 0;
        $neat_amount = 0;
        $total_price = 0;
        $partialDayCount = 0;
        $scheduled_payments = [];

        foreach ($all_scheduled_payments as $payment) {
            $day = Carbon::parse($payment['due_date'])->format('F d, Y');

            if (isset($payment['is_partial_days'])) {
                $partialDayCount = $payment['is_partial_days'];
                $neat_price = $payment['total_amount'] + $payment['service_tax']; // consider price for remaining days
                $section = [
                    $partialDayCount . ' Days' => $payment['total_amount'],
                    'Processing Fee' => $payment['service_tax'],
                ];
            } else {
                $months++;
                $neat_price = $payment['monthly_rate'] + $payment['service_tax']; // consider price for full month
                $section = [
                    $months . ' Month' => $payment['monthly_rate'],
                    $payment['payment_cycle'] == 1 ? 'Service Fee' : 'Processing Fee' => $payment['service_tax'],
                ];
                if ($payment['payment_cycle'] == 1) {
                    // For Initial Payment
                    $day = 'On Approval';
                    $pay_now = $payment['total_amount'] + $payment['service_tax'];
                }
            }

            $neat_amount = $neat_amount + $neat_price;

            array_push($scheduled_payments, [
                'day' => $day,
                'price' => $neat_price,
                'section' => $section,
            ]);
        }

        $total_price = $neat_amount + $booking->cleaning_fee + $booking->security_deposit;

        $day_count_label = $months . ' month' . ($months > 1 ? 's' : '');
        if ($partialDayCount) {
            $day_count_label = $day_count_label . ', ' . $partialDayCount . ' day' . ($partialDayCount > 1 ? 's' : '');
        }

        return [
            'count_label' => $day_count_label,
            'neat_amount' => $neat_amount,
            'total_price' => $total_price,
            'scheduled_payments' => $scheduled_payments,
            'pay_now' => $pay_now,
        ];
    }

    public static function get_daily_price($monthly_price)
    {
        return round($monthly_price / 30);
    }

    public static function get_stay_status($booking_data)
    {
        $now = Carbon::now()->startOfDay();
        $booking_starts_on = Carbon::parse($booking_data->start_date)->startOfDay();
        $booking_ends_on = Carbon::parse($booking_data->end_date)->startOfDay();

        if ($booking_ends_on->diffInDays() > 0) {
            return 'Past Stay';
        } elseif ($booking_data->status == 2) {
            if ($now->between($booking_starts_on, $booking_ends_on)) {
                return 'Current Stay';
            }
            return 'Approved Stay';
        }
        return 'Pending Stay';
    }

    public static function get_payment_status($value, $is_owner = 0)
    {
        switch ($value) {
            case -1:
                return $is_owner ? 'Error' : 'Failed';
            case 1:
                return 'Completed';
            default:
                return 'Pending';
        }
    }

    public static function get_traveller_status($status, $start_date, $end_date)
    {
        switch ($status) {
            case 1:
                return 'Pending Approval';
            case 2:
                $now = Carbon::now()->startOfDay();
                $booking_starts_on = Carbon::parse($start_date)->startOfDay();
                $booking_ends_on = Carbon::parse($end_date)->startOfDay();
                if ($now->between($booking_starts_on, $booking_ends_on)) {
                    return 'Happening Now';
                }
                return 'Approved';
            case 3:
                return 'Ended';
            case 4:
                return 'Denied';
            case 8:
                return 'Cancelled';
            default:
                return '';
        }
    }

    public static function get_time_split($time)
    {
        $time = str_replace(' AM', '', $time);
        $time = str_replace(' PM', '', $time);
        return explode(':', $time);
    }

    public static function processSecurityDepositForBooking($id, $from_job = false)
    {
        $booking = PropertyBooking::find($id);
        if (empty($booking)) {
            Logger::error('Booking does not exist: ' . $id);
            return ['success' => false, 'errorMessage' => 'Booking does not exist!'];
        }
        if ($from_job && !$booking->should_auto_deposit) {
            Logger::error('Security deposit was marked not to auto deposit: ' . $id);
            return ['success' => false, 'errorMessage' => 'Security deposit was marked not to auto deposit'];
        }
        if ($from_job && $booking->is_deposit_handled_by_admin) {
            Logger::error('Security deposit was handled by admin: ' . $id);
            return ['success' => false, 'errorMessage' => 'Security deposit was handled by admin'];
        }
        if ($booking->is_deposit_handled) {
            Logger::error('Security deposit was already handled: ' . $id);
            return ['success' => false, 'errorMessage' => 'Security deposit was already handled'];
        }
        Logger::info('Initiating security deposit handler for: ' . $id);
        $dwolla = new Dwolla();
        $owner = $booking->owner;
        $travelerRes = null;
        $ownerRes = null;
        $hasOwnerPart = 0;
        if ($booking->owner_cut && $booking->owner_cut > 0) {
            $hasOwnerPart = 1;
        }
        // Handling raveler part
        try {
            if ($booking->traveler_deposit_transfer_id) {
                $travelerRes = [
                    'success' => true,
                    'successMessage' => 'Security deposit has been handled for traveler',
                ];
            }
            Logger::info('Initiating transfer for traveler: bookingID: ' . $id);
            $fundingSource = $booking->funding_source;
            $amount = $booking->traveler_cut;
            $idempotency = Helper::generate_idempotency_key_for_deposit($booking, false);
            $transferDetails = $dwolla->createTransferToCustomer($fundingSource, $amount, $idempotency);
            $booking->traveler_deposit_transfer_id = basename($transferDetails);
            $booking->traveler_deposit_processed_at = Carbon::now()->toDateTimeString();
            if (!$hasOwnerPart) {
                $booking->is_deposit_handled = 1;
                $booking->deposit_handled_at = Carbon::now()->toDateTimeString();
            }
            $booking->save();
            Logger::info('Security deposit handled successfully for traveler: ' . $id);
            $travelerRes = ['success' => true, 'successMessage' => 'Security deposit has been handled for traveler'];
        } catch (\Exception $ex) {
            $message = $ex->getMessage();
            Logger::error('Error in handling security deposit for: ' . $id . '. EX: ', $message);
            if (method_exists($ex, 'getResponseBody') && $ex->getResponseBody()) {
                $message .= ' :: ' . $ex->getResponseBody();
            }
            Logger::error('Error in handling security deposit for: ' . $id . '. EX: ', $message);
            $booking->traveler_deposit_processed_at = Carbon::now()->toDateTimeString();
            $booking->traveler_deposit_failed_at = Carbon::now()->toDateTimeString();
            $booking->traveler_deposit_failed_reason = $message;
            $booking->save();
            $travelerRes = ['success' => false, 'errorMessage' => $message];
        }
        if (!$hasOwnerPart) {
            return $travelerRes;
        }
        // Handling owner part
        try {
            if ($booking->owner_deposit_transfer_id) {
                $ownerRes = ['success' => true, 'successMessage' => 'Security deposit has been handled for owner'];
            }
            Logger::info('Initiating transfer for owner: bookingID: ' . $id);
            $fundingSource = $booking->owner_funding_source;
            $amount = $booking->owner_cut;
            $idempotency = Helper::generate_idempotency_key_for_deposit($booking, true);
            $transferDetails = $dwolla->createTransferToCustomer($fundingSource, $amount, $idempotency);
            $booking->owner_deposit_transfer_id = basename($transferDetails);
            $booking->owner_deposit_processed_at = Carbon::now()->toDateTimeString();
            if ($travelerRes['success']) {
                $booking->is_deposit_handled = 1;
                $booking->deposit_handled_at = Carbon::now()->toDateTimeString();
            }
            $booking->save();
            Logger::info('Security deposit handled successfully for owner: ' . $id);
            $ownerRes = ['success' => true, 'successMessage' => 'Security deposit has been handled for owner'];
            // TODO: add email for sending email about security deposit return to traveler.
        } catch (\Exception $ex) {
            $message = $ex->getMessage();
            Logger::error('Error in handling security deposit for: ' . $id . '. EX: ', $message);
            if (method_exists($ex, 'getResponseBody') && $ex->getResponseBody()) {
                $message .= ' :: ' . $ex->getResponseBody();
            }
            Logger::error('Error in handling security deposit for: ' . $id . '. EX: ', $message);
            $booking->owner_deposit_processed_at = Carbon::now()->toDateTimeString();
            $booking->owner_deposit_failed_at = Carbon::now()->toDateTimeString();
            $booking->owner_deposit_failed_reason = $message;
            $booking->save();
            $ownerRes = ['success' => false, 'errorMessage' => $message];
        }
        $res = ['success' => $ownerRes['success'] && $travelerRes['success']];
        if ($res['success']) {
            $res['successMessage'] = 'Security deposit has been handled successfully';
        } elseif ($ownerRes['success']) {
            $res['successMessage'] = $ownerRes['successMessage'];
            $res['errorMessage'] = $travelerRes['errorMessage'];
        } elseif ($travelerRes['success']) {
            $res['successMessage'] = $travelerRes['successMessage'];
            $res['errorMessage'] = $ownerRes['errorMessage'];
        } else {
            $res['errorMessage'] = 'Error in handling security deposit';
        }
        return $res;
    }

    public static function generate_booking_payments($booking, $is_owner = 0)
    {
        $start_date = Carbon::parse($booking->start_date);
        $end_date = Carbon::parse($booking->end_date);
        $accepted_date = Carbon::now();
        $scheduler_date = Carbon::parse($booking->start_date);
        $timeSplit = Helper::get_time_split($booking->check_in);
        $scheduler_date->hour = $timeSplit[0];
        $scheduler_date->minute = $timeSplit[1];
        $scheduler_date->second = 0;
        // Finding Partial month days
        $lastMonthRenew = Carbon::parse($booking->end_date);
        if ($lastMonthRenew->day < $start_date->day) {
            $lastMonthRenew->subMonth();
        }
        $lastMonthRenew->day = $start_date->day;
        $partialDays = $end_date->diffInDays($lastMonthRenew);
        // Getting total payment Cycles
        $totalCycles = $start_date->diffInMonths($end_date);
        $isPartial = $partialDays > 0;
        if ($isPartial) {
            $totalCycles++;
        }
        // Generating payment schedules that can be used to process payments and keep track of them.
        $scheduled_payments = [];
        for ($i = 1; $i <= $totalCycles; $i += 1) {
            $data = [
                'payment_cycle' => $i,
                'service_tax' => SERVICE_TAX_SECOND,
                'partial_days' => $partialDays,
                'booking_id' => $booking->booking_id, // Represents booking id used all over the application
                'booking_row_id' => $booking->id, // Represents primary key id of booking table
                'cleaning_fee' => $booking->cleaning_fee,
                'security_deposit' => $booking->security_deposit,
                'monthly_rate' => $booking->monthly_rate,
                'is_owner' => $is_owner,
            ];
            if ($i == 1) {
                $data['service_tax'] = SERVICE_TAX;
                $data['total_amount'] = round(
                    $data['monthly_rate'] + $data['cleaning_fee'] + $data['security_deposit'],
                );
                $data['due_date'] = $accepted_date;
                if ($is_owner) {
                    $dd = Carbon::parse($booking->start_date)->addHours(48);
                    $timeSplit = Helper::get_time_split($booking->check_in);
                    $dd->hour = $timeSplit[0];
                    $dd->minute = $timeSplit[1];
                    $dd->second = 0;
                    // Because security deposit is handled at the end of checkout by admin or auto deposit
                    $data['total_amount'] = round($data['monthly_rate'] + $data['cleaning_fee']);
                    $data['due_date'] = $dd;
                } else {
                    // TODO: check if traveller is an agency and update service tax
                    Logger::info('Role id: ' . $booking->role_id);
                    if ($booking->role_id == 2) {
                        $data['service_tax'] = AGENCY_SERVICE_TAX;
                    }
                }
            } else {
                $data['total_amount'] = round($data['monthly_rate']);
                $scheduler_date->addMonth();
                $data['due_date'] = $scheduler_date;
                if ($is_owner) {
                    $dd = Carbon::parse($scheduler_date->toDateTimeString())->addHours(48);
                    $data['due_date'] = $dd;
                }
            }

            $data['covering_range'] =
                Carbon::parse($booking->start_date)
                    ->addMonth($i - 1)
                    ->format('m/d/Y') .
                ' - ' .
                Carbon::parse($booking->start_date)
                    ->addMonth($i)
                    ->format('m/d/Y');

            if ($i == $totalCycles && $isPartial) {
                $data['total_amount'] = round(($data['monthly_rate'] * $partialDays) / 30);
                $data['is_partial_days'] = $partialDays;
                $data['covering_range'] =
                    $data['due_date']->format('m/d/Y') .
                    ' - ' .
                    $data['due_date']->addDays($partialDays)->format('m/d/Y');
            }
            $data['due_time'] = $data['due_date'];
            $data['due_date'] = $data['due_date']->toDateString();
            array_push($scheduled_payments, $data);
        }
        return $scheduled_payments;
    }

    public static function reloadEnv()
    {
        $dotenvLoader = new \Dotenv\Dotenv(base_path());
        $dotenvLoader->overload();
        config([
            'services.dwolla.master_account' => env('DWOLLA_MASTER_ACCOUNT'),
            'services.dwolla.master_funding_source' => env('DWOLLA_MASTER_FUNDING_SOURCE'),
            'services.dwolla.access_token' => env('DWOLLA_ACCESS_TOKEN'),
        ]);
    }

    public static function start_chat($property_id, $request)
    {
        Helper::setConstantsHelper();
        $user_id = $request->session()->get('user_id');
        if (!$user_id) {
            $request->session()->put('request_chat_property_id', $property_id);
            return redirect('/login');
        }
        $property_detail = DB::table('property_list')
            ->where('client_id', CLIENT_ID)
            ->where('id', $property_id)
            ->first();
        $ins_data = [];
        $ins_data['client_id'] = CLIENT_ID;
        $ins_data['owner_id'] = $property_detail->user_id;
        $ins_data['property_id'] = $property_id;
        $ins_data['traveller_id'] = $user_id;
        $ins_data['sent_by'] = $request->session()->get('user_id');
        $ins_data['message'] = "Hi";
        $chat_check = DB::table('personal_chat')
            ->where('client_id', CLIENT_ID)
            ->where('owner_id', $property_detail->user_id)
            ->where('traveller_id', $request->session()->get('user_id'))
            ->where('property_id', $property_id)
            ->first();
        if ($chat_check) {
            $chat_get = DB::table('personal_chat')
                ->where('client_id', CLIENT_ID)
                ->where('owner_id', $chat_check->owner_id)
                ->where('traveller_id', $chat_check->traveller_id)
                ->where('property_id', $property_id)
                ->where('owner_visible', 1)
                ->first();
            $chat_id = $chat_get->id;
        } else {
            $chat_id = DB::table('personal_chat')->insertGetId($ins_data);
        }

        $message = "Enquiry sent for ";
        $message .= $property_detail->title;
        $message .= ", Property ID :" . $property_id;
        if ($request->check_in) {
            $message .=
                " on " .
                date("m/d/Y", strtotime($request->check_in)) .
                " to " .
                date("m/d/Y", strtotime($request->check_out));
        }

        // firebase write starts
        $date_fmt = date("m/d/Y H:i A");
        $values = [];
        $values['traveller_id'] = $request->session()->get('user_id');
        $values['owner_id'] = $property_detail->user_id;
        $values['sent_by'] = $request->session()->get('user_id');
        $values['property_id'] = $property_id;
        $values['date'] = $date_fmt;
        $values['message'] = "Hi, " . $message;
        $values['header'] = ONE;
        $postdata = json_encode($values);
        $header = [];
        $header[] = 'Content-Type: application/json';
        $url = FB_URL . PERSONAL_CHAT . '/' . $chat_id . '/start.json';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        $result = curl_exec($ch);
        curl_close($ch);

        $traveler = DB::table('users')
            ->where('id', $request->session()->get('user_id'))
            ->first();
        $owner = DB::table('users')
            ->where('id', $property_detail->user_id)
            ->first();

        if ($owner->email != "0") {
            $content = $message;

            $data = ['username' => $owner->username, 'content' => $content];

            $subject = "Enquiry for Your Property";
            $title = $traveler->username . " sends Enquiry for Your Property";
            $owner_mail = $owner->email;
            $mail_data = ['username' => $owner->username, 'content' => $content];
            Helper::send_custom_email($owner_mail, $subject, 'mail.custom-email', $data, 'Payment Processed');
        }

        return redirect()->intended('/traveler/chat/' . $chat_id . '?fb-key=personal_chat&fbkey=personal_chat');
    }

    public static function set_settings_constants()
    {
        Helper::reloadEnv();
        $BASE_URL = config("app.url");

        define("MAP_MARKER_ICON", "http://api.estatevue2.com/cdn/img/marker-green.png");
        define("PROFILE_IMAGE", "https://demo.rentalslew.com/public/user_profile_default.png");
        define("STATIC_IMAGE", "http://vyrelilkudumbam.com/wp-content/uploads/2014/07/NO_DATAy.jpg");
        define("APP_BASE_NAME", "Health Care Travels");
        define("APP_ENV", env("APP_ENV", "local"));
        define("IS_LOCAL", env("APP_ENV", "local") == "local");
        define("EMAIL_QUEUE", env("APP_ENV", "local") . ":emails");
        define("PAYMENT_QUEUE", env("APP_ENV", "local") . ":payments");
        define("DWOLLA_ENV", config('services.dwolla.env'));

        define("APP_LOGO_URL", "https://demo.rentalslew.com/public/keepers_logo.png");
        define("TIMEZONE", "Asia/Kolkata");

        define("BASE_URL", $BASE_URL . "/");

        define("BASE_COLOR", "e88016");
        define("CLIENT_ID", "15465793");
        define("RADIUS", 100);
        define("MOST_POPULAR", 1);
        define("ACTIVE", 1);
        define("BLOCK", 0);
        define("SUCCESS", "SUCCESS");
        define("SAMPLE_IMAGE", "http://res.cloudinary.com/dazx7zpzb/image/upload/v1519884570/sample.jpg");
        define("CLEANING_FEE_TYPES", serialize(["Per Night", "Per Guest", "Per Night Per Guest", "Single Fee"]));
        define("CITY_FEE_TYPES", serialize(["Per Night", "Per Guest", "Per Night Per Guest", "Single Fee"]));

        define("UPLOAD_CLOUD_NAME", "dazx7zpzb");
        define("UPLOAD_API_KEY", "139546971995199");
        define("UPLOAD_API_SECRET", "knkkiEXjEsceHTNjfSRADRvmSHQ");
        define("UPLOAD_BASE_DELIVERY_URL", "http://res.cloudinary.com/dazx7zpzb");
        define("UPLOAD_SECURE_DELIVERY_URL", "https://res.cloudinary.com/dazx7zpzb");

        define("UPLOAD_API_BASE_URL", "https://api.cloudinary.com/v1_1/dazx7zpzb");

        define("COUNTRY_CODE", config("app.country_code"));

        define("ZERO", 0);
        define("ONE", 1);
        define("TWO", 2);
        define("THREE", 3);
        define("FOUR", 4);
        define("FIVE", 5);
        define("SIX", 6);
        define("SEVEN", 7);
        define("EIGHT", 8);
        define("NINE", 9);
        define("TEN", 10);

        define("PROPERTY_IMAGE_WIDTH", 520);
        define("PROPERTY_IMAGE_HEIGHT", 400);
        define("DOUBLE_BED", $BASE_URL . "/bedicons/King,-Queen,Double-Bed.png");
        define("QUEEN_BED", $BASE_URL . "/bedicons/King,-Queen,Double-Bed.png");
        define("SINGLE_BED", $BASE_URL . "/bedicons/Single.png");
        define("SOFA_BED", $BASE_URL . "/bedicons/Sofa.png");
        define("BUNK_BED", $BASE_URL . "/bedicons/Bunk-Bed.png");
        define("COMMON_SPACE_BED", $BASE_URL . "/bedicons/Couch.png");

        define("GOOGLE_MAPS_API_KEY", config("services.google.maps_api_key"));
        define("RECAPTCHA_SITE_KEY", config("services.google.captcha_site_key"));
        define("RECAPTCHA_SECRET_KEY", config("services.google.captcha_secret_key"));

        define("IS_GOOGLE_SOCIAL_ENABLED", (bool) config("services.google.client_id"));
        define("IS_FACEBOOK_SOCIAL_ENABLED", (bool) config("services.facebook.client_id"));

        define("INSTANT_CHAT", "instant_chat");
        define("REQUEST_CHAT", "request_chat");
        define("PERSONAL_CHAT", "personal_chat");

        define(
            "MONTHS",
            serialize([
                "January",
                "February",
                "March",
                "April",
                "May",
                "June",
                "July",
                "August",
                "September",
                "October",
                "November",
                "December",
            ]),
        );

        define(
            'PASSWORD_REGEX',
            'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#^_+=.:;><~$!%*?&])[A-Za-z\d@#^_+=.:;><~$!%*?&]{8,}$/i',
        );
        define(
            'PASSWORD_REGEX_MESSAGE',
            'Password should be at least 8 characters long and should contain at least 1 uppercase, 1 lowercase, 1 number and 1 special character',
        );

        define('ETHNICITY', [
            'American Indian or Alaskan Native',
            'Asian',
            'Black or African American',
            'Native Hawaiian or Pacific Islander',
            'White',
            'Other',
        ]);

        define('OWNER_CANCELLATION_REASONS', [
            'Personal reasons',
            'Traveler damaged or disrespected property',
            'Traveler broke property rules',
            'Traveler requested cancellation',
            'Traveler not responsive',
            'Traveler left their stay',
            'Traveler was a scam',
            'The property is no longer available',
            'Other reason',
        ]);

        define('TRAVELLER_CANCELLATION_REASONS', [
            'Personal / Sick',
            'Lost/ended job offer',
            'Found another place to stay',
            'Property misrepresented',
            'Other reason',
        ]);

        //define("UPLOAD_CLOUD_NAME","dazx7zpzb");
        define("START_YEAR", "2018");
        define("END_YEAR", "2040");
        define("SEARCH_ITEM_COUNT", 10);
        $all_settings = Settings::all();
        foreach ($all_settings as $setting) {
            switch ($setting->param) {
                case 'logo':
                    define("LOGO", $setting->value);
                    break;
                case 'app_name':
                    define("APP_NAME", $setting->value);
                    break;
                case 'currency':
                    define("CURRENCY", $setting->value);
                    break;
                case 'client_email':
                    define("CLIENT_MAIL", $setting->value);
                    break;
                case 'client_phone':
                    define("CLIENT_PHONE", $setting->value);
                    break;
                case 'client_web':
                    define("CLIENT_WEB", $setting->value);
                    break;
                case 'client_address':
                    define("CLIENT_ADDRESS", $setting->value);
                    break;
                case 'contact_content':
                    define("CONTACT_CONTENT", $setting->value);
                    break;
                case 'verification_mail':
                    define("VERIFY_MAIL", $setting->value);
                    break;
                case 'support_mail':
                    define("SUPPORT_MAIL", $setting->value);
                    break;
                case 'general_mail':
                    define("GENERAL_MAIL", $setting->value);
                    break;
                case 'facebook':
                    define("FACEBOOK", $setting->value);
                    break;
                case 'twitter':
                    define("TWITTER", $setting->value);
                    break;
                case 'google':
                    define("GOOGLE", $setting->value);
                    break;
                case 'instagram':
                    define("INSTAGRAM", $setting->value);
                    break;
                case 'service_tax':
                    define("SERVICE_TAX", $setting->value);
                    break;
                case 'agency_service_tax':
                    define("AGENCY_SERVICE_TAX", $setting->value);
                    break;
                case 'service_tax_second':
                    define("SERVICE_TAX_SECOND", $setting->value);
                    break;
                default:
                    break;
            }
        }

        define("TEMPLATE_REGISTER", 1);
        define("TEMPLATE_VERIFICATION", 2);
        define("TEMPLATE_BOOKING", 3);
        define("TEMPLATE_CANCEL_BOOKING", 4);
        define("TEMPLATE_PASSWORD_RESET", 5);
        define("TEMPLATE_APPROVAL", 6);
        define("TEMPLATE_DENIAL", 7);
        define("TEMPLATE_VERIFICATION_REMINDER", 8);
        define("TEMPLATE_REMOVE_PROFILE_IMAGE", 9);
        define("TEMPLATE_TRAVELER_24HR_BEFORE_CHECKIN", 10);
        define("TEMPLATE_OWNER_24HR_BEFORE_CHECKIN", 11);
        define("TEMPLATE_TRAVELER_24HR_BEFORE_CHECKOUT", 12);
        define("TEMPLATE_OWNER_24HR_BEFORE_CHECKOUT", 13);
        define("TEMPLATE_SECURITY_DEPOSIT_REFUND", 14);

        define('FB_URL', 'https://health-care-travels.firebaseio.com/');
        define("PAYMENT_INIT", 1);
        define("PAYMENT_SUCCESS", 2);
        define("PAYMENT_FAILED", 3);
    }

    public static function changeEnv($data = [])
    {
        if (count($data) > 0) {
            // Read .env-file
            $env = file_get_contents(base_path() . '/.env');
            // Split string on every new line and write into array
            // $env = preg_split('/\s(?=[^"]*("[^"]*"[^"]*)*$)/', $env);
            $env = preg_split('/\n/', $env);
            // Loop through given data
            foreach ((array) $data as $key => $value) {
                $isWritten = false;
                // Loop through .env-data
                foreach ($env as $env_key => $env_value) {
                    // Turn the value into an array and stop after the first split
                    // So it's not possible to split e.g. the App-Key by accident
                    $entry = explode("=", $env_value, 2);

                    // Check, if new key fits the actual .env-key
                    if ($entry[0] == $key) {
                        // If yes, overwrite it with the new one
                        $isWritten = true;
                        $env[$env_key] = $key . "=" . $value;
                    } else {
                        // If not, keep the old one
                        $env[$env_key] = $env_value;
                    }
                }
                if (!$isWritten) {
                    $env[$key] = $key . "=" . $value;
                }
            }

            // Turn the array back to an String
            $env = implode("\n", $env);

            // And overwrite the .env with the new data
            file_put_contents(base_path() . '/.env', $env);
            \Artisan::call("config:cache");
            \Artisan::call("config:clear");
            \Artisan::call("cache:clear");
            \Artisan::call("route:clear");
            \Artisan::call("view:clear");

            return true;
        } else {
            return false;
        }
    }
}
