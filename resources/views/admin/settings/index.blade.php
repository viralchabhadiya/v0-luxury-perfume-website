@extends('admin.layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Settings & Configuration</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Email Settings -->
            <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
                <div class="flex items-center mb-4">
                    <span class="text-3xl mr-3">✉️</span>
                    <h2 class="text-xl font-bold text-gray-900">Email Configuration</h2>
                </div>
                <p class="text-gray-600 mb-4">Configure SMTP, SendGrid, and Mailgun settings for transactional emails</p>
                <a href="/admin/settings/email" class="btn btn-primary">Configure Email</a>
            </div>
            
            <!-- SMS & Messaging -->
            <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
                <div class="flex items-center mb-4">
                    <span class="text-3xl mr-3">💬</span>
                    <h2 class="text-xl font-bold text-gray-900">Messaging Services</h2>
                </div>
                <p class="text-gray-600 mb-4">Setup SMS (Twilio, AWS SNS), WhatsApp, and Telegram integrations</p>
                <a href="/admin/settings/messaging" class="btn btn-primary">Configure Messaging</a>
            </div>
            
            <!-- AI Settings -->
            <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
                <div class="flex items-center mb-4">
                    <span class="text-3xl mr-3">🤖</span>
                    <h2 class="text-xl font-bold text-gray-900">AI Features</h2>
                </div>
                <p class="text-gray-600 mb-4">Enable and configure AI recommendations, chatbot, and content generation</p>
                <a href="/admin/settings/ai" class="btn btn-primary">Configure AI</a>
            </div>
            
            <!-- Communication Logs -->
            <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
                <div class="flex items-center mb-4">
                    <span class="text-3xl mr-3">📋</span>
                    <h2 class="text-xl font-bold text-gray-900">Communication Logs</h2>
                </div>
                <p class="text-gray-600 mb-4">View logs for all emails, SMS, WhatsApp, and Telegram messages sent</p>
                <a href="/admin/settings/logs" class="btn btn-primary">View Logs</a>
            </div>
        </div>
        
        <!-- Quick Setup Guide -->
        <div class="bg-blue-50 border-l-4 border-blue-500 p-6 mt-8 rounded">
            <h3 class="text-lg font-bold text-blue-900 mb-4">Quick Setup Guide for 2026</h3>
            <div class="text-blue-800 space-y-2">
                <p><strong>1. Email Configuration:</strong> Set up SMTP credentials for order confirmations</p>
                <p><strong>2. SMS Integration:</strong> Add Twilio for order notifications</p>
                <p><strong>3. WhatsApp Business:</strong> Connect Meta WhatsApp Business API for customer support</p>
                <p><strong>4. Telegram Bot:</strong> Set up bot token for automated customer alerts</p>
                <p><strong>5. AI Services:</strong> Configure OpenAI or Groq for recommendations and chatbot</p>
                <p><strong>6. Test Connections:</strong> Use test buttons to verify all services work</p>
            </div>
        </div>
    </div>
</div>

<style>
.btn {
    display: inline-block;
    padding: 10px 20px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s;
}

.btn-primary {
    background-color: #8B6E47;
    color: white;
}

.btn-primary:hover {
    background-color: #6B5437;
}
</style>
@endsection
