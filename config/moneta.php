<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Test mode
    |--------------------------------------------------------------------------
    |
    | Enable or disable test mode
    |
    */

    'test_mode' => env('MONETA_TEST_MODE', true),

    /*
    |--------------------------------------------------------------------------
    | Gateways parameters
    |--------------------------------------------------------------------------
    |
    | Configuration parameters for each gateway
    |
    */

    'gateways' => [

        /*
        'stripe' => [
            'api_key' => env('STRIPE_SECRET'),
        ],
         */

    ],

];
