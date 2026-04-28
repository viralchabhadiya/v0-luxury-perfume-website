<?php

return [
    'default_provider' => env('AI_PROVIDER', 'openai'),
    
    'openai' => [
        'api_key' => env('OPENAI_API_KEY', ''),
        'model' => env('OPENAI_MODEL', 'gpt-4'),
        'enabled' => env('OPENAI_ENABLED', false),
    ],
    
    'groq' => [
        'api_key' => env('GROQ_API_KEY', ''),
        'model' => env('GROQ_MODEL', 'mixtral-8x7b'),
        'enabled' => env('GROQ_ENABLED', false),
    ],
    
    'huggingface' => [
        'api_key' => env('HUGGINGFACE_API_KEY', ''),
        'model' => env('HUGGINGFACE_MODEL', 'gpt2'),
        'enabled' => env('HUGGINGFACE_ENABLED', false),
    ],
    
    'features' => [
        'recommendations' => [
            'enabled' => env('AI_RECOMMENDATIONS', true),
            'min_score' => 0.75,
            'max_products' => 5,
        ],
        
        'chatbot' => [
            'enabled' => env('AI_CHATBOT', true),
            'model' => env('AI_CHATBOT_MODEL', 'gpt-4'),
            'temperature' => 0.7,
            'max_tokens' => 500,
        ],
        
        'search' => [
            'enabled' => env('AI_SEARCH', true),
            'semantic_search' => true,
        ],
        
        'content_generation' => [
            'enabled' => env('AI_CONTENT_GENERATION', true),
            'product_descriptions' => true,
            'marketing_copy' => true,
        ],
        
        'sentiment_analysis' => [
            'enabled' => env('AI_SENTIMENT_ANALYSIS', true),
        ],
    ],
    
    'limits' => [
        'requests_per_hour' => 1000,
        'requests_per_day' => 10000,
        'tokens_per_request' => 2000,
    ],
];
