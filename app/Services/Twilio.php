<?php

namespace App\Services;
use App\Services\Logger;
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

    public function isValidNumber($phone)
    {
        try {
            $res = $this->client->lookups->v1->phoneNumbers($phone)->fetch();
            return $res;
        } catch (\Exception $ex) {
            Logger::error('Error validating phone number. EX: ' . $ex->getMessage());
            return false;
        }
    }

    /** sendMessage - Sends message to the specified number.
     * @param Number $number string phone number of recipient
     * @param String $body Body/Message of sms
     */
    public function sendMessage($number, $body)
    {
        $isValid = $this->isValidNumber($number);
        if ($isValid) {
            try {
                $message = $this->client->messages->create($number, [
                    'body' => $body,
                    'messagingServiceSid' => $this->messagingServiceSid,
                ]);
                Logger::info('message has been sent');
                return $message;
            } catch (\Exception $ex) {
                Logger::error('Error sending message to phone number. EX: ' . $ex->getMessage());
                return false;
            }
        }
        return false;
    }
}
