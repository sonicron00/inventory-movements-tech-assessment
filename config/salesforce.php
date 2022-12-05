<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Salesforce API Params
    |--------------------------------------------------------------------------
    |
    | Parameters needed for the API request to Salesforce
    |
    */
    'service_request_uri' => env('SF_SERVICE_REQUEST_URI', null),

    /*
    |--------------------------------------------------------------------------
    | Salesforce API Oauth Params
    |--------------------------------------------------------------------------
    |
    | OAuth params for API requests
    |
    */
    'oauth_url' => env('SF_OAUTH_URL', null),
    'client_id' => env('SF_CLIENT_ID', null),
    'client_secret' => env('SF_CLIENT_SECRET', null),
    'username' => env('SF_USERNAME', null),
    'password' => env('SF_PASSWORD', null),
    'token' => env('SF_TOKEN', null),
];
