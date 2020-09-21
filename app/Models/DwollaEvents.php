<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DwollaEvents extends Model
{
    protected $table = 'dwolla_events';
    protected $primaryKey = 'id';
    protected $fillable = [
        'dwolla_id',
        'resource_id',
        'topic',
        'links',
        'proposed_signature',
        'generated_signature',
        'timestamp',
        'dwolla_created',
        'is_used',
        'is_valid_request',
    ];

    /**
     * Get the Payment that owns this event.
     */
    public function payment()
    {
        return $this->belongsTo('App\Models\BookingPayments', 'resource_id', 'transfer_id');
    }
}
