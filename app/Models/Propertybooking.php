<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Propertybooking extends Model
{
    protected $table = 'property_booking';
    protected $primaryKey = 'id';

    protected $fillable = [
        'client_id',
        'traveller_id',
        'owner_id',
        'property_id',
        'booking_id',
        'start_date',
        'end_date',
        'guest_count',
        'child_count',
        'is_instant',
        'payment_done',
        'status',
        'created_at',
        'updated_at',
    ];
}
