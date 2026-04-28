@extends('admin.layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <a href="/admin/settings" class="text-blue-600 hover:underline mb-6">&larr; Back to Settings</a>
        
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Communication Logs</h1>
        
        <!-- Summary Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-lg shadow p-4">
                <p class="text-sm text-gray-600">Total Messages</p>
                <p class="text-2xl font-bold text-gray-900">{{ count($logs) }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-4">
                <p class="text-sm text-gray-600">Sent</p>
                <p class="text-2xl font-bold text-green-600">{{ count(array_filter($logs, fn($l) => $l['status'] === 'sent')) }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-4">
                <p class="text-sm text-gray-600">Pending</p>
                <p class="text-2xl font-bold text-yellow-600">{{ count(array_filter($logs, fn($l) => $l['status'] === 'pending')) }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-4">
                <p class="text-sm text-gray-600">Failed</p>
                <p class="text-2xl font-bold text-red-600">{{ count(array_filter($logs, fn($l) => $l['status'] === 'failed')) }}</p>
            </div>
        </div>
        
        <!-- Filters -->
        <div class="bg-white rounded-lg shadow p-4 mb-6">
            <div class="flex gap-4">
                <input type="text" id="filter-service" class="px-4 py-2 border rounded" placeholder="Filter by service (email, sms, whatsapp, telegram)...">
                <select id="filter-status" class="px-4 py-2 border rounded">
                    <option value="">All Status</option>
                    <option value="sent">Sent</option>
                    <option value="pending">Pending</option>
                    <option value="failed">Failed</option>
                </select>
                <button onclick="applyFilters()" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Filter</button>
            </div>
        </div>
        
        <!-- Logs Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-bold text-gray-900">Service</th>
                        <th class="px-6 py-3 text-left text-sm font-bold text-gray-900">Recipient</th>
                        <th class="px-6 py-3 text-left text-sm font-bold text-gray-900">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-bold text-gray-900">Message</th>
                        <th class="px-6 py-3 text-left text-sm font-bold text-gray-900">Date</th>
                        <th class="px-6 py-3 text-left text-sm font-bold text-gray-900">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($logs as $log)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-900">
                            <span class="px-2 py-1 rounded-full text-xs font-bold" style="background-color: {{ getServiceColor($log['service_type']) }}; color: white;">
                                {{ ucfirst($log['service_type']) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ substr($log['recipient'], 0, 30) }}...</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-2 py-1 rounded-full text-xs font-bold" style="background-color: {{ getStatusColor($log['status']) }}; color: white;">
                                {{ ucfirst($log['status']) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ substr($log['message_content'] ?? 'N/A', 0, 50) }}...</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ date('M d, Y H:i', strtotime($log['created_at'])) }}</td>
                        <td class="px-6 py-4 text-sm">
                            <button onclick="viewDetails({{ json_encode($log) }})" class="text-blue-600 hover:underline">View</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-600">No communication logs yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Details Modal -->
<div id="details-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-900">Message Details</h2>
                <button onclick="closeModal()" class="text-gray-500 hover:text-gray-900">&times;</button>
            </div>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-bold text-gray-900">Service</label>
                    <p id="detail-service" class="text-gray-600"></p>
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-gray-900">Recipient</label>
                    <p id="detail-recipient" class="text-gray-600"></p>
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-gray-900">Status</label>
                    <p id="detail-status" class="text-gray-600"></p>
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-gray-900">Message</label>
                    <p id="detail-message" class="text-gray-600 bg-gray-50 p-3 rounded border break-words"></p>
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-gray-900">Response</label>
                    <p id="detail-response" class="text-gray-600 bg-gray-50 p-3 rounded border max-h-48 overflow-y-auto"></p>
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-gray-900">Date & Time</label>
                    <p id="detail-date" class="text-gray-600"></p>
                </div>
            </div>
            
            <div class="mt-6 flex justify-end">
                <button onclick="closeModal()" class="px-6 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
function getServiceColor(service) {
    const colors = {
        'email_order_confirmation': '#8B6E47',
        'email_shipment': '#6B5437',
        'sms_twilio': '#0099ff',
        'sms_aws': '#ff9900',
        'whatsapp_meta': '#25D366',
        'whatsapp_template': '#20a862',
        'telegram': '#0088cc',
    };
    return colors[service] || '#666';
}

function getStatusColor(status) {
    const colors = {
        'sent': '#22c55e',
        'pending': '#f59e0b',
        'failed': '#ef4444',
    };
    return colors[status] || '#666';
}

function viewDetails(log) {
    document.getElementById('detail-service').textContent = log.service_type;
    document.getElementById('detail-recipient').textContent = log.recipient;
    document.getElementById('detail-status').textContent = log.status.charAt(0).toUpperCase() + log.status.slice(1);
    document.getElementById('detail-message').textContent = log.message_content || 'N/A';
    document.getElementById('detail-response').textContent = log.response || 'No response';
    document.getElementById('detail-date').textContent = new Date(log.created_at).toLocaleString();
    
    document.getElementById('details-modal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('details-modal').classList.add('hidden');
}

function applyFilters() {
    // Filter implementation would go here
    alert('Filter feature coming soon');
}
</script>

<?php
function getServiceColor($service) {
    $colors = [
        'email_order_confirmation' => '#8B6E47',
        'sms_twilio' => '#0099ff',
        'whatsapp_meta' => '#25D366',
        'telegram' => '#0088cc',
    ];
    return $colors[$service] ?? '#666';
}

function getStatusColor($status) {
    $colors = [
        'sent' => '#22c55e',
        'pending' => '#f59e0b',
        'failed' => '#ef4444',
    ];
    return $colors[$status] ?? '#666';
}
?>

@endsection
