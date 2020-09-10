<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PetInformation extends Model
{
    protected $table = 'pet_information';
    protected $fillable = ['booking_id'];
}
