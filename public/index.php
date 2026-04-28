<?php

define('LARAVEL_START', microtime(true));

// Load bootstrap
require_once __DIR__ . '/../bootstrap.php';

// Check if setup is needed
if (!file_exists(DATABASEPATH . '/patel_perfumes.db')) {
    // Check if we're on setup page
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    
    if ($uri !== '/setup' && $uri !== '/setup-api.php') {
        header('Location: /setup');
        exit;
    }
}

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get request path
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Route dispatcher
try {
    require_once ROUTESPATH . '/web.php';
} catch (Exception $e) {
    http_response_code(500);
    echo 'Error: ' . htmlspecialchars($e->getMessage());
}
