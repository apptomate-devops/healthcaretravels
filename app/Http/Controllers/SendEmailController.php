<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessEmail;

class SendEmailController extends BaseController
{
    //
    public function createJobForEmail()
    {
        $data1 = [
            'name' => 'htrap007',
            'travelerName' => 'helloworld',
            'propertyName' => 'foo',
            'BASE_URL' => BASE_URL,
            'APP_BASE_NAME' => APP_BASE_NAME,
        ];
        ProcessEmail::dispatch("test@gmail.com", "mail.owner-24hr-before-checkin", "First subject", $data1)->delay(
            now()->addSeconds(30),
        );
    }
}
