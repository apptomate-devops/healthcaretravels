<?php

namespace App\Services;
use App\Services\Logger;

class Twilio
{
    protected $access_token;

    protected $client;

    protected $customersApi;

    /**
     * Create a new instance
     *
     * @return void
     */

    public function __construct()
    {
        $this->client = $this->setUp();
    }

    public function setUp()
    {
        $this->access_token = config('services.dwolla.access_token');
        \DwollaSwagger\Configuration::$access_token = $this->access_token;
        $url = config('services.dwolla.env') == 'prod' ? 'https://api.dwolla.com/' : 'https://api-sandbox.dwolla.com/';
        $client = new \DwollaSwagger\ApiClient($url);
        $this->customersApi = new DwollaSwagger\CustomersApi($apiClient);
        return $client;
    }

    public function createNewCustomer($user)
    {
        return $customersApi->create($user);
    }
}
