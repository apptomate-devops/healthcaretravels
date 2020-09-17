<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\ProcessEmail;

class SendEmailController extends BaseController
{
    //
    public function createJobForEmail()
    {
        ProcessEmail::dispatch()->delay(now()->addMinutes(10));
        ProcessEmail::dispatch()->delay(now()->addMinutes(10));
        ProcessEmail::dispatch()->delay(now()->addMinutes(10));
    }
}
