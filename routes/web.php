<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;

// Setup routes
if (!file_exists(DATABASEPATH . '/patel_perfumes.db')) {
    if ($uri === '/setup' || $uri === '/setup-api.php') {
        if ($uri === '/setup') {
            include BASEPATH . '/setup-web.php';
            exit;
        } elseif ($uri === '/setup-api.php') {
            include BASEPATH . '/setup-api.php';
            exit;
        }
    }
}

// Frontend routes
if ($uri === '/') {
    $controller = new HomeController();
    echo $controller->index();
    exit;
}

// Product routes
if ($uri === '/products') {
    $controller = new ProductController();
    echo $controller->index();
    exit;
}

if (preg_match('/^\/products\/(.+)$/', $uri, $matches)) {
    $controller = new ProductController();
    echo $controller->show($matches[1]);
    exit;
}

if (preg_match('/^\/category\/(.+)$/', $uri, $matches)) {
    $controller = new ProductController();
    echo $controller->byCategory($matches[1]);
    exit;
}

// Cart routes
if ($uri === '/cart' && $method === 'GET') {
    $controller = new CartController();
    echo $controller->index();
    exit;
}

if (preg_match('/^\/cart\/(.+)$/', $uri, $matches)) {
    $product_id = $matches[1];
    if ($method === 'POST') {
        $controller = new CartController();
        echo $controller->add($product_id);
    } elseif ($method === 'PUT') {
        $controller = new CartController();
        echo $controller->update($product_id);
    } elseif ($method === 'DELETE') {
        $controller = new CartController();
        echo $controller->remove($product_id);
    }
    exit;
}

// Checkout routes
if ($uri === '/checkout') {
    if ($method === 'GET') {
        $controller = new CheckoutController();
        echo $controller->index();
    } elseif ($method === 'POST') {
        $controller = new CheckoutController();
        echo $controller->store();
    }
    exit;
}

// Order routes
if (preg_match('/^\/order\/(.+)\/confirmation$/', $uri, $matches)) {
    $controller = new OrderController();
    echo $controller->confirmation($matches[1]);
    exit;
}

// Admin login
if ($uri === '/admin/login') {
    echo "Admin Login Page";
    exit;
}

// Admin routes
if (preg_match('/^\/admin\/products/', $uri)) {
    $controller = new AdminProductController();
    
    if ($uri === '/admin/products') {
        echo $controller->index();
    } else if (preg_match('/^\/admin\/products\/(\d+)\/edit$/', $uri, $matches)) {
        echo $controller->edit($matches[1]);
    } else if ($uri === '/admin/products/create') {
        echo $controller->create();
    }
    exit;
}

// 404
http_response_code(404);
echo "Page not found: " . htmlspecialchars($uri);
