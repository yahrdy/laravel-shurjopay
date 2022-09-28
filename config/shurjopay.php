<?php

return [
    'server_url' => env('SHURJOPAY_SERVER_URL', 'https://sandbox.shurjopayment.com'),
    'merchant_username' => env('SHURJOPAY_USERNAME', 'sp_sandbox'),
    'merchant_password' => env('SHURJOPAY_PASSWORD', 'pyyk97hu&6u6'),
    'merchant_key_prefix' => env('SHURJOPAY_KEY_PREFIX', 'ns'),
    'success_url' => env('SHURJOPAY_SUCCESS_URL', 'http://localhost:8000/api/verify'),
    'cancel_url' => env('SHURJOPAY_CANCEL_URL', 'http://localhost:8000/api/verify'),
];
