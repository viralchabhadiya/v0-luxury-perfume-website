@extends('admin.layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <a href="/admin/settings" class="text-blue-600 hover:underline mb-6">&larr; Back to Settings</a>
        
        <h1 class="text-3xl font-bold text-gray-900 mb-8">🤖 AI Features Configuration</h1>
        
        <form method="POST" action="/admin/settings/ai/update" class="space-y-8">
            
            <!-- AI Provider Selection -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Default AI Provider</h2>
                <div class="space-y-3 mb-6">
                    <label class="flex items-center">
                        <input type="radio" name="ai_provider" value="openai" class="mr-3" checked>
                        <span class="font-bold">OpenAI (GPT-4) - Recommended</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="ai_provider" value="groq" class="mr-3">
                        <span class="font-bold">Groq - Fast & Cost Effective</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="ai_provider" value="huggingface" class="mr-3">
                        <span class="font-bold">HuggingFace - Open Source</span>
                    </label>
                </div>
            </div>
            
            <!-- OpenAI Configuration -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">OpenAI Settings</h2>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">API Key</label>
                        <input type="password" name="openai_api_key" class="w-full px-4 py-2 border rounded" value="{{ $_ENV['OPENAI_API_KEY'] ?? '' }}" placeholder="sk-...">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Model</label>
                        <select name="openai_model" class="w-full px-4 py-2 border rounded">
                            <option value="gpt-4" selected>GPT-4 (Recommended)</option>
                            <option value="gpt-4-turbo">GPT-4 Turbo</option>
                            <option value="gpt-3.5-turbo">GPT-3.5 Turbo</option>
                        </select>
                    </div>
                </div>
                <label class="flex items-center">
                    <input type="checkbox" name="openai_enabled" value="1" class="mr-3" {{ ($_ENV['OPENAI_ENABLED'] ?? false) ? 'checked' : '' }}>
                    <span>Enable OpenAI</span>
                </label>
            </div>
            
            <!-- Groq Configuration -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Groq Settings</h2>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">API Key</label>
                        <input type="password" name="groq_api_key" class="w-full px-4 py-2 border rounded" value="{{ $_ENV['GROQ_API_KEY'] ?? '' }}">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Model</label>
                        <select name="groq_model" class="w-full px-4 py-2 border rounded">
                            <option value="mixtral-8x7b" selected>Mixtral 8x7B</option>
                            <option value="llama2-70b">Llama 2 70B</option>
                        </select>
                    </div>
                </div>
                <label class="flex items-center">
                    <input type="checkbox" name="groq_enabled" value="1" class="mr-3" {{ ($_ENV['GROQ_ENABLED'] ?? false) ? 'checked' : '' }}>
                    <span>Enable Groq</span>
                </label>
            </div>
            
            <!-- HuggingFace Configuration -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">HuggingFace Settings</h2>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">API Key</label>
                        <input type="password" name="huggingface_api_key" class="w-full px-4 py-2 border rounded" value="{{ $_ENV['HUGGINGFACE_API_KEY'] ?? '' }}">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Model</label>
                        <input type="text" name="huggingface_model" class="w-full px-4 py-2 border rounded" value="{{ $_ENV['HUGGINGFACE_MODEL'] ?? 'gpt2' }}" placeholder="Model name from HuggingFace">
                    </div>
                </div>
                <label class="flex items-center">
                    <input type="checkbox" name="huggingface_enabled" value="1" class="mr-3" {{ ($_ENV['HUGGINGFACE_ENABLED'] ?? false) ? 'checked' : '' }}>
                    <span>Enable HuggingFace</span>
                </label>
            </div>
            
            <!-- AI Features Toggle -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Enable/Disable Features</h2>
                
                <div class="space-y-4">
                    <div class="p-4 bg-gray-50 rounded border-l-4 border-purple-500">
                        <label class="flex items-center mb-2">
                            <input type="checkbox" name="ai_recommendations" value="1" class="mr-3" {{ ($_ENV['AI_RECOMMENDATIONS'] ?? true) ? 'checked' : '' }}>
                            <span class="font-bold text-gray-900">Product Recommendations</span>
                        </label>
                        <p class="text-sm text-gray-600 ml-6">AI-powered product suggestions based on browsing and purchase history</p>
                    </div>
                    
                    <div class="p-4 bg-gray-50 rounded border-l-4 border-blue-500">
                        <label class="flex items-center mb-2">
                            <input type="checkbox" name="ai_chatbot" value="1" class="mr-3" {{ ($_ENV['AI_CHATBOT'] ?? true) ? 'checked' : '' }}>
                            <span class="font-bold text-gray-900">Customer Support Chatbot</span>
                        </label>
                        <p class="text-sm text-gray-600 ml-6">AI chatbot for answering customer questions and support tickets</p>
                    </div>
                    
                    <div class="p-4 bg-gray-50 rounded border-l-4 border-green-500">
                        <label class="flex items-center mb-2">
                            <input type="checkbox" name="ai_search" value="1" class="mr-3" {{ ($_ENV['AI_SEARCH'] ?? true) ? 'checked' : '' }}>
                            <span class="font-bold text-gray-900">Semantic Search</span>
                        </label>
                        <p class="text-sm text-gray-600 ml-6">Smart search using AI embeddings for better results</p>
                    </div>
                    
                    <div class="p-4 bg-gray-50 rounded border-l-4 border-yellow-500">
                        <label class="flex items-center mb-2">
                            <input type="checkbox" name="ai_content_generation" value="1" class="mr-3" {{ ($_ENV['AI_CONTENT_GENERATION'] ?? true) ? 'checked' : '' }}>
                            <span class="font-bold text-gray-900">Content Generation</span>
                        </label>
                        <p class="text-sm text-gray-600 ml-6">Auto-generate product descriptions and marketing copy</p>
                    </div>
                    
                    <div class="p-4 bg-gray-50 rounded border-l-4 border-red-500">
                        <label class="flex items-center mb-2">
                            <input type="checkbox" name="ai_sentiment_analysis" value="1" class="mr-3" {{ ($_ENV['AI_SENTIMENT_ANALYSIS'] ?? true) ? 'checked' : '' }}>
                            <span class="font-bold text-gray-900">Review Sentiment Analysis</span>
                        </label>
                        <p class="text-sm text-gray-600 ml-6">Analyze customer review sentiment and extract insights</p>
                    </div>
                </div>
            </div>
            
            <!-- Pricing & Limits -->
            <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded">
                <h2 class="text-xl font-bold text-blue-900 mb-4">API Limits & Costs</h2>
                <ul class="text-blue-800 space-y-2 text-sm">
                    <li><strong>OpenAI:</strong> $0.03-0.06 per 1K tokens (GPT-4)</li>
                    <li><strong>Groq:</strong> Fast inference, affordable pricing</li>
                    <li><strong>HuggingFace:</strong> Free tier available, pay-as-you-go options</li>
                    <li><strong>Rate Limits:</strong> 1000 requests/hour, 10000 requests/day (configurable)</li>
                </ul>
            </div>
            
            <!-- Buttons -->
            <div class="flex gap-3">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-bold">Save Settings</button>
                <a href="/admin/settings" class="px-6 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 font-bold">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
