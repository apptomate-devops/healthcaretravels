<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Couponecode extends Model
{
    protected $table = 'coupon_code';
    protected $primaryKey = 'id';

    protected $fillable = [
        'coupon_name',
        'coupon_code',
        'max_no_users',
        'coupon_valid_from',
        'coupon_valid_to',
        'coupon_type',
        'price_value',
        'description',
        'status',
        'created_at',
        'updated_at',
    ];
}
