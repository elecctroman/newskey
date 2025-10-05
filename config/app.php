<?php

return [
    'name' => 'NewsKey Digital Platform',
    'env' => getenv('APP_ENV') ?: 'production',
    'debug' => filter_var(getenv('APP_DEBUG') ?: false, FILTER_VALIDATE_BOOLEAN),
    'url' => getenv('APP_URL') ?: 'http://localhost',
    'key' => getenv('APP_KEY') ?: '',
    'timezone' => 'Europe/Istanbul',
];
