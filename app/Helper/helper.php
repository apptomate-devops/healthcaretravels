<?php

namespace App\Helper;
use Carbon\Carbon;
use DB;

class Helper
{
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

        $neatAmount = $scheduled_payment_details['neat_amount'];
        $pay_now = $scheduled_payment_details['pay_now'];
        $total_price = $neatAmount + $cleaning_fee + $service_tax;
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
            'neat_amount' => $neatAmount,
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
        $scheduled_payments = [];
        foreach ($all_scheduled_payments as $payment) {
            $day = date("F d, Y", strtotime($payment['due_date']));

            if (isset($payment['is_partial_days'])) {
                $partialDayDetails = $payment;
                $price = $payment['total_amount'];
            } else {
                $months++;
                $price = $payment['monthly_rate'];
                if ($payment['payment_cycle'] == 1) {
                    $day = 'On Approval';
                    $pay_now = $payment['total_amount'];
                }
            }

            array_push($scheduled_payments, [
                'day' => $day,
                'price' => $price,
            ]);
        }

        $remaining_days_amount = 0;
        $day_count_label = $months . ' month' . ($months > 1 ? 's' : '');

        if (isset($partialDayDetails)) {
            $remaining_days = $partialDayDetails['is_partial_days'];
            $remaining_days_amount = $partialDayDetails['total_amount'];
            $day_count_label = $day_count_label . ', ' . $remaining_days . ' day' . ($remaining_days > 1 ? 's' : '');
        }

        $neat_amount = round($months * $booking->monthly_rate + $remaining_days_amount);

        return [
            'count_label' => $day_count_label,
            'neat_amount' => $neat_amount,
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

    public static function generate_booking_payments($booking)
    {
        $start_date = Carbon::parse($booking->start_date);
        $end_date = Carbon::parse($booking->end_date);
        $accepted_date = Carbon::now();
        $scheduler_date = Carbon::parse($booking->start_date);
        // Getting total days
        $diffInDays = $start_date->diffInDays($end_date);
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
            ];
            if ($i == 1) {
                $data['service_tax'] = SERVICE_TAX;
                $data['total_amount'] = round(
                    $data['monthly_rate'] + $data['cleaning_fee'] + $data['security_deposit'],
                );
                $data['due_date'] = $accepted_date;
            } else {
                $data['total_amount'] = round($data['monthly_rate']);
                $scheduler_date->addMonth();
                $data['due_date'] = $scheduler_date;
            }
            if ($i == $totalCycles && $isPartial) {
                $data['total_amount'] = round($data['monthly_rate'] / $partialDays);
                $data['is_partial_days'] = $partialDays;
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
