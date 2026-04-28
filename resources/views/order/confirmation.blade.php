@extends('layouts.app')

@section('title', 'Order Confirmation - Patel Perfumes')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div data-scroll-fade style="opacity: 0; transform: translateY(30px);" class="text-center mb-12">
        <div class="text-7xl mb-6">✓</div>
        <h1 class="text-4xl font-bold text-primary mb-4">Order Confirmed!</h1>
        <p class="text-lg text-dark/60">Thank you for your purchase. Your order has been received and is being prepared.</p>
    </div>

    <div class="bg-white rounded-lg shadow p-8 mb-8" data-scroll-stagger>
        <div data-stagger-item style="opacity: 0; transform: translateY(30px);" class="grid grid-cols-2 gap-6 pb-8 border-b border-dark/20">
            <div>
                <p class="text-dark/60 text-sm mb-1">Order Number</p>
                <p class="text-2xl font-bold text-primary">{{ $order->order_number }}</p>
            </div>
            <div>
                <p class="text-dark/60 text-sm mb-1">Order Date</p>
                <p class="text-lg font-semibold text-dark">{{ $order->created_at->format('M d, Y') }}</p>
            </div>
            <div>
                <p class="text-dark/60 text-sm mb-1">Status</p>
                <p class="text-lg font-semibold text-green-600">✓ Pending</p>
            </div>
            <div>
                <p class="text-dark/60 text-sm mb-1">Estimated Delivery</p>
                <p class="text-lg font-semibold text-dark">5-7 business days</p>
            </div>
        </div>

        <div data-stagger-item style="opacity: 0; transform: translateY(30px);" class="py-8 border-b border-dark/20">
            <h3 class="text-lg font-bold text-primary mb-6">Order Items</h3>
            <div class="space-y-4">
                @foreach($order->items as $item)
                    <div class="flex items-center justify-between p-4 bg-secondary/20 rounded">
                        <div class="flex items-center gap-4">
                            <div class="w-20 h-20 bg-gradient-to-br from-accent/20 to-primary/20 rounded flex items-center justify-center text-3xl">
                                🧴
                            </div>
                            <div>
                                <h4 class="font-bold text-dark">{{ $item->product->name }}</h4>
                                <p class="text-dark/60 text-sm">{{ $item->product->volume }}</p>
                                <p class="text-primary font-bold mt-1">Qty: {{ $item->quantity }} × ${{ number_format($item->price, 2) }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-accent">${{ number_format($item->subtotal, 2) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div data-stagger-item style="opacity: 0; transform: translateY(30px);" class="py-8 border-b border-dark/20">
            <h3 class="text-lg font-bold text-primary mb-4">Shipping Address</h3>
            <p class="text-dark font-semibold">
                {{ $order->shipping_address['first_name'] }} {{ $order->shipping_address['last_name'] }}
            </p>
            <p class="text-dark/70">{{ $order->shipping_address['address'] }}</p>
            <p class="text-dark/70">{{ $order->shipping_address['city'] }}, {{ $order->shipping_address['state'] }} {{ $order->shipping_address['postal_code'] }}</p>
            <p class="text-dark/70">{{ $order->shipping_address['country'] }}</p>
        </div>

        <div data-stagger-item style="opacity: 0; transform: translateY(30px);" class="py-8 space-y-2">
            <div class="flex justify-between text-lg">
                <span class="text-dark/70">Subtotal</span>
                <span class="font-semibold text-dark">${{ number_format($order->subtotal, 2) }}</span>
            </div>
            <div class="flex justify-between text-lg">
                <span class="text-dark/70">Tax</span>
                <span class="font-semibold text-dark">${{ number_format($order->tax, 2) }}</span>
            </div>
            <div class="flex justify-between text-2xl font-bold text-primary border-t border-dark/20 pt-4">
                <span>Total</span>
                <span class="text-accent">${{ number_format($order->total, 2) }}</span>
            </div>
        </div>
    </div>

    <div data-scroll-fade style="opacity: 0; transform: translateY(30px);" class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h3 class="font-bold text-blue-900 mb-2">What's Next?</h3>
            <p class="text-blue-800 text-sm leading-relaxed">
                We'll send you an email confirmation shortly with tracking information. You can monitor your order status anytime.
            </p>
        </div>
        <div class="bg-green-50 border border-green-200 rounded-lg p-6">
            <h3 class="font-bold text-green-900 mb-2">Questions?</h3>
            <p class="text-green-800 text-sm leading-relaxed">
                Contact our customer service team at support@patelperfumes.com or call 1-800-PERFUME.
            </p>
        </div>
    </div>

    <div class="flex gap-4 justify-center">
        <a href="{{ route('products.index') }}" class="bg-primary text-white px-8 py-3 rounded font-bold hover:bg-primary/90 transition">
            Continue Shopping
        </a>
        <button onclick="window.print()" class="border-2 border-primary text-primary px-8 py-3 rounded font-bold hover:bg-primary/5 transition">
            Print Receipt
        </button>
    </div>
</div>
@endsection
