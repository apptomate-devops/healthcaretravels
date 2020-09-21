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
}
