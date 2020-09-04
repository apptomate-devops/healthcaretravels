<?php

namespace App\Services;
use App\Services\Logger;

use GuzzleHttp;

class Sendgrid
{
    protected $api_key;

    protected $list_id;

    protected $client;

    /**
     * Create a new instance
     *
     * @return void
     */

    public function __construct()
    {
        $this->api_key = config('services.sendgrid.api_key');

        $this->list_id = config('services.sendgrid.list_id');

        $this->client = $this->setUp();
    }

    public function setUp()
    {
        $client = new GuzzleHttp\Client(['base_uri' => 'https://api.sendgrid.com/v3/']);
        return $client;
    }

    public function makeRequest(string $method, string $path, $body)
    {
        $options = [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->api_key,
                'Content-Type' => 'application/json',
            ],
        ];
        if (isset($body)) {
            $options['json'] = $body;
        }
        $res = $this->client->request($method, $path, $options);
        return $res;
    }

    public function addUserToMarketingList($user)
    {
        return $this->addUsersToLists((object) $user, $this->list_id);
    }

    public function addUsersToLists($users, $lists)
    {
        try {
            $body = [
                'list_ids' => is_array($lists) ? $lists : [$lists],
                'contacts' => is_array($users) ? $users : [$users],
            ];
            $res = $this->makeRequest('PUT', 'marketing/contacts', $body);
            $code = $res->getStatusCode();
            $resBody = $res->getBody();
            if ($code >= 400) {
                Logger::info('Error Response body: ' . $resBody);
                return false;
            }
            Logger::info('User has been added to marketing list');
            return $res;
        } catch (\Exception $ex) {
            Logger::error('Error adding user to sendgrid list: EX: ' . $ex->getMessage());
            return false;
        }
    }
}
