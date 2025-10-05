<?php

return [
    'mail' => [
        'host' => getenv('MAIL_HOST'),
        'port' => getenv('MAIL_PORT'),
        'username' => getenv('MAIL_USER'),
        'password' => getenv('MAIL_PASS'),
        'from' => getenv('MAIL_FROM'),
    ],
    'shopier' => [
        'api_key' => getenv('SHOPIER_API_KEY'),
        'api_secret' => getenv('SHOPIER_API_SECRET'),
    ],
    'iyzico' => [
        'api_key' => getenv('IYZICO_API_KEY'),
        'api_secret' => getenv('IYZICO_API_SECRET'),
    ],
    'paytr' => [
        'merchant_id' => getenv('PAYTR_MERCHANT_ID'),
        'merchant_key' => getenv('PAYTR_MERCHANT_KEY'),
        'merchant_salt' => getenv('PAYTR_MERCHANT_SALT'),
    ],
    'turkpin' => [
        'api_key' => getenv('TURKPIN_API_KEY'),
        'api_secret' => getenv('TURKPIN_API_SECRET'),
    ],
    'pinabi' => [
        'api_key' => getenv('PINABI_API_KEY'),
        'api_secret' => getenv('PINABI_API_SECRET'),
    ],
    'netgsm' => [
        'usercode' => getenv('NETGSM_USERCODE'),
        'password' => getenv('NETGSM_PASSWORD'),
        'header' => getenv('NETGSM_HEADER'),
    ],
];
