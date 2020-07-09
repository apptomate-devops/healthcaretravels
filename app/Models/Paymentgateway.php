<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paymentgateway extends Model
{
    protected $table = 'payment_gateway';
    protected $primaryKey = 'id';

    protected $fillable = [
        'gateway_name',
        'merchant_name',
        'merchant_code',
        'merchant_key',
        'status',
        'created_at',
        'updated_at',
    ];
}
