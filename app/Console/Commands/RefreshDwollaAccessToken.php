<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp;
use DwollaSwagger;
use App\Services\Logger;
use App\Helper\Helper;

class RefreshDwollaAccessToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dwolla:refresh_access_token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refreshes dwolla access token';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function setupAccessToken()
    {
        $url = config('services.dwolla.env') == 'prod' ? 'https://api.dwolla.com/' : 'https://api-sandbox.dwolla.com/';
        $access_token = config('services.dwolla.access_key');
        $secret_key = config('services.dwolla.secret_key');
        $guzzleClient = new GuzzleHttp\Client(['base_uri' => $url]);
        $options = [
            'auth' => [$access_token, $secret_key],
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
            return $accessToken;
        }
        return false;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Logger::info('Requesting new accessToken from Refresh access token command:');
        $accessToken = $this->setupAccessToken();
        if (!$accessToken) {
            Logger::error('Error in getting new access token from Dwolla');
            return false;
        }
        $envData = [
            'DWOLLA_ACCESS_TOKEN' => $accessToken,
        ];
        DwollaSwagger\Configuration::$access_token = $accessToken;
        Helper::changeEnv($envData);
    }
}
