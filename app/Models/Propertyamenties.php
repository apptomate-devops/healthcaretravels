<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Propertyamenties extends Model
{
    protected $table = 'property_amenties';
    protected $primaryKey = 'id';

    protected $fillable = [
        'client_id',
        'property_id',
        'amenties_name',
        'amenties_icon',
        'amenties_flag',
        'sort',
        'status',
        'created_at',
        'updated_at',
    ];
}
