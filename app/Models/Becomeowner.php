<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Becomeowner extends Model
{
    protected $table = 'become_owner';
    protected $primaryKey = 'id';

    protected $fillable = [
        'client_id',
        'user_id',
        'location',
        'type',
        'guests',
        'status',
        'rep_code',
        'account_name',
        'account_number',
        'bank_name',
        'created_at',
        'updated_at',
    ];
}
