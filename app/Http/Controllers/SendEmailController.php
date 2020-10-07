<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessEmail;

class SendEmailController extends BaseController
{
    //
    public function createJobForEmail()
    {
        error_log('sending email');
        $data1 = [
            'name' => 'htrap007',
            'travelerName' => 'helloworld',
            'propertyName' => 'foo',
            'BASE_URL' => BASE_URL,
            'APP_BASE_NAME' => APP_BASE_NAME,
            'travelerPhone' => '9898989898',
            'contact' => 'http://127.0.0.1:8000/owner/chat/6?fb-key=personal_chat&fbkey=personal_chat',
        ];

        ProcessEmail::dispatch("pvakharia007@gmail.com", "mail.owner-24hr-before-checkout", "First subject", $data1)
            ->delay(now()->addSeconds(1))
            ->onQueue(EMAIL_QUEUE);
    }
}
