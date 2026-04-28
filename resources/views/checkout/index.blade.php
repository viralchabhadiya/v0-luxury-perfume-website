@extends('layouts.app')

@section('title', 'Checkout - Patel Perfumes')

@section('content')
<div class="bg-secondary/30 py-8 mb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold text-primary">Checkout</h1>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Checkout Form -->
        <form action="{{ route('checkout.store') }}" method="POST" class="lg:col-span-2" data-scroll-fade style="opacity: 0; transform: translateX(-30px);">
            @csrf

            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h3 class="text-xl font-bold text-primary mb-6">Billing Information</h3>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="first_name" class="block text-sm font-semibold text-dark mb-2">First Name *</label>
                        <input type="text" id="first_name" name="first_name" required class="w-full px-4 py-2 border border-dark/20 rounded focus:outline-none focus:ring-2 focus:ring-primary" value="{{ old('first_name') }}">
                        @error('first_name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="last_name" class="block text-sm font-semibold text-dark mb-2">Last Name *</label>
                        <input type="text" id="last_name" name="last_name" required class="w-full px-4 py-2 border border-dark/20 rounded focus:outline-none focus:ring-2 focus:ring-primary" value="{{ old('last_name') }}">
                        @error('last_name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-semibold text-dark mb-2">Email Address *</label>
                    <input type="email" id="email" name="email" required class="w-full px-4 py-2 border border-dark/20 rounded focus:outline-none focus:ring-2 focus:ring-primary" value="{{ old('email') }}">
                    @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label for="phone" class="block text-sm font-semibold text-dark mb-2">Phone Number *</label>
                    <input type="tel" id="phone" name="phone" required class="w-full px-4 py-2 border border-dark/20 rounded focus:outline-none focus:ring-2 focus:ring-primary" value="{{ old('phone') }}">
                    @error('phone') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h3 class="text-xl font-bold text-primary mb-6">Shipping Address</h3>

                <div class="mb-4">
                    <label for="address" class="block text-sm font-semibold text-dark mb-2">Street Address *</label>
                    <input type="text" id="address" name="address" required class="w-full px-4 py-2 border border-dark/20 rounded focus:outline-none focus:ring-2 focus:ring-primary" value="{{ old('address') }}">
                    @error('address') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="city" class="block text-sm font-semibold text-dark mb-2">City *</label>
                        <input type="text" id="city" name="city" required class="w-full px-4 py-2 border border-dark/20 rounded focus:outline-none focus:ring-2 focus:ring-primary" value="{{ old('city') }}">
                        @error('city') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="state" class="block text-sm font-semibold text-dark mb-2">State/Province *</label>
                        <input type="text" id="state" name="state" required class="w-full px-4 py-2 border border-dark/20 rounded focus:outline-none focus:ring-2 focus:ring-primary" value="{{ old('state') }}">
                        @error('state') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="postal_code" class="block text-sm font-semibold text-dark mb-2">Postal Code *</label>
                        <input type="text" id="postal_code" name="postal_code" required class="w-full px-4 py-2 border border-dark/20 rounded focus:outline-none focus:ring-2 focus:ring-primary" value="{{ old('postal_code') }}">
                        @error('postal_code') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="country" class="block text-sm font-semibold text-dark mb-2">Country *</label>
                        <input type="text" id="country" name="country" required class="w-full px-4 py-2 border border-dark/20 rounded focus:outline-none focus:ring-2 focus:ring-primary" value="{{ old('country', 'United States') }}">
                        @error('country') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h3 class="text-xl font-bold text-primary mb-6">Payment Method</h3>

                <div class="space-y-3">
                    <label class="flex items-center p-4 border border-dark/20 rounded cursor-pointer hover:bg-secondary/20 transition">
                        <input type="radio" name="payment_method" value="credit_card" required class="w-4 h-4 text-primary" checked>
                        <span class="ml-3 font-semibold text-dark">Credit Card</span>
                    </label>
                    <label class="flex items-center p-4 border border-dark/20 rounded cursor-pointer hover:bg-secondary/20 transition">
                        <input type="radio" name="payment_method" value="debit_card" required class="w-4 h-4 text-primary">
                        <span class="ml-3 font-semibold text-dark">Debit Card</span>
                    </label>
                    <label class="flex items-center p-4 border border-dark/20 rounded cursor-pointer hover:bg-secondary/20 transition">
                        <input type="radio" name="payment_method" value="paypal" required class="w-4 h-4 text-primary">
                        <span class="ml-3 font-semibold text-dark">PayPal</span>
                    </label>
                </div>
            </div>

            <button type="submit" class="w-full bg-primary text-white py-4 rounded font-bold text-lg hover:bg-primary/90 transition">
                Complete Order
            </button>
        </form>

        <!-- Order Summary -->
        <div data-scroll-fade style="opacity: 0; transform: translateX(30px);">
            <div class="bg-white rounded-lg shadow p-6 sticky top-24">
                <h3 class="text-xl font-bold text-primary mb-6">Order Summary</h3>

                <div class="space-y-4 pb-6 border-b border-dark/20">
                    @foreach($items as $item)
                        <div class="flex items-start gap-4">
                            <div class="w-16 h-16 bg-gradient-to-br from-accent/20 to-primary/20 rounded flex items-center justify-center text-2xl flex-shrink-0">
                                🧴
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-dark text-sm">{{ $item['product']->name }}</h4>
                                <p class="text-dark/60 text-xs">Qty: {{ $item['quantity'] }}</p>
                                <p class="font-bold text-accent mt-1">${{ number_format($item['itemTotal'], 2) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="space-y-3 mb-6">
                    <div class="flex justify-between">
                        <span class="text-dark/60">Subtotal</span>
                        <span class="font-semibold text-dark">${{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-dark/60">Shipping</span>
                        <span class="font-semibold text-dark">
                            @if($subtotal >= 50)
                                Free
                            @else
                                $10.00
                            @endif
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-dark/60">Tax (8%)</span>
                        <span class="font-semibold text-dark">${{ number_format($tax, 2) }}</span>
                    </div>
                </div>

                <div class="py-6 flex justify-between items-center border-t border-dark/20">
                    <span class="text-lg font-bold text-primary">Total</span>
                    <span class="text-3xl font-bold text-accent">${{ number_format($total, 2) }}</span>
                </div>

                <div class="bg-green-50 border border-green-200 rounded p-4 text-sm">
                    <p class="text-green-800">✓ Secure checkout powered by industry-leading encryption</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
