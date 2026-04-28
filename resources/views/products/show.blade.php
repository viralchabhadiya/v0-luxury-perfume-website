@extends('layouts.app')

@section('title', $product->name . ' - Patel Perfumes')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Breadcrumb -->
    <div class="mb-8">
        <a href="{{ route('products.index') }}" class="text-primary hover:underline">Products</a> / 
        <a href="{{ route('products.by-category', $product->category->slug) }}" class="text-primary hover:underline">{{ $product->category->name }}</a> / 
        <span class="text-dark/60">{{ $product->name }}</span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
        <!-- Product Image -->
        <div data-scroll-fade style="opacity: 0; transform: translateX(-30px);" class="relative h-96 md:h-full min-h-96 bg-gradient-to-br from-accent/20 to-primary/20 rounded-lg flex items-center justify-center overflow-hidden">
            <div class="text-7xl">🧴</div>
            @if($product->discount_price)
                <div class="absolute top-6 right-6 bg-accent text-dark text-lg font-bold px-6 py-3 rounded-full">
                    Save {{ $product->discount_percentage }}%
                </div>
            @endif
        </div>

        <!-- Product Details -->
        <div data-scroll-fade style="opacity: 0; transform: translateX(30px);">
            <div class="mb-4">
                <a href="{{ route('products.by-category', $product->category->slug) }}" class="text-primary text-sm font-semibold hover:underline">
                    {{ $product->category->name }}
                </a>
            </div>

            <h1 class="text-4xl md:text-5xl font-bold text-primary mb-4">{{ $product->name }}</h1>

            <div class="flex items-center gap-4 mb-6">
                <div class="flex text-accent">
                    <span>★★★★★</span>
                </div>
                <span class="text-dark/60">(48 reviews)</span>
            </div>

            <p class="text-lg text-dark/70 mb-8">{{ $product->description }}</p>

            <!-- Price Section -->
            <div class="mb-8 pb-8 border-b border-dark/20">
                <div class="flex items-baseline gap-4 mb-4">
                    @if($product->discount_price)
                        <span class="text-4xl font-bold text-accent">${{ number_format($product->discount_price, 2) }}</span>
                        <span class="text-2xl text-dark/40 line-through">${{ number_format($product->price, 2) }}</span>
                    @else
                        <span class="text-4xl font-bold text-primary">${{ number_format($product->price, 2) }}</span>
                    @endif
                </div>
                @if($product->discount_price)
                    <p class="text-accent font-semibold">You save: ${{ number_format($product->price - $product->discount_price, 2) }}</p>
                @endif
            </div>

            <!-- Fragrance Details -->
            <div class="mb-8 pb-8 border-b border-dark/20">
                <h3 class="text-lg font-bold text-primary mb-4">Fragrance Profile</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-dark/60 font-semibold">Volume</p>
                        <p class="text-dark font-bold">{{ $product->volume }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-dark/60 font-semibold">Scent Type</p>
                        <p class="text-dark font-bold">{{ $product->scent_profile }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-dark/60 font-semibold">Longevity</p>
                        <p class="text-dark font-bold">{{ $product->longevity }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-dark/60 font-semibold">Projection</p>
                        <p class="text-dark font-bold">{{ $product->projection }}</p>
                    </div>
                </div>
            </div>

            <!-- Top Notes -->
            @if($product->notes && count($product->notes) > 0)
                <div class="mb-8 pb-8 border-b border-dark/20">
                    <h3 class="text-lg font-bold text-primary mb-4">Fragrance Notes</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($product->notes as $note)
                            <span class="bg-secondary text-dark px-4 py-2 rounded-full text-sm font-semibold">{{ $note }}</span>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Stock Status -->
            <div class="mb-8">
                @if($product->in_stock)
                    <span class="text-green-600 font-bold text-lg">✓ In Stock</span>
                @else
                    <span class="text-red-600 font-bold text-lg">Out of Stock</span>
                @endif
            </div>

            <!-- Add to Cart -->
            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mb-8">
                @csrf
                <div class="flex items-center gap-4 mb-6">
                    <label for="quantity" class="font-semibold text-dark">Quantity:</label>
                    <div class="flex items-center border border-dark/20 rounded">
                        <button type="button" class="px-4 py-2 text-dark hover:bg-dark/10" onclick="decrementQty()">−</button>
                        <input type="number" id="quantity" name="quantity" value="1" min="1" max="10" class="w-16 text-center border-0 focus:ring-0" readonly>
                        <button type="button" class="px-4 py-2 text-dark hover:bg-dark/10" onclick="incrementQty()">+</button>
                    </div>
                </div>

                @if($product->in_stock)
                    <button type="submit" class="w-full bg-primary text-white py-4 rounded font-bold text-lg hover:bg-primary/90 transition mb-4">
                        Add to Cart
                    </button>
                @else
                    <button type="button" disabled class="w-full bg-dark/20 text-dark/50 py-4 rounded font-bold text-lg cursor-not-allowed">
                        Out of Stock
                    </button>
                @endif

                <button type="button" class="w-full border-2 border-primary text-primary py-3 rounded font-bold hover:bg-primary/5 transition">
                    Add to Wishlist
                </button>
            </form>

            <!-- Product Description -->
            <div class="mb-8 pb-8 border-b border-dark/20">
                <h3 class="text-lg font-bold text-primary mb-4">About This Fragrance</h3>
                <p class="text-dark/70 leading-relaxed">{{ $product->long_description }}</p>
            </div>

            <!-- Shipping & Returns -->
            <div class="grid grid-cols-2 gap-4">
                <div class="text-center p-4 bg-secondary/30 rounded">
                    <p class="text-primary font-bold mb-2">🚚</p>
                    <p class="text-sm font-semibold text-dark">Free Shipping on Orders $50+</p>
                </div>
                <div class="text-center p-4 bg-secondary/30 rounded">
                    <p class="text-primary font-bold mb-2">↩️</p>
                    <p class="text-sm font-semibold text-dark">30-Day Returns</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <section class="mt-20 pt-12 border-t border-dark/20">
            <div data-scroll-fade style="opacity: 0; transform: translateY(30px);" class="mb-10">
                <h2 class="text-3xl font-bold text-primary mb-2">You May Also Like</h2>
                <p class="text-dark/60">Similar fragrances you might enjoy</p>
            </div>

            <div data-scroll-stagger class="grid grid-cols-1 md:grid-cols-4 gap-8">
                @foreach($relatedProducts as $related)
                    <div data-stagger-item style="opacity: 0; transform: translateY(30px);" class="bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition">
                        <div class="h-48 bg-gradient-to-br from-accent/20 to-primary/20 flex items-center justify-center">
                            <span class="text-5xl">🧴</span>
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-primary mb-2 truncate">{{ $related->name }}</h3>
                            <p class="text-dark/60 text-sm mb-4 line-clamp-2">{{ $related->description }}</p>
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    @if($related->discount_price)
                                        <span class="text-lg font-bold text-accent">${{ $related->discount_price }}</span>
                                    @else
                                        <span class="text-lg font-bold text-primary">${{ $related->price }}</span>
                                    @endif
                                </div>
                            </div>
                            <a href="{{ route('products.show', $related->slug) }}" class="w-full bg-primary text-white py-2 rounded hover:bg-primary/90 transition block text-center font-semibold text-sm">
                                View
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif
</div>

<script>
    function incrementQty() {
        const qty = document.getElementById('quantity');
        if (parseInt(qty.value) < 10) {
            qty.value = parseInt(qty.value) + 1;
        }
    }

    function decrementQty() {
        const qty = document.getElementById('quantity');
        if (parseInt(qty.value) > 1) {
            qty.value = parseInt(qty.value) - 1;
        }
    }
</script>
@endsection
