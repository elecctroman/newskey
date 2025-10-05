<?php

declare(strict_types=1);

use App\Controllers\AdminController;
use App\Controllers\AuthController;
use App\Controllers\OrderController;
use App\Controllers\PaymentController;
use App\Controllers\ProductController;
use App\Controllers\TicketController;
use Core\Autoloader;
use Core\Config;
use Core\Request;
use Core\Router;

require __DIR__ . '/core/Autoloader.php';
require __DIR__ . '/core/Config.php';

$autoloader = new Autoloader();
$autoloader->addNamespace('Core', __DIR__ . '/core');
$autoloader->addNamespace('App', __DIR__ . '/app');
$autoloader->register();

$timezone = Config::get('app.timezone', 'UTC');
date_default_timezone_set(is_string($timezone) ? $timezone : 'UTC');

$request = new Request();
$router = new Router();

$router->get('/', function (): void {
    (new ProductController())->index();
});

$router->get('/login', function (): void {
    (new AuthController())->showLogin();
});

$router->post('/login', function (): void {
    (new AuthController())->login();
});

$router->get('/forgot-password', function (): void {
    (new AuthController())->showForgotPassword();
});

$router->post('/forgot-password', function (): void {
    (new AuthController())->forgotPassword();
});

$router->get('/register', function (): void {
    (new AuthController())->showRegister();
});

$router->post('/register', function (): void {
    (new AuthController())->register();
});

$router->get('/logout', function (): void {
    (new AuthController())->logout();
});

$router->get('/products', function (): void {
    (new ProductController())->index();
});

$router->get('/products/{slug}', function () use ($request): void {
    $segments = array_values(array_filter(explode('/', trim($request->path(), '/'))));
    $slug = $segments[1] ?? '';
    (new ProductController())->show($slug);
});

$router->post('/orders', function (): void {
    (new OrderController())->store();
});

$router->get('/orders/{id}', function () use ($request): void {
    $segments = array_values(array_filter(explode('/', trim($request->path(), '/'))));
    $id = isset($segments[1]) ? (int) $segments[1] : 0;
    (new OrderController())->show($id);
});

$router->get('/orders/{id}/retry', function () use ($request): void {
    $segments = array_values(array_filter(explode('/', trim($request->path(), '/'))));
    $id = isset($segments[1]) ? (int) $segments[1] : 0;
    (new OrderController())->retry($id);
});

$router->get('/admin', function (): void {
    (new AdminController())->dashboard();
});

$router->get('/admin/orders', function (): void {
    (new AdminController())->orders();
});

$router->get('/admin/api-keys', function (): void {
    (new AdminController())->apiKeys();
});

$router->post('/admin/api-keys', function (): void {
    (new AdminController())->storeSupplierCredential();
});

$router->get('/tickets', function (): void {
    (new TicketController())->index();
});

$router->post('/tickets', function (): void {
    (new TicketController())->store();
});

$router->post('/payments/shopier', function (): void {
    (new PaymentController())->shopierCallback();
});

$router->post('/payments/iyzico', function (): void {
    (new PaymentController())->iyzicoCallback();
});

$router->post('/payments/paytr', function (): void {
    (new PaymentController())->paytrCallback();
});

$router->dispatch($request);
