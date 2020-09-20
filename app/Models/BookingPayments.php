<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingPayments extends Model
{
    protected $table = 'booking_payments';
    protected $primaryKey = 'id';
    protected $fillable = [
        'payment_cycle',
        'service_tax',
        'partial_days',
        'booking_row_id',
        'booking_id',
        'cleaning_fee',
        'security_deposit',
        'monthly_rate',
        'total_amount',
        'due_date',
        'is_owner',
        'transfer_url',
        'job_id',
        'is_cleared',
    ];
    /**
     * Get the Booking that owns the payments.
     */
    public function booking()
    {
        return $this->belongsTo('App\Models\PropertyBooking', 'booking_id', 'booking_id');
    }

    public function scopeGetByTransactionId($query, $transaction)
    {
        return $query->where('transfer_id', $transaction)->get();
    }
}
