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
        $single_day_fare = Helper::get_daily_price($property_details->monthly_rate);
        $total_days = $end->diffInDays($current);
        $price = $total_days * $single_day_fare;
        $service_tax_row = DB::table('settings')
            ->where('param', 'service_tax')
            ->first();
        $service_tax = $service_tax_row->value;
        $cleaning_fee = $property_details->cleaning_fee;
        $security_deposit = $property_details->security_deposit;
        $total_price = $price + $cleaning_fee + $security_deposit + $service_tax;
        $pay_now = $property_details->monthly_rate + $cleaning_fee + $security_deposit + $service_tax;
        $day_count = Helper::get_months_and_days($current, $end);
        $booking_price = [
            'client_id' => CLIENT_ID,
            'single_day_fare' => $single_day_fare,
            'total_days' => $total_days,
            'service_tax' => $service_tax,
            'initial_pay' => 0, // TODO: check this later $due_now
            'total_amount' => $total_price,
            'check_in' => $check_in,
            'check_out' => $check_out,
            'cleaning_fee' => $cleaning_fee,
            'security_deposit' => $security_deposit,
            'pay_now' => $pay_now,
            'sub_total' => $total_price,
            'price' => $price,
            'day_count' => $day_count,
        ];
        return $booking_price;
    }

    public static function get_months_and_days($start, $end)
    {
        $start_date = Carbon::parse($start);
        $end_date = Carbon::parse($end);

        // Finding Partial month days
        $lastMonthRenew = Carbon::parse($end);
        if ($lastMonthRenew->day < $start_date->day) {
            $lastMonthRenew->subMonth();
        }
        $lastMonthRenew->day = $start_date->day;
        $partialDays = $end_date->diffInDays($lastMonthRenew);
        $totalMonths = $start_date->diffInMonths($end_date);
        return [
            'months' => $totalMonths,
            'days' => $partialDays,
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
