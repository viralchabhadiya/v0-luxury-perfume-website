<?php

return [
    'sms' => [
        'driver' => env('SMS_DRIVER', 'twilio'),
        'twilio' => [
            'account_sid' => env('TWILIO_ACCOUNT_SID', ''),
            'auth_token' => env('TWILIO_AUTH_TOKEN', ''),
            'phone_number' => env('TWILIO_PHONE_NUMBER', ''),
            'enabled' => env('TWILIO_ENABLED', false),
        ],
        'aws_sns' => [
            'key' => env('AWS_SNS_KEY', ''),
            'secret' => env('AWS_SNS_SECRET', ''),
            'region' => env('AWS_REGION', 'us-east-1'),
            'enabled' => env('AWS_SNS_ENABLED', false),
        ],
    ],
    
    'whatsapp' => [
        'driver' => env('WHATSAPP_DRIVER', 'meta'),
        'meta' => [
            'api_version' => env('WHATSAPP_API_VERSION', 'v18.0'),
            'phone_number_id' => env('WHATSAPP_PHONE_NUMBER_ID', ''),
            'business_account_id' => env('WHATSAPP_BUSINESS_ACCOUNT_ID', ''),
            'access_token' => env('WHATSAPP_ACCESS_TOKEN', ''),
            'enabled' => env('WHATSAPP_ENABLED', false),
        ],
    ],
    
    'telegram' => [
        'bot_token' => env('TELEGRAM_BOT_TOKEN', ''),
        'webhook_url' => env('TELEGRAM_WEBHOOK_URL', ''),
        'enabled' => env('TELEGRAM_ENABLED', false),
    ],
    
    'push_notifications' => [
        'fcm_key' => env('FCM_KEY', ''),
        'fcm_sender_id' => env('FCM_SENDER_ID', ''),
        'enabled' => env('PUSH_NOTIFICATIONS_ENABLED', false),
    ],
    
    'defaults' => [
        'sms_for_orders' => env('SMS_FOR_ORDERS', true),
        'sms_for_shipments' => env('SMS_FOR_SHIPMENTS', true),
        'whatsapp_for_support' => env('WHATSAPP_FOR_SUPPORT', true),
        'telegram_for_alerts' => env('TELEGRAM_FOR_ALERTS', true),
    ],
];
