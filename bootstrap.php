<?php

// Simple Laravel-like bootstrap for the application
define('BASEPATH', __DIR__);
define('APPPATH', BASEPATH . '/app');
define('RESOURCEPATH', BASEPATH . '/resources');
define('STORAGEPATH', BASEPATH . '/storage');
define('DATABASEPATH', BASEPATH . '/database');
define('CONFIGPATH', BASEPATH . '/config');
define('ROUTESPATH', BASEPATH . '/routes');

// Autoloader
require_once BASEPATH . '/vendor/autoload.php';

// Helper functions
function config_path($path = '')
{
    return CONFIGPATH . ($path ? '/' . $path : '');
}

function app_path($path = '')
{
    return APPPATH . ($path ? '/' . $path : '');
}

function database_path($path = '')
{
    return DATABASEPATH . ($path ? '/' . $path : '');
}

function resource_path($path = '')
{
    return RESOURCEPATH . ($path ? '/' . $path : '');
}

function storage_path($path = '')
{
    return STORAGEPATH . ($path ? '/' . $path : '');
}

function route($name, $params = [])
{
    $routes = [
        'home' => '/',
        'products.index' => '/products',
        'products.show' => '/products/{slug}',
        'products.by-category' => '/category/{slug}',
        'cart.index' => '/cart',
        'cart.add' => '/cart/{product}',
        'cart.update' => '/cart/{product}',
        'cart.remove' => '/cart/{product}',
        'checkout.index' => '/checkout',
        'checkout.store' => '/checkout',
        'order.confirmation' => '/order/{order}/confirmation',
        'admin.products.index' => '/admin/products',
        'admin.products.create' => '/admin/products/create',
        'admin.products.edit' => '/admin/products/{product}/edit',
        'admin.categories.index' => '/admin/categories',
    ];

    $url = $routes[$name] ?? '/';

    foreach ($params as $key => $value) {
        $url = str_replace('{' . $key . '}', $value, $url);
    }

    return $url;
}

function auth()
{
    return new stdClass();
}

function session()
{
    if (!isset($_SESSION)) {
        session_start();
    }
    
    return new class {
        public function get($key, $default = null)
        {
            return $_SESSION[$key] ?? $default;
        }

        public function put($key, $value)
        {
            $_SESSION[$key] = $value;
        }

        public function forget($key)
        {
            unset($_SESSION[$key]);
        }
    };
}

// Initialize database connection
require_once APPPATH . '/Database.php';

// Get database instance
function db() {
    static $db = null;
    if ($db === null) {
        $db = Database::getInstance();
    }
    return $db;
}

// Load environment variables
function env($key, $default = null) {
    $envFile = BASEPATH . '/.env';
    
    static $envVars = null;
    if ($envVars === null) {
        $envVars = [];
        if (file_exists($envFile)) {
            $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
                    list($key, $value) = explode('=', $line, 2);
                    $envVars[trim($key)] = trim($value);
                }
            }
        }
    }
    
    return $envVars[$key] ?? $default;
}
