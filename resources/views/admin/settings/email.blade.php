@extends('admin.layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <a href="/admin/settings" class="text-blue-600 hover:underline mb-6">&larr; Back to Settings</a>
        
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Email Configuration</h1>
        
        <form method="POST" action="/admin/settings/email/update" class="space-y-8">
            
            <!-- Primary Driver Selection -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Email Driver</h2>
                <div class="space-y-3">
                    <label class="flex items-center">
                        <input type="radio" name="mail_driver" value="smtp" class="mr-3" checked>
                        <span>SMTP</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="mail_driver" value="sendgrid" class="mr-3">
                        <span>SendGrid</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="mail_driver" value="mailgun" class="mr-3">
                        <span>Mailgun</span>
                    </label>
                </div>
            </div>
            
            <!-- SMTP Configuration -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">SMTP Settings</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">SMTP Host</label>
                        <input type="text" name="mail_host" class="w-full px-4 py-2 border rounded" placeholder="smtp.gmail.com" value="{{ $_ENV['MAIL_HOST'] ?? '' }}">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">SMTP Port</label>
                        <input type="number" name="mail_port" class="w-full px-4 py-2 border rounded" placeholder="587" value="{{ $_ENV['MAIL_PORT'] ?? 587 }}">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Username</label>
                        <input type="text" name="mail_username" class="w-full px-4 py-2 border rounded" value="{{ $_ENV['MAIL_USERNAME'] ?? '' }}">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Password</label>
                        <input type="password" name="mail_password" class="w-full px-4 py-2 border rounded" value="{{ $_ENV['MAIL_PASSWORD'] ?? '' }}">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-gray-700 font-bold mb-2">Encryption</label>
                        <select name="mail_encryption" class="w-full px-4 py-2 border rounded">
                            <option value="tls">TLS</option>
                            <option value="ssl">SSL</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- From Address -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">From Address</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">From Email</label>
                        <input type="email" name="mail_from_address" class="w-full px-4 py-2 border rounded" placeholder="noreply@patelperfumes.com" value="{{ $_ENV['MAIL_FROM_ADDRESS'] ?? '' }}">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">From Name</label>
                        <input type="text" name="mail_from_name" class="w-full px-4 py-2 border rounded" placeholder="Patel Perfumes" value="{{ $_ENV['MAIL_FROM_NAME'] ?? 'Patel Perfumes' }}">
                    </div>
                </div>
            </div>
            
            <!-- Alternative Services -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Alternative Services</h2>
                
                <div class="mb-6">
                    <h3 class="font-bold text-gray-900 mb-3">SendGrid</h3>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">API Key</label>
                        <input type="password" name="sendgrid_api_key" class="w-full px-4 py-2 border rounded" value="{{ $_ENV['SENDGRID_API_KEY'] ?? '' }}">
                    </div>
                </div>
                
                <div>
                    <h3 class="font-bold text-gray-900 mb-3">Mailgun</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">API Key</label>
                            <input type="password" name="mailgun_api_key" class="w-full px-4 py-2 border rounded" value="{{ $_ENV['MAILGUN_API_KEY'] ?? '' }}">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Domain</label>
                            <input type="text" name="mailgun_domain" class="w-full px-4 py-2 border rounded" value="{{ $_ENV['MAILGUN_DOMAIN'] ?? '' }}">
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Test Email -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Test Email</h2>
                <div class="flex gap-3">
                    <input type="email" id="test-email" class="flex-1 px-4 py-2 border rounded" placeholder="Enter your email address">
                    <button type="button" onclick="testEmail()" class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700">Send Test</button>
                </div>
                <div id="test-result" class="mt-4 text-sm"></div>
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
function testEmail() {
    const email = document.getElementById('test-email').value;
    if (!email) {
        alert('Please enter an email address');
        return;
    }
    
    fetch('/admin/settings/test-email', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'test_email=' + email
    })
    .then(res => res.json())
    .then(data => {
        const resultDiv = document.getElementById('test-result');
        if (data.success) {
            resultDiv.className = 'text-green-600 font-bold';
            resultDiv.textContent = '✓ ' + data.message;
        } else {
            resultDiv.className = 'text-red-600 font-bold';
            resultDiv.textContent = '✗ ' + data.message;
        }
    });
}
</script>
@endsection
