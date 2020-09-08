<?php

namespace App\Services;
use Request;
use App\Services\Logger;
use App\Models\Users;

class Dwolla
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
        $this->customersApi = new \DwollaSwagger\CustomersApi($client);
        return $client;
    }

    public function createNewCustomer($user)
    {
        return $this->customersApi->create($user);
    }

    /**
     * Creates a Dwolla customer by user id
     */
    public function createCustomerForUser($id)
    {
        $user = Users::find($id);
        if (empty($user)) {
            return false;
        }
        try {
            $userPayload = [
                'firstName' => $user->first_name,
                'lastName' => $user->last_name,
                'email' => $user->email,
                'ipAddress' => Request::ip(),
                'correlationId' => $user->id,
            ];
            Logger::info('Creating Dwolla customer for user: ' . $id);
            $res = $this->createNewCustomer($userPayload);
            $user->dwolla_customer = $res;
            $user->save();
            return $res;
        } catch (\Exception $ex) {
            Logger::error('Error in creating new customer for user: ' . $id . ' . EX: ' . $ex->getResponseBody());
            return $ex;
        }
    }
}
