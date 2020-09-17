<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingPayments extends Model
{
    protected $table = 'booking_payments';
    protected $primaryKey = 'id';

    /**
     * Get the Booking that owns the payments.
     */
    public function booking()
    {
        return $this->belongsTo('App\Models\PropertyBooking', 'booking_id', 'booking_id');
    }
}
