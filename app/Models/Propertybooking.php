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
    ];
    /**
     * Get the Traveler who made the booking.
     */
    public function traveler()
    {
        return $this->belongsTo('App\Models\Users', 'traveller_id', 'id');
    }
}
