<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Net Suite API Params
    |--------------------------------------------------------------------------
    |
    | Parameters needed for the API request to NetSuite.
    |
    */
    'netsuite-host' => env('NETSUITE_API_HOST', 'https://5310757-sb1.restlets.api.netsuite.com'),
    'netsuite-endpoint' => env('NETSUITE_API_ENDPOINT', '/app/site/hosting/restlet.nl?deploy=1&script='),

    /*
    |--------------------------------------------------------------------------
    | Net Suite API Oauth Params
    |--------------------------------------------------------------------------
    |
    | OAuth params for API requests
    |
    */
    'netsuite-consumer-key' => env('NETSUITE_API_CONSUMER_KEY', null),
    'netsuite-consumer-secret' => env('NETSUITE_API_CONSUMER_SECRET', null),
    'netsuite-token' => env('NETSUITE_API_TOKEN', null),
    'netsuite-token-secret' => env('NETSUITE_API_TOKEN_SECRET', null),
    'netsuite-realm' => env('NETSUITE_API_REALM', null),

    /*
    |--------------------------------------------------------------------------
    | Net Suite API Script Types
    |--------------------------------------------------------------------------
    |
    | Script IDs for the different types of requests, this can be found within
    | NetSuite.
    |
    */
    'ftth_services' => env('NETSUITE_FTTH_INVOICES_SCRIPT', null),

    'auto_invoice' => 'customscript_autobill_rl',

    /*
    |--------------------------------------------------------------------------
    | Net Suite Item codes
    |--------------------------------------------------------------------------
    |
    | External IDs of the items
    |
    */
    'broadband' => env('BROADBAND_GL_CODE', 50500),
    'colocation' => env('COLOCATION_GL_CODE', 50400),
    'dark_fibre' => env('DARK_FIBRE_GL_CODE', 50100),
    'offnet' => env('OFFNET_GL_CODE', 50300),
    'onnet' => env('ONNET_GL_CODE', 50200),
    'other' => env('OTHER_GL_CODE', 50600),

    /*
    |--------------------------------------------------------------------------
    | Formats
    |--------------------------------------------------------------------------
    |
    | The different formats of objects that NetSuite expects
    |
    */
    'date_format' => 'm/d/Y',
];
