<?php

declare(strict_types=1);

use App\Models\Product;
use App\Models\User;
use Core\Autoloader;
use Dotenv\Dotenv;

require __DIR__ . '/../core/Autoloader.php';

if (is_file(__DIR__ . '/../vendor/autoload.php')) {
    require __DIR__ . '/../vendor/autoload.php';
}

$autoloader = new Autoloader();
$autoloader->addNamespace('Core', __DIR__ . '/../core');
$autoloader->addNamespace('App', __DIR__ . '/../app');
$autoloader->register();

if (class_exists(Dotenv::class) && is_file(__DIR__ . '/../.env')) {
    Dotenv::createImmutable(dirname(__DIR__))->safeLoad();
}

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
