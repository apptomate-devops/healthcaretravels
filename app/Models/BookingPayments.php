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
        'due_time',
        'is_owner',
        'transfer_url',
        'transfer_id',
        'job_id',
        'is_cleared',
        'is_partial_days',
        'covering_range',
        'status',
        'failed_count',
    ];
    /**
     * Get the Booking that owns the payments.
     */
    public function booking()
    {
        return $this->belongsTo('App\Models\PropertyBooking', 'booking_id', 'booking_id');
    }

    public static function getByTransactionId($transaction)
    {
        return BookingPayments::where('transfer_id', $transaction)->first();
    }
}
