<?php

return [
    'projectPath' => env('PROJECT_PATH'),
    'apiDomain' => env("API_DOMAIN", "https://sandbox.sslcommerz.com"),
    'apiCredentials' => [
        'store_id' => env("SSLCZ_STORE_ID", "books6861ee0dbcac0"),
        'store_password' => env("SSLCZ_STORE_PASSWORD", "books6861ee0dbcac0@ssl"),
    ],
    'apiUrl' => [
        'make_payment' => "/gwprocess/v4/api.php",
        'transaction_status' => "/validator/api/merchantTransIDvalidationAPI.php",
        'order_validate' => "/validator/api/validationserverAPI.php",
        'refund_payment' => "/validator/api/merchantTransIDvalidationAPI.php",
        'refund_status' => "/validator/api/merchantTransIDvalidationAPI.php",
    ],
    'connect_from_localhost' => env("IS_LOCALHOST", true), // For Sandbox, use "true", For Live, use "false"
    'success_url' => env('SSLCZ_SUCCESS_URL', 'payment/success'),
    'failed_url' => env('SSLCZ_FAILED_URL', 'payment/fail'),
    'cancel_url' => env('SSLCZ_CANCEL_URL', 'payment/cancel'),
    'ipn_url' => env('SSLCZ_IPN_URL', 'payment/ipn'),
];
