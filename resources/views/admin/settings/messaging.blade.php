@extends('admin.layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <a href="/admin/settings" class="text-blue-600 hover:underline mb-6">&larr; Back to Settings</a>
        
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Messaging & Communication Services</h1>
        
        <form method="POST" action="/admin/settings/messaging/update" class="space-y-8">
            
            <!-- SMS Configuration -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">📱 SMS Configuration</h2>
                
                <div class="mb-6">
                    <h3 class="font-bold text-gray-800 mb-3">SMS Driver</h3>
                    <div class="space-y-3">
                        <label class="flex items-center">
                            <input type="radio" name="sms_driver" value="twilio" class="mr-3" checked>
                            <span>Twilio</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="sms_driver" value="aws_sns" class="mr-3">
                            <span>AWS SNS</span>
                        </label>
                    </div>
                </div>
                
                <!-- Twilio Settings -->
                <div class="bg-gray-50 p-4 rounded mb-4">
                    <h4 class="font-bold text-gray-900 mb-3">Twilio Settings</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Account SID</label>
                            <input type="text" name="twilio_account_sid" class="w-full px-4 py-2 border rounded" value="{{ $_ENV['TWILIO_ACCOUNT_SID'] ?? '' }}">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Auth Token</label>
                            <input type="password" name="twilio_auth_token" class="w-full px-4 py-2 border rounded" value="{{ $_ENV['TWILIO_AUTH_TOKEN'] ?? '' }}">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-gray-700 font-bold mb-2">Phone Number</label>
                            <input type="text" name="twilio_phone_number" class="w-full px-4 py-2 border rounded" placeholder="+1234567890" value="{{ $_ENV['TWILIO_PHONE_NUMBER'] ?? '' }}">
                        </div>
                        <div class="col-span-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="twilio_enabled" value="1" class="mr-3" {{ ($_ENV['TWILIO_ENABLED'] ?? false) ? 'checked' : '' }}>
                                <span>Enable Twilio SMS</span>
                            </label>
                        </div>
                    </div>
                </div>
                
                <!-- AWS SNS Settings -->
                <div class="bg-gray-50 p-4 rounded">
                    <h4 class="font-bold text-gray-900 mb-3">AWS SNS Settings</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Access Key</label>
                            <input type="text" name="aws_sns_key" class="w-full px-4 py-2 border rounded" value="{{ $_ENV['AWS_SNS_KEY'] ?? '' }}">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Secret Key</label>
                            <input type="password" name="aws_sns_secret" class="w-full px-4 py-2 border rounded" value="{{ $_ENV['AWS_SNS_SECRET'] ?? '' }}">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Region</label>
                            <input type="text" name="aws_region" class="w-full px-4 py-2 border rounded" value="{{ $_ENV['AWS_REGION'] ?? 'us-east-1' }}">
                        </div>
                        <div class="col-span-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="aws_sns_enabled" value="1" class="mr-3" {{ ($_ENV['AWS_SNS_ENABLED'] ?? false) ? 'checked' : '' }}>
                                <span>Enable AWS SNS</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- WhatsApp Configuration -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">💬 WhatsApp Business API</h2>
                
                <div class="bg-blue-50 p-4 rounded mb-4 border-l-4 border-blue-500">
                    <p class="text-sm text-blue-900"><strong>Setup:</strong> Get these from Meta Business Manager → WhatsApp Manager</p>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">API Version</label>
                        <input type="text" name="whatsapp_api_version" class="w-full px-4 py-2 border rounded" value="{{ $_ENV['WHATSAPP_API_VERSION'] ?? 'v18.0' }}">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Phone Number ID</label>
                        <input type="text" name="whatsapp_phone_number_id" class="w-full px-4 py-2 border rounded" value="{{ $_ENV['WHATSAPP_PHONE_NUMBER_ID'] ?? '' }}">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Business Account ID</label>
                        <input type="text" name="whatsapp_business_account_id" class="w-full px-4 py-2 border rounded" value="{{ $_ENV['WHATSAPP_BUSINESS_ACCOUNT_ID'] ?? '' }}">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Access Token</label>
                        <input type="password" name="whatsapp_access_token" class="w-full px-4 py-2 border rounded" value="{{ $_ENV['WHATSAPP_ACCESS_TOKEN'] ?? '' }}">
                    </div>
                    <div class="col-span-2">
                        <label class="flex items-center">
                            <input type="checkbox" name="whatsapp_enabled" value="1" class="mr-3" {{ ($_ENV['WHATSAPP_ENABLED'] ?? false) ? 'checked' : '' }}>
                            <span>Enable WhatsApp Integration</span>
                        </label>
                    </div>
                </div>
            </div>
            
            <!-- Telegram Configuration -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">📲 Telegram Bot</h2>
                
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Bot Token</label>
                        <input type="password" name="telegram_bot_token" class="w-full px-4 py-2 border rounded" value="{{ $_ENV['TELEGRAM_BOT_TOKEN'] ?? '' }}">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Webhook URL</label>
                        <input type="text" name="telegram_webhook_url" class="w-full px-4 py-2 border rounded" value="{{ $_ENV['TELEGRAM_WEBHOOK_URL'] ?? '' }}">
                    </div>
                </div>
                
                <label class="flex items-center">
                    <input type="checkbox" name="telegram_enabled" value="1" class="mr-3" {{ ($_ENV['TELEGRAM_ENABLED'] ?? false) ? 'checked' : '' }}>
                    <span>Enable Telegram Bot</span>
                </label>
            </div>
            
            <!-- Push Notifications -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">🔔 Push Notifications (FCM)</h2>
                
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">FCM API Key</label>
                        <input type="password" name="fcm_key" class="w-full px-4 py-2 border rounded" value="{{ $_ENV['FCM_KEY'] ?? '' }}">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Sender ID</label>
                        <input type="text" name="fcm_sender_id" class="w-full px-4 py-2 border rounded" value="{{ $_ENV['FCM_SENDER_ID'] ?? '' }}">
                    </div>
                </div>
                
                <label class="flex items-center">
                    <input type="checkbox" name="push_notifications_enabled" value="1" class="mr-3" {{ ($_ENV['PUSH_NOTIFICATIONS_ENABLED'] ?? false) ? 'checked' : '' }}>
                    <span>Enable Push Notifications</span>
                </label>
            </div>
            
            <!-- Test Section -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Test Services</h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Phone Number (for SMS & WhatsApp)</label>
                        <div class="flex gap-3">
                            <input type="text" id="test-phone" class="flex-1 px-4 py-2 border rounded" placeholder="+91XXXXXXXXXX">
                            <button type="button" onclick="testSMS()" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Test SMS</button>
                            <button type="button" onclick="testWhatsApp()" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Test WhatsApp</button>
                        </div>
                        <div id="sms-result" class="mt-2 text-sm"></div>
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Telegram Chat ID</label>
                        <div class="flex gap-3">
                            <input type="text" id="test-chat-id" class="flex-1 px-4 py-2 border rounded" placeholder="Your Telegram Chat ID">
                            <button type="button" onclick="testTelegram()" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Test Telegram</button>
                        </div>
                        <div id="telegram-result" class="mt-2 text-sm"></div>
                    </div>
                </div>
            </div>
            
            <!-- Buttons -->
            <div class="flex gap-3">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-bold">Save Settings</button>
                <a href="/admin/settings" class="px-6 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 font-bold">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
function testSMS() {
    const phone = document.getElementById('test-phone').value;
    if (!phone) {
        alert('Please enter a phone number');
        return;
    }
    fetch('/admin/settings/test-sms', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'test_phone=' + phone
    }).then(r => r.json()).then(d => {
        const el = document.getElementById('sms-result');
        el.className = d.success ? 'text-green-600 font-bold' : 'text-red-600 font-bold';
        el.textContent = (d.success ? '✓ ' : '✗ ') + d.message;
    });
}

function testWhatsApp() {
    const phone = document.getElementById('test-phone').value;
    if (!phone) {
        alert('Please enter a phone number');
        return;
    }
    fetch('/admin/settings/test-whatsapp', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'test_phone=' + phone
    }).then(r => r.json()).then(d => {
        const el = document.getElementById('sms-result');
        el.className = d.success ? 'text-green-600 font-bold' : 'text-red-600 font-bold';
        el.textContent = (d.success ? '✓ ' : '✗ ') + d.message;
    });
}

function testTelegram() {
    const chatId = document.getElementById('test-chat-id').value;
    if (!chatId) {
        alert('Please enter a Chat ID');
        return;
    }
    fetch('/admin/settings/test-telegram', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'test_chat_id=' + chatId
    }).then(r => r.json()).then(d => {
        const el = document.getElementById('telegram-result');
        el.className = d.success ? 'text-green-600 font-bold' : 'text-red-600 font-bold';
        el.textContent = (d.success ? '✓ ' : '✗ ') + d.message;
    });
}
</script>
@endsection
