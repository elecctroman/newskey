<?php

declare(strict_types=1);

use App\Models\Product;
use App\Models\User;
use Core\Autoloader;


$autoloader = new Autoloader();
$autoloader->addNamespace('Core', __DIR__ . '/../core');
$autoloader->addNamespace('App', __DIR__ . '/../app');
$autoloader->register();



$user = new User();
$product = new Product();

$user->create([
    'name' => 'Demo Admin',
    'email' => 'admin@example.com',
    'password' => password_hash('password', PASSWORD_BCRYPT),
    'role' => 'admin',
]);

$product->create([
    'category_id' => null,
    'title' => 'Steam Cüzdan Kodu 100 TL',
    'slug' => 'steam-cuzdan-100',
    'sku' => 'STEAM-100',
    'type' => 'epin',
    'price' => 100.00,
    'supplier' => 'turkpin',
    'api_product_id' => 'TP-100',
    'stock' => 50,
    'auto_delivery' => 1,
]);

echo "Demo verileri başarıyla oluşturuldu." . PHP_EOL;
