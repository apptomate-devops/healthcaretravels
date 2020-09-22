<?php

namespace App\Helper;
use DB;
use Mail;
use Carbon\Carbon;
use App\Services\Logger;
use App\Services\Dwolla;
use App\Models\BookingPayments;

class Helper
{

    static public function send_custom_email($email, $subject, $view_name, $data, $title, $from = GENERAL_MAIL)
    {
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

    static public function process_booking_payment($booking_id, $payment_cycle, $is_owner = 0)
    {
        $payment = BookingPayments::where('booking_id', $booking_id)
            ->where('payment_cycle', $payment_cycle)
            ->where('is_owner', $is_owner)
            ->first();
        if (empty($payment)) {
            return ['success' => false, 'message' => 'No such payment exists!'];
        }
        $traveler = $payment->booking->traveler;
        $name = $traveler->first_name . ' ' . $traveler->last_name;
        $fundingSourceDetails = null;
        $subjectDate = Carbon::now()->format('m/d');
        $data = [
            'name' => $name,
            'amount' => $payment->total_amount,
            'booking_id' => $booking_id,
        ];
        $dwolla = new Dwolla();
        try {
            // Processing first payment cycle from user's side
            Logger::info(
                'Initiating transfer for booking: ' .
                    $booking_id .
                    ' :: paymentCycle: ' .
                    $payment_cycle .
                    ($is_owner ? ' To Owner' : ' From Traveler'),
            );
            $fundingSource = $payment->booking->funding_source;
            // Total amount is rent - service for traveler
            $amount = $payment->total_amount + $payment->service_tax;
            if ($is_owner) {
                // Total amount is rent - service for traveler
                $amount = $payment->total_amount - $payment->service_tax;
            }
            $transferDetails = null;
            if ($is_owner) {
                $transferDetails = $dwolla->createTransferToCustomer($fundingSource, $amount);
            } else {
                $transferDetails = $dwolla->createTransferToMasterDwolla($fundingSource, $amount);
            }
            Logger::info('Transfer success for booking: ' . $booking_id . ' for payment cycle: ' . $payment_cycle);
            $payment->transfer_url = $transferDetails;
            $payment->transfer_id = basename($transferDetails);
            $payment->processed_time = Carbon::now()->toDateTimeString();
            $payment->is_processed = 1;
            $payment->save();
            $fundingSourceDetails = $dwolla->getFundingSourceDetails($fundingSource);
            $subject = 'Payment Successfully Processed on ' . $subjectDate;
            $data['accountName'] = $fundingSourceDetails->name;
            Helper::send_custom_email($traveler->email, $subject, 'mail.payment-success', $data, 'Payment Processed');
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
            $payment->save();
            if (empty($fundingSourceDetails)) {
                $fundingSourceDetails = $dwolla->getFundingSourceDetails($fundingSource);
            }
            $data['accountName'] = $fundingSourceDetails->name;
            $subject = 'URGENT: Payment Failure on ' . $subjectDate;
            Helper::send_custom_email($traveler->email, $subject, 'mail.payment-failure', $data, 'Payment Processed');
            return ['success' => false, 'message' => $message];
        }
    }

    public static function get_price_details($property_details, $check_in, $check_out)
    {
        $current = Carbon::parse($check_in);
        $end = Carbon::parse($check_out);

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
                $neat_price = $payment['total_amount']; // consider price for remaining days
            } else {
                $months++;
                $neat_price = $payment['monthly_rate']; // consider price for full month

                if ($payment['payment_cycle'] == 1) {
                    // For Initial Payment
                    $day = 'On Approval';
                    $pay_now = $payment['total_amount'];
                }
            }

            $neat_amount = $neat_amount + $neat_price;
            $total_price = $total_price + $payment['total_amount'] + $payment['service_tax']; // TODO: not displaying service tax in payment schedules on pages

            array_push($scheduled_payments, [
                'day' => $day,
                'price' => $neat_price,
            ]);
        }

        $total_price = $total_price - $booking->security_deposit; // TODO: not displaying security_deposit in payment schedules on pages

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

    public static function generate_booking_payments($booking, $is_owner = 0)
    {
        $start_date = Carbon::parse($booking->start_date);
        $end_date = Carbon::parse($booking->end_date);
        $accepted_date = Carbon::now();
        $scheduler_date = Carbon::parse($booking->start_date);
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
                'covering_range' =>
                    Carbon::parse($booking->start_date)->format('m/d/Y') .
                    ' - ' .
                    Carbon::parse($booking->start_date)
                        ->addMonth()
                        ->format('m/d/Y'),
            ];
            if ($i == 1) {
                $data['service_tax'] = SERVICE_TAX;
                $data['total_amount'] = round(
                    $data['monthly_rate'] + $data['cleaning_fee'] + $data['security_deposit'],
                );
                $data['due_date'] = $accepted_date;
                if ($is_owner) {
                    $dd = Carbon::parse($booking->start_date)->addHours(48);
                    $check_in = str_replace(' AM', '', $booking->check_in);
                    $check_in = str_replace(' PM', '', $check_in);
                    $timeSplit = explode(':', $check_in);
                    $dd->hour = $timeSplit[0];
                    $dd->minute = $timeSplit[1];
                    $dd->second = 0;
                    // Because security deposit is handled at the end of checkout by admin or auto deposit
                    $data['total_amount'] = round($data['monthly_rate'] + $data['cleaning_fee']);
                    $data['due_date'] = $dd;
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
            if ($i == $totalCycles && $isPartial) {
                $data['total_amount'] = round($data['monthly_rate'] / $partialDays);
                $data['is_partial_days'] = $partialDays;
                $data['covering_range'] =
                    Carbon::parse($booking->start_date)->format('m/d/Y') .
                    ' - ' .
                    Carbon::parse($booking->start_date)
                        ->addDays($partialDays)
                        ->format('m/d/Y');
            }
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
