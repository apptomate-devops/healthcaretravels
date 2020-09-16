<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyList extends Model
{
    protected $table = 'property_list';

    /**
     * Get the bookings for the property listing.
     */
    public function bookings()
    {
        return $this->hasMany('App\Models\PropertyBooking', 'property_id');
    }

    /**
     * Get the blockings for the property listing.
     */
    public function blockings()
    {
        return $this->hasMany('App\Models\PropertyBlocking', 'property_id');
    }
}
