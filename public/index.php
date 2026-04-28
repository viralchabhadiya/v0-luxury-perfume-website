<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Laravel application instance
| which serves as the "glue" for all the components of Laravel, and is
| the IoC container for the system binding all of the various parts.
|
*/

define('LARAVEL_START', microtime(true));

// Autoloader
require_once __DIR__ . '/../vendor/autoload.php';

$app = new Illuminate\Container\Container;

// Simple routing and view rendering
$routes = [
    '/' => 'HomeController@index',
    '/products' => 'ProductController@index',
];

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Handle routing
if ($path === '/') {
    renderView('home');
} else if (str_contains($path, '/products/')) {
    $slug = basename($path);
    renderProductDetail($slug);
} else if ($path === '/products') {
    renderView('products/index');
} else if (str_contains($path, '/category/')) {
    $slug = basename($path);
    renderProductByCategory($slug);
} else if ($path === '/cart') {
    renderView('cart/index');
} else if ($path === '/checkout') {
    renderView('checkout/index');
} else if (str_contains($path, '/order/')) {
    // Order confirmation
    renderView('order/confirmation');
}

function renderView($view) {
    echo "View: $view";
}

function renderProductDetail($slug) {
    echo "Product Detail: $slug";
}

function renderProductByCategory($slug) {
    echo "Category: $slug";
}
