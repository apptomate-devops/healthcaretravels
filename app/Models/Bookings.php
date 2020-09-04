<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bookings extends Model
{
    protected $table = 'property_booking';

    protected $fillable = ['client_id', 'traveller_id', 'owner_id', 'property_id', 'start_date', 'end_date'];
}
