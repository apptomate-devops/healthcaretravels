<?php

namespace App\Services;
use App\Services\Logger;

use GuzzleHttp;

class Sendgrid
{
    protected $api_key;
    protected $list_id;
    protected $no_contact_list_id;
    protected $client;
    protected $contact_list_traveler;
    protected $contact_list_owner;
    protected $contact_list_agency;
    protected $contact_list_rv_traveler;
    protected $contact_list_co_host;

    /**
     * Create a new instance
     *
     * @return void
     */

    public function __construct()
    {
        $this->api_key = config('services.sendgrid.api_key');
        $this->list_id = config('services.sendgrid.list_id');
        $this->no_contact_list_id = config('services.sendgrid.no_contact_list_id');
        $this->contact_list_traveler = config('services.sendgrid.contact_list_traveler');
        $this->contact_list_rv_traveler = config('services.sendgrid.contact_list_rv_traveler');
        $this->contact_list_owner = config('services.sendgrid.contact_list_owner');
        $this->contact_list_agency = config('services.sendgrid.contact_list_agency');
        $this->contact_list_co_host = config('services.sendgrid.contact_list_co_host');
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

    public function get_sendgrid_list_id($type)
    {
        switch ($type) {
            case "0":
                // Traveler
                return $this->contact_list_traveler;
            case "1":
                // Owner
                return $this->contact_list_owner;
            case "2":
                // Agency
                return $this->contact_list_agency;
            case "3":
                // RV Traveler
                return $this->contact_list_rv_traveler;
            case "4":
                // CO-HOST
                return $this->contact_list_co_host;
            default:
                return '';
        }
    }

    public function addUserToMarketingList($user, $type)
    {
        $list_id = $this->get_sendgrid_list_id($type);
        return $this->addUsersToLists((object) $user, $list_id);
    }

    public function addUserToNoContactList($user)
    {
        return $this->addUsersToLists((object) $user, $this->no_contact_list_id);
    }

    public function addUsersToLists($users, $lists)
    {
        try {
            $list_ids = is_array($lists) ? $lists : [$lists];
            $body = [
                'list_ids' => $list_ids,
                'contacts' => is_array($users) ? $users : [$users],
            ];
            $res = $this->makeRequest('PUT', 'marketing/contacts', $body);
            $code = $res->getStatusCode();
            $resBody = $res->getBody();
            if ($code >= 400) {
                Logger::info('Error Response body: ' . $resBody);
                return false;
            }
            Logger::info('User has been added to list: ' . join(" ", $list_ids));
            return $res;
        } catch (\Exception $ex) {
            Logger::error('Error adding user to sendgrid list: EX: ' . $ex->getMessage());
            return false;
        }
    }
}
