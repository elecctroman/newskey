<?php

return [
    'app' => [
        'name' => 'NewsKey Dijital Platformu',
        'env' => 'development',
        'debug' => true,
        'url' => 'http://localhost',
        'key' => 'değiştir-bu-anahtarı',
        'timezone' => 'Europe/Istanbul',
    ],
    'database' => [
        'driver' => 'mysql',
        'host' => '127.0.0.1',
        'port' => 3306,
        'database' => 'newskey',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ],
    ],
    'services' => [
        'mail' => [
            'host' => 'smtp.example.com',
            'port' => 587,
            'username' => 'user@example.com',
            'password' => 'secret',
            'from' => 'noreply@example.com',
        ],
        'shopier' => [
            'api_key' => 'shopier-key',
            'api_secret' => 'shopier-secret',
        ],
        'iyzico' => [
            'api_key' => 'iyzico-key',
            'api_secret' => 'iyzico-secret',
        ],
        'paytr' => [
            'merchant_id' => 'paytr-id',
            'merchant_key' => 'paytr-key',
            'merchant_salt' => 'paytr-salt',
        ],
        'turkpin' => [
            'api_key' => 'turkpin-key',
            'api_secret' => 'turkpin-secret',
        ],
        'pinabi' => [
            'api_key' => 'pinabi-key',
            'api_secret' => 'pinabi-secret',
        ],
        'netgsm' => [
            'usercode' => 'netgsm-user',
            'password' => 'netgsm-pass',
            'header' => 'NETGSM',
        ],
    ],
];
