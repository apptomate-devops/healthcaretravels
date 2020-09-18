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
        ];
        $data2 = [
            'name' => '007htrap',
            'travelerName' => 'helloworld',
            'propertyName' => 'foo',
        ];
        ProcessEmail::dispatch(
            "pvakharia007@gmail.com",
            "mail.owner-24hr-before-checkin",
            "First subject",
            $data1,
            APP_BASE_NAME,
        )->delay(now());
        // ProcessEmail::dispatch("007pvakharia@gmail.com", "mail.owner-24hr-before-checkin", "Second subject", $data2,APP_BASE_NAME)->delay(now());
        // ProcessEmail::dispatch()->delay(now());
        // ProcessEmail::dispatch()->delay(now()->addMinutes(10));
    }
}
