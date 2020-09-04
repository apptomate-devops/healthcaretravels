<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */
    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'redirect' => env('SOCIAL_REDIRECT'),
    ],

    'google' => [
        'captcha_site_key' => env('RECAPTCHA_SITE_KEY', '6LcdUVMUAAAAAHf1NDwJ5VG7s3AemNQbXuMHZBsR'),
        'captcha_secret_key' => env('RECAPTCHA_SECRET_KEY', '6LcdUVMUAAAAABjB_DldChticg66WclweVoUsjHU'),
        'maps_api_key' => env('GOOGLE_MAPS_API_KEY', 'AIzaSyBZHka56h_B3dLKxn-awZJO7HTqzcuvcy0'),
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('SOCIAL_REDIRECT'),
    ],

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\Models\Users::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'twilio' => [
        'account_sid' => env('TWILIO_ACCOUNT_SID'),
        'auth_token' => env('TWILIO_AUTH_TOKEN'),
        'messaging_service_sid' => env('TWILIO_MESSAGING_SERVICE_SID'),
    ],

    'sendgrid' => [
        'api_key' => env('SENDGRID_API_KEY'),
        'list_id' => env('SENDGRID_LIST_ID'),
    ],
];
