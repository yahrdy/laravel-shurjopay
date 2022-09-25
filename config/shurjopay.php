<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Server URL
    |--------------------------------------------------------------------------
    |
    | The server URL provided by ShurjoPay authority.
    |
    */
    'server_url' => env('SHURJOPAY_SERVER_URL', 'https://sandbox.shurjopayment.com'),

    /*
    |--------------------------------------------------------------------------
    | Merchant Username
    |--------------------------------------------------------------------------
    |
    | Your unique merchant username provided by ShurjoPay authority.
    |
    */
    'merchant_username' => env('MERCHANT_USERNAME', 'sp_sandbox'),

    /*
    |--------------------------------------------------------------------------
    | Merchant Password
    |--------------------------------------------------------------------------
    |
    | Your secret merchant password provided by ShurjoPay authority.
    |
    */
    'merchant_password' => env('MERCHANT_PASSWORD', 'pyyk97hu&6u6'),

    /*
    |--------------------------------------------------------------------------
    | Merchant Key Prefix
    |--------------------------------------------------------------------------
    |
    | Your chosen merchant key prefix authorized by ShurjoPay.
    |
    */
    'merchant_key_prefix' => env('MERCHANT_KEY_PREFIX', ''),
];
