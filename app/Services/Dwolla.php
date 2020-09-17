<?php

namespace App\Services;
use App\Services\Logger;
use Carbon\Carbon;
use Request;
use GuzzleHttp;
use DwollaSwagger;
use App\Models\Users;
use Helper;

class Dwolla
{
    protected $access_token;

    protected $master_account;

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
        $this->access_key = config('services.dwolla.access_key');
        $this->secret_key = config('services.dwolla.secret_key');
        $this->master_account = config('services.dwolla.master_account');
        $this->master_account = config('services.dwolla.master_account');
        $this->master_funding_source = config('services.dwolla.master_funding_source');
        $this->access_token = env('DWOLLA_ACCESS_TOKEN');
        $this->setUp();
    }

    public function setUp($forceNewAccessToken = false)
    {
        $url = config('services.dwolla.env') == 'prod' ? 'https://api.dwolla.com/' : 'https://api-sandbox.dwolla.com/';
        if (!$this->access_token) {
            $accessToken = $this->setupAccessToken($url);
            if (!$accessToken) {
                Logger::error('Error in getting new access token from Dwolla');
                return false;
            }
            $this->access_token = $accessToken;
        }
        DwollaSwagger\Configuration::$access_token = $this->access_token;
        $this->client = new DwollaSwagger\ApiClient($url);
        $this->customersApi = new DwollaSwagger\CustomersApi($this->client);
        $this->rootApi = new DwollaSwagger\RootApi($this->client);
        $this->accountsApi = new DwollaSwagger\AccountsApi($this->client);
        $this->fsApi = new DwollaSwagger\FundingsourcesApi($this->client);
        $this->transfersApi = new DwollaSwagger\TransfersApi($this->client);

        if (!$this->master_account) {
            try {
                Logger::info('AccessToken set in Dwolla:: ' . DwollaSwagger\Configuration::$access_token);
                $this->getMasterAccountDetails();
            } catch (\Exception $ex) {
                dd($ex);
                Logger::error('Error in getting master account details. EX: ' . $ex->getMessage());
                return $ex;
            }
        }
        return $this->client;
    }

    public function getMasterAccountDetails()
    {
        Logger::info('Requesting master account details');
        $rootDetails = $this->rootApi->root();
        $this->master_account = $rootDetails->_links['account']->href;
        $fundingSourcesRes = $this->fsApi->getAccountFundingSources($this->master_account);
        $fundingSources = $fundingSourcesRes->_embedded->{'funding-sources'};
        $balanceFundingSource = current(
            array_filter($fundingSources, function ($e) {
                return $e->type == 'balance' && $e->removed == false;
            }),
        );
        if (!$balanceFundingSource) {
            Logger::error('Error in finding master funding source!!');
        }
        $this->master_funding_source = $balanceFundingSource->_links->self->href;
        $envData = [
            'DWOLLA_MASTER_ACCOUNT' => $this->master_account,
            'DWOLLA_MASTER_ACCOUNT_ID' => basename($this->master_account),
            'DWOLLA_MASTER_FUNDING_SOURCE' => $this->master_funding_source,
        ];
        Helper::changeEnv($envData);
    }

    public function setupAccessToken($url)
    {
        $accessToken = env('DWOLLA_ACCESS_TOKEN');
        if ($accessToken) {
            Logger::info('Found accessToken from Config value:');
            return $accessToken;
        }
        Logger::info('Requesting new accessToken from Dwolla:');
        $guzzleClient = new GuzzleHttp\Client(['base_uri' => $url]);
        $options = [
            'auth' => [$this->access_key, $this->secret_key],
            'form_params' => [
                'grant_type' => 'client_credentials',
            ],
        ];
        $res = $guzzleClient->request('POST', '/token', $options);
        $code = $res->getStatusCode();
        $resBody = json_decode($res->getBody()->getContents(), true);
        if ($code >= 400) {
            Logger::error('Error in getting access token from Dwolla: ' . $resBody);
            return false;
        }
        if ($resBody) {
            $accessToken = $resBody["access_token"];
            Logger::info('Fetched access token from Dwolla: ' . $accessToken);
            DwollaSwagger\Configuration::$access_token = $accessToken;
            $envData = [
                'DWOLLA_ACCESS_TOKEN' => $accessToken,
            ];
            Helper::changeEnv($envData);
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
     * @param $id
     * Check if customer is verified and if not updates the customer to verified
     * @return customer id
     */
    public function verifyCustomer($id, $userPayload)
    {
        $customer_details = $this->customersApi->getCustomer($id);
        if ($customer_details->status == 'unverified') {
            $this->updateCustomer($userPayload, $id);
        }
        return $id;
    }

    public function updateCustomer($user, $id)
    {
        return $this->customersApi->updateCustomer($user, $id);
    }

    public function findCustomerByEmail($email)
    {
        $customer_result = $this->customersApi->_list(null, null, null, null, null, $email);
        if (count($customer_result->_embedded->customers) > 0) {
            return $customer_result->_embedded->customers[0];
        }
        return null;
    }

    /**
     * Creates a Dwolla customer by user id
     */
    public function createCustomerForUser($id, $user = null)
    {
        if (empty($user)) {
            $user = Users::find($id);
            if (empty($user)) {
                Logger::info('Tried to create Dwolla customer for user with missing information: ' . $id);
                return false;
            }
        }
        try {
            $userPayload = $this->getCustomerPayload($user);
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

    public function getCustomerPayload($user, $request_data)
    {
        return [
            'firstName' => $user->first_name,
            'lastName' => $user->last_name,
            'email' => $user->email,
            'dateOfBirth' => $user->date_of_birth,
            'phone' => $user->phone,
            'correlationId' => $user->id,
            'ipAddress' => Request::ip(),
            'type' => 'personal',
            'address1' => $request_data->dwolla_address ?? $user->address,
            'city' => $request_data->dwolla_city ?? $user->city,
            'state' => $request_data->dwolla_state ?? $user->state,
            'postalCode' => $request_data->dwolla_pin_code ?? $user->pin_code,
            'ssn' => $request_data->dwolla_ssn,
        ];
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
            Logger::error('Error in creating funding source token for user: ' . $id . '. EX: ' . $ex->getMessage());
            return $ex;
        }
    }

    public function getFundingSourcesForCustomer($customerId)
    {
        if (!$customerId) {
            return [];
        }
        try {
            $fundingSources = $this->fsApi->getCustomerFundingSources($customerId);
            return $fundingSources->_embedded->{'funding-sources'};
        } catch (\Exception $ex) {
            Logger::error('Error in getFundingSourcesForCustomer ' . $ex->getMessage());
            return [];
        }
    }

    public function createTransferToMasterDwolla($source, $amount, $clearance = 'next-available')
    {
        // Balance account
        // 'href' => 'https://api-sandbox.dwolla.com/funding-sources/180d546c-56c8-47b8-b3e7-6b52e184a72f',

        // Bank account
        // 'href' => 'https://api-sandbox.dwolla.com/funding-sources/d82be601-ed1e-4346-834e-72254fd96d77',

        $payload = [
            '_links' => [
                'source' => [
                    'href' => $source,
                ],
                'destination' => [
                    'href' => $this->master_funding_source,
                ],
            ],
            'amount' => [
                'currency' => 'USD',
                'value' => "20.00",
            ],
            'clearing' => [
                'destination' => $clearance,
            ],
        ];
        try {
            $transfer = $this->transfersApi->create($payload);
            return $transfer;
        } catch (\Throwable $th) {
            var_dump($payload);
            dd($th);
        }
    }
}
