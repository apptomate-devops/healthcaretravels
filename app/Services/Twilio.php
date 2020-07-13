<?php

namespace App\Services;

use Twilio\Rest\Client;

class Twilio
{
    protected $account_sid;

    protected $auth_token;

    protected $messagingServiceSid;

    protected $client;

    /**
     * Create a new instance
     *
     * @return void
     */

    public function __construct()
    {
        $this->account_sid = config('services.twilio.account_sid');

        $this->auth_token = config('services.twilio.auth_token');

        $this->messagingServiceSid = config('services.twilio.messaging_service_sid');

        $this->client = $this->setUp();
    }

    public function setUp()
    {
        $client = new Client($this->account_sid, $this->auth_token);
        return $client;
    }

    /** sendMessage - Sends message to the specified number.
     * @param Number $number string phone number of recipient
     * @param String $body Body/Message of sms
     */
    public function sendMessage($number, $body)
    {
        $message = $this->client->messages->create($number, [
            'body' => $body,
            'messagingServiceSid' => $this->messagingServiceSid,
        ]);
        return $message;
    }
}
