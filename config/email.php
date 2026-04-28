<?php

return [
    'driver' => env('MAIL_DRIVER', 'smtp'),
    
    'smtp' => [
        'host' => env('MAIL_HOST', 'smtp.gmail.com'),
        'port' => env('MAIL_PORT', 587),
        'username' => env('MAIL_USERNAME', ''),
        'password' => env('MAIL_PASSWORD', ''),
        'from_address' => env('MAIL_FROM_ADDRESS', 'noreply@patelperfumes.com'),
        'from_name' => env('MAIL_FROM_NAME', 'Patel Perfumes'),
        'encryption' => env('MAIL_ENCRYPTION', 'tls'),
    ],
    
    'sendgrid' => [
        'api_key' => env('SENDGRID_API_KEY', ''),
        'from_address' => env('MAIL_FROM_ADDRESS', 'noreply@patelperfumes.com'),
        'from_name' => env('MAIL_FROM_NAME', 'Patel Perfumes'),
    ],
    
    'mailgun' => [
        'api_key' => env('MAILGUN_API_KEY', ''),
        'domain' => env('MAILGUN_DOMAIN', ''),
        'from_address' => env('MAIL_FROM_ADDRESS', 'noreply@patelperfumes.com'),
    ],
    
    'templates' => [
        'welcome' => true,
        'order_confirmation' => true,
        'order_shipped' => true,
        'order_delivered' => true,
        'newsletter' => true,
        'password_reset' => true,
        'review_request' => true,
    ],
    
    'queue' => [
        'enabled' => env('QUEUE_MAIL', false),
        'connection' => env('QUEUE_CONNECTION', 'database'),
    ],
];
