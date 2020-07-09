<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Propertyimage extends Model
{
    protected $table = 'property_images';
    protected $primaryKey = 'id';

    protected $fillable = ['client_id', 'property_id', 'image_url', 'sort', 'status', 'created_at', 'updated_at'];
}
