<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyBooking extends Model
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
        'name_of_agency',
        'other_agency',
        'funding_source',
        'owner_funding_source',
        'admin_remarks',
        'owner_remarks',
        'traveler_remarks',
        'is_deposit_handled',
        'is_deposit_handled_by_admin',
        'should_auto_deposit',
        'owner_cut',
        'traveler_cut',
        'deposit_handled_at',
        'owner_deposit_processed_at',
        'owner_deposit_confirmed_at',
        'owner_deposit_failed_at',
        'owner_deposit_failed_reason',
        'owner_deposit_transfer_id',
        'traveler_deposit_processed_at',
        'traveler_deposit_confirmed_at',
        'traveler_deposit_failed_at',
        'traveler_deposit_failed_reason',
        'traveler_deposit_transfer_id',
        'traveler_cut',
        'monthly_rate',
        'security_deposit',
        'cleaning_fee',
        'cancellation_requested',
        'already_checked_in',
        'cancellation_reason',
        'cancellation_explanation',
        'cancelled_by',
        'cancellation_refund_amount',
        'cancellation_refund_processed_at',
        'cancellation_refund_confirmed_at',
        'cancellation_refund_failed_at',
        'cancellation_refund_failed_reason',
        'cancellation_refund_transfer_id',
        'cancellation_refund_status',
    ];
    /**
     * Get the Traveler who made the booking.
     */
    public function traveler()
    {
        return $this->belongsTo('App\Models\Users', 'traveller_id', 'id');
    }

    /**
     * Get the Owner of the booking property
     */
    public function owner()
    {
        return $this->belongsTo('App\Models\Users', 'owner_id', 'id');
    }

    /**
     * Get the Property who owns this property booking.
     */
    public function property()
    {
        return $this->belongsTo('App\Models\PropertyList', 'property_id', 'id');
    }

    /**
     * Get the Payments made/due for this property booking.
     */
    public function payments()
    {
        return $this->hasMany('App\Models\BookingPayments', 'booking_id', 'booking_id');
    }

    /**
     * Get the Booking for which dwolla webhook responded.
     */
    public static function findByResourceId($id)
    {
        return PropertyBooking::where('owner_deposit_transfer_id', $id)
            ->orWhere('traveler_deposit_transfer_id', $id)
            ->orWhere('cancellation_refund_transfer_id', $id)
            ->first();
    }

    /**
     * Get active Booking for users.
     */
    public static function getActiveBookingForUser($id)
    {
        return PropertyBooking::where(function ($query) use ($id) {
            return $query->where('traveller_id', $id)->orWhere('owner_id', $id);
        })
            ->whereDate('start_date', '<=', date("Y-m-d"))
            ->whereDate('end_date', '>=', date("Y-m-d"))
            ->get();
    }
}
