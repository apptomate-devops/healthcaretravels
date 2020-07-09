<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailConfig extends Model
{
    protected $table = 'email_config';
    protected $primaryKey = 'id';
    protected $fillable = ['subject', 'title', 'message', 'type', 'created_at', 'updated_at'];
}
