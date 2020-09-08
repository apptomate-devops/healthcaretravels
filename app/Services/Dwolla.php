<?php

namespace App\Services;
use Request;
use GuzzleHttp;
use DwollaSwagger;
use App\Services\Logger;
use App\Models\Users;

class Dwolla
{
    protected $access_token;

    protected $master_funding_source;

    protected $client;

    protected $customersApi;

    /**
     * Create a new instance
     *
     * @return void
     */

    public function __construct()
    {
        $this->access_token = config('services.dwolla.access_key');
        $this->secret_key = config('services.dwolla.secret_key');
        $this->master_funding_source = config('services.dwolla.master_funding_source');
        $this->setUp();
    }

    public function setUp($forceNewAccessToken = false)
    {
        $url = config('services.dwolla.env') == 'prod' ? 'https://api.dwolla.com/' : 'https://api-sandbox.dwolla.com/';
        $accessToken = config('services.dwolla.access_token');
        Logger::info('accessToken from config value: ' . $accessToken);
        Logger::info('Is force new access token? : ' . $forceNewAccessToken);
        if ($forceNewAccessToken || !$accessToken) {
            Logger::info('Requesting new accessToken from Dwolla:');
            $accessToken = $this->setupAccessToken($url, $forceNewAccessToken);
        }
        if (!$accessToken) {
            Logger::error('Error in getting new access token from Dwolla');
            return false;
        }
        $this->client = new DwollaSwagger\ApiClient($url);
        $this->customersApi = new DwollaSwagger\CustomersApi($this->client);
        return $this->client;
    }

    public function setupAccessToken($url)
    {
        $guzzleClient = new GuzzleHttp\Client(['base_uri' => $url]);
        $options = [
            'auth' => [$this->access_token, $this->secret_key],
            'form_params' => [
                'grant_type' => 'client_credentials',
            ],
        ];
        $res = $guzzleClient->request('POST', '/token', $options);
        $code = $res->getStatusCode();
        if ($code >= 400) {
            Logger::error('Error in getting access token from Dwolla: ' . $resBody);
            return false;
        }
        $resBody = json_decode($res->getBody()->getContents(), true);
        if ($resBody) {
            $accessToken = $resBody["access_token"];
            Logger::info('Fetched access token from Dwolla: ' . $accessToken);
            DwollaSwagger\Configuration::$access_token = $accessToken;
            config(['services.dwolla.access_token' => $accessToken]);
            Logger::info('After setting Config Value: ' . config('services.dwolla.access_token'));
            return $accessToken;
        }
        return false;
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
            Logger::info('Tried to create Dwolla customer for user with missing information: ' . $id);
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
            Logger::info('Dwolla customer created for user: ' . $id);
            return $res;
        } catch (\Exception $ex) {
            Logger::error('Error in creating new customer for user: ' . $id . '. EX: ' . $ex->getResponseBody());
            return $ex;
        }
    }

    public function getFundingSourceToken($id)
    {
        $user = Users::find($id);
        if (empty($user) || (isset($user) && empty($user->dwolla_customer))) {
            Logger::info('Tried to create Dwolla funding source token for user with missing information: ' . $id);
            return false;
        }
        try {
            Logger::info('Creating Dwolla funding source token for user: ' . $id);
            $fsToken = $this->customersApi->createFundingSourcesTokenForCustomer($user->dwolla_customer);
            Logger::info('Dwolla funding source created for user: ' . $id);
            return $fsToken;
        } catch (\Exception $ex) {
            Logger::error(
                'Error in creating funding source token for user: ' . $id . '. EX: ' . $ex->getResponseBody(),
            );
            return $ex;
        }
    }
}
