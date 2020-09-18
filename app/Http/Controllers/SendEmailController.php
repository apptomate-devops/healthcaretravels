<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Jobs\ProcessEmail;

class SendEmailController extends BaseController
{
    //
    public function createJobForEmail()
    {
        error_log('email added');
        $data1 = [
            'name' => 'htrap007',
            'travelerName' => 'helloworld',
            'propertyName' => 'foo',
            'BASE_URL' => BASE_URL,
            'APP_BASE_NAME' => APP_BASE_NAME,
        ];
        $data2 = [
            'name' => 'htrap007',
            'travelerName' => 'helloworld',
            'propertyName' => 'foo',
        ];
        ProcessEmail::dispatch("test@gmail.com", "mail.owner-24hr-before-checkin", "First subject", $data1)->delay(
            now()->addMinutes(0.5),
        );
        // ProcessEmail::dispatch("007pvakharia@gmail.com", "mail.owner-24hr-before-checkin", "Second subject", $data2,APP_BASE_NAME)->delay(now());
        // ProcessEmail::dispatch()->delay(now());
        // ProcessEmail::dispatch()->delay(now()->addMinutes(10));
    }
}
