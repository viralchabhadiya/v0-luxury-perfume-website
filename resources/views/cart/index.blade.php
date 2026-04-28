@extends('layouts.app')

@section('title', 'Shopping Cart - Patel Perfumes')

@section('content')
<div class="bg-secondary/30 py-8 mb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold text-primary">Shopping Cart</h1>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    @if(empty($items))
        <div data-scroll-fade style="opacity: 0; transform: translateY(30px);" class="text-center py-12">
            <div class="text-6xl mb-4">🛒</div>
            <h2 class="text-3xl font-bold text-primary mb-4">Your Cart is Empty</h2>
            <p class="text-dark/60 mb-8 text-lg">Explore our collection and find your perfect fragrance</p>
            <a href="{{ route('products.index') }}" class="inline-block bg-primary text-white px-8 py-3 rounded hover:bg-primary/90 transition font-semibold">
                Continue Shopping
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Cart Items -->
            <div class="lg:col-span-2">
                <div data-scroll-fade style="opacity: 0; transform: translateX(-30px);" class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 bg-primary text-white font-bold">
                        Cart Items ({{ count($items) }})
                    </div>

                    <div data-scroll-stagger>
                        @foreach($items as $item)
                            <div data-stagger-item style="opacity: 0; transform: translateY(30px);" class="border-b border-dark/10 p-6 flex items-start gap-6 hover:bg-secondary/20 transition">
                                <div class="w-24 h-24 bg-gradient-to-br from-accent/20 to-primary/20 rounded flex items-center justify-center text-4xl flex-shrink-0">
                                    🧴
                                </div>
                                
                                <div class="flex-1">
                                    <h3 class="text-lg font-bold text-primary mb-2">{{ $item['product']->name }}</h3>
                                    <p class="text-dark/60 text-sm mb-2">{{ $item['product']->volume }}</p>
                                    <p class="text-lg font-bold text-accent">
                                        ${{ number_format($item['product']->discount_price ? $item['product']->discount_price : $item['product']->price, 2) }}
                                    </p>
                                </div>

                                <div class="flex flex-col items-end gap-4">
                                    <div class="flex items-center border border-dark/20 rounded">
                                        <form action="{{ route('cart.update', $item['product']->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" name="quantity" value="{{ max(1, $item['quantity'] - 1) }}" class="px-3 py-2 hover:bg-dark/10">−</button>
                                        </form>
                                        <span class="px-4 py-2 border-l border-r border-dark/20">{{ $item['quantity'] }}</span>
                                        <form action="{{ route('cart.update', $item['product']->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" name="quantity" value="{{ min(10, $item['quantity'] + 1) }}" class="px-3 py-2 hover:bg-dark/10">+</button>
                                        </form>
                                    </div>
                                    
                                    <form action="{{ route('cart.remove', $item['product']->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-700 font-semibold text-sm">Remove</button>
                                    </form>

                                    <p class="font-bold text-primary text-lg">
                                        ${{ number_format($item['itemTotal'], 2) }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="px-6 py-4 bg-secondary/20 flex justify-between items-center">
                        <a href="{{ route('products.index') }}" class="text-primary hover:underline font-semibold">
                            ← Continue Shopping
                        </a>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div data-scroll-fade style="opacity: 0; transform: translateX(30px);">
                <div class="bg-white rounded-lg shadow p-6 sticky top-24">
                    <h3 class="text-xl font-bold text-primary mb-6">Order Summary</h3>

                    <div class="space-y-3 pb-6 border-b border-dark/20">
                        <div class="flex justify-between">
                            <span class="text-dark/60">Subtotal</span>
                            <span class="font-semibold text-dark">${{ number_format($total, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-dark/60">Shipping</span>
                            <span class="font-semibold text-dark">
                                @if($total >= 50)
                                    Free
                                @else
                                    $10.00
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-dark/60">Tax (8%)</span>
                            <span class="font-semibold text-dark">${{ number_format($total * 0.08, 2) }}</span>
                        </div>
                    </div>

                    <div class="py-6 flex justify-between items-center mb-6">
                        <span class="text-lg font-bold text-primary">Total</span>
                        <span class="text-3xl font-bold text-accent">
                            ${{ number_format($total + ($total * 0.08) + ($total >= 50 ? 0 : 10), 2) }}
                        </span>
                    </div>

                    <a href="{{ route('checkout.index') }}" class="w-full bg-primary text-white py-3 rounded font-bold hover:bg-primary/90 transition text-center block mb-4">
                        Proceed to Checkout
                    </a>

                    <p class="text-center text-dark/60 text-sm">Free shipping on orders over $50</p>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
