<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */
    'facebook' => [
        'client_id' => '591256144826957',
        'client_secret' => '7310c01d8a87221ebc1298cffa7798b6',
        'redirect' => 'https://www.sieuthianhduong.com/auth/facebook/callback',
    ],

    'google' => [
        'client_id' => '858235949728-slskdebma600h9b6p9lut4vci07n4qpn.apps.googleusercontent.com',
        'client_secret' => 'c8aNE_man-N7KCu_VynTUAQP',
        'redirect' => 'https://www.sieuthianhduong.com/auth/google/callback',
    ],
    
    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'stripe' => [
        'key' =>'pk_test_51IDnyhIDnoq3xZ5FYP4vgeC6fjKFv8NVI1BEcWnVfYDEtgJ0tYLveJYXD1VeDwkX3AmcqsByeUyi7gzpEQVzA7q600GBtTXQtw',
        'secret'=>'sk_test_51IDnyhIDnoq3xZ5Fw9svfKfwNIozcpaFmHd76bIHRUcmX3GswoCQxr7j0B7lctQPseNIuOgqFagsNm90nQ75PScs00hWrOPEwc',
    ],
    'usps' => [
        'username' => "316AMERI6873",
        'testmode' => false,
    ],
];
