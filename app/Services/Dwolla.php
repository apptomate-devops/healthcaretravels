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
        $this->master_funding_source = config('services.dwolla.master_funding_source');
        $this->access_token = config('services.dwolla.access_token');
        $this->webhook_secret = config('services.dwolla.webhook_secret');
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
        $accessToken = config('services.dwolla.access_token');
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
            Logger::info('Dwolla customer created for user: ' . $res);
            $user->dwolla_customer = $res;
            $user->save();
            return $res;
        } catch (\Exception $ex) {
            Logger::error('Error in creating new customer for user: ' . $id . '. EX: ' . $ex->getResponseBody());
            return $ex;
        }
    }

    public function getFundingSourceDetails($fundingSourceUrl)
    {
        try {
            return $fundingSource = $this->fsApi->id($fundingSourceUrl);
        } catch (\Exception $ex) {
            Logger::error('Error in getFundingSourceDetails: ' . $fundingSourceUrl . '. EX: ' . $ex->getResponseBody());
            return false;
        }
    }

    public function getCustomerPayload($user)
    {
        return [
            'firstName' => $user->first_name,
            'lastName' => $user->last_name,
            'email' => $user->email,
            'correlationId' => $user->id,
            'ipAddress' => Request::ip(),
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

    public function getIAVToken($customerId)
    {
        if (empty($customerId)) {
            Logger::info('Tried to create Dwolla IAV token for user with missing information: ' . $customerId);
            return false;
        }
        try {
            Logger::info('Creating Dwolla IAV token for user: ' . $customerId);
            $IAVToken = $this->customersApi->getCustomerIavToken($customerId);
            Logger::info('Dwolla IAV created for user: ' . json_encode($IAVToken));
            return $IAVToken;
        } catch (\Exception $ex) {
            Logger::error('Error in creating IAV token for user: ' . $customerId . '. EX: ' . $ex->getMessage());
            return $ex;
        }
    }

    public function getFundingSourcesForCustomer($customerId)
    {
        if (!$customerId) {
            return [];
        }
        try {
            $all_funding_sources = $this->fsApi->getCustomerFundingSources($customerId);
            $funding_sources = $all_funding_sources->_embedded->{'funding-sources'};
            return array_filter($funding_sources, function ($source) {
                if ($source->status == 'verified' && $source->type != 'balance' && $source->removed == false) {
                    return true;
                }
            });
        } catch (\Exception $ex) {
            Logger::error('Error in getFundingSourcesForCustomer ' . $ex->getMessage());
            return [];
        }
    }

    public function createTransferToMasterDwolla($source, $amount, $idempotency, $clearance = 'next-available')
    {
        // Master Balance account
        // 'href' => 'https://api-sandbox.dwolla.com/funding-sources/180d546c-56c8-47b8-b3e7-6b52e184a72f',

        // Master Bank account
        // 'href' => 'https://api-sandbox.dwolla.com/funding-sources/d82be601-ed1e-4346-834e-72254fd96d77',

        // Customer bank account
        // 'href' => 'https://api-sandbox.dwolla.com/funding-sources/31a091a3-f731-4203-9ff6-7c7dd045634a',
        // "https://api-sandbox.dwolla.com/funding-sources/914d31a8-458a-4d13-bd94-39aab09cb7a0"
        if (empty($source)) {
            throw new \Exception('Invalid source value');
        }
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
                'value' => $amount,
            ],
            'clearing' => [
                'destination' => $clearance,
            ],
        ];
        try {
            $transfer = $this->transfersApi->create($payload, $idempotency);
            return $transfer;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function createTransferToCustomer($destination, $amount, $idempotency, $clearance = 'next-available')
    {
        if (empty($destination)) {
            throw new \Exception('Invalid source value');
        }
        $payload = [
            '_links' => [
                'source' => [
                    'href' => $this->master_funding_source,
                ],
                'destination' => [
                    'href' => $destination,
                ],
            ],
            'amount' => [
                'currency' => 'USD',
                'value' => $amount,
            ],
            'clearing' => [
                'destination' => $clearance,
            ],
        ];
        try {
            $transfer = $this->transfersApi->create($payload, $idempotency);
            return $transfer;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function verify_gateway_signature($proposedSignature, $payloadBody)
    {
        $signature = hash_hmac('sha256', $payloadBody, $this->webhook_secret);
        Logger::info('GeneratedSignature: ' . $signature);
        return ['generated_signature' => $signature, 'is_valid' => $signature == $proposedSignature];
    }
}
