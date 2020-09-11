<?php

namespace App\Helper;

class Helper
{
    public static function get_daily_price($monthy_price)
    {
        return $monthy_price ? number_format($monthy_price / 30, 2) : 0;
    }
}
