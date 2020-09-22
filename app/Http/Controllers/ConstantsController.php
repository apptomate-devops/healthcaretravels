<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Helper;

Helper::reloadEnv();
Helper::set_settings_constants();

class ConstantsController extends Controller
{
    public function generate_hash($value)
    {
        return hash_hmac("ripemd160", "sparkout", $value);
    }

    public function get_percentage($percentage, $value)
    {
        return $percentage_amount = ($percentage / 100) * $value;
    }
}
