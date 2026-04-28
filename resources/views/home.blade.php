@extends('layouts.app')

@section('title', 'Home - Patel Perfumes')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-b from-secondary to-white py-20 overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-96 h-96 bg-primary rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-accent rounded-full blur-3xl"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div data-scroll-fade style="opacity: 0; transform: translateY(30px);">
                <h1 class="text-5xl md:text-6xl font-bold text-primary mb-4 leading-tight">
                    Timeless Elegance in Every Spray
                </h1>
                <p class="text-lg text-dark/70 mb-6">
                    Discover our curated collection of luxury fragrances that tell your unique story. From classic to contemporary, find the perfect scent.
                </p>
                <div class="flex space-x-4">
                    <a href="{{ route('products.index') }}" class="bg-primary text-white px-8 py-3 rounded hover:bg-primary/90 transition font-semibold">
                        Shop Now
                    </a>
                    <a href="#featured" class="border-2 border-primary text-primary px-8 py-3 rounded hover:bg-primary/5 transition font-semibold">
                        Explore Collections
                    </a>
                </div>
            </div>
            
            <div data-scroll-scale style="opacity: 0; transform: scale(0.9);" class="relative h-96 md:h-full">
                <div class="absolute inset-0 bg-gradient-to-br from-accent via-primary/20 to-transparent rounded-lg"></div>
                <div class="absolute inset-4 flex items-center justify-center text-white/30 text-6xl font-light">
                    🧴
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section id="featured" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div data-scroll-fade style="opacity: 0; transform: translateY(30px);" class="text-center mb-16">
            <h2 class="text-4xl font-bold text-primary mb-4">Featured Collections</h2>
            <p class="text-lg text-dark/60">Hand-picked fragrances for every occasion</p>
        </div>

        <div data-scroll-stagger class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($featuredProducts as $product)
                <div data-stagger-item style="opacity: 0; transform: translateY(30px);" class="bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition duration-300">
                    <div class="relative h-64 bg-gradient-to-br from-accent/20 to-primary/20 flex items-center justify-center overflow-hidden group">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition duration-300"></div>
                        <span class="text-6xl">🧴</span>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-primary mb-2">{{ $product->name }}</h3>
                        <p class="text-dark/60 text-sm mb-4">{{ substr($product->description, 0, 60) }}...</p>
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                @if($product->discount_price)
                                    <span class="text-lg font-bold text-accent">${{ $product->discount_price }}</span>
                                    <span class="text-sm text-dark/40 line-through ml-2">${{ $product->price }}</span>
                                @else
                                    <span class="text-lg font-bold text-primary">${{ $product->price }}</span>
                                @endif
                            </div>
                            @if($product->discount_price)
                                <span class="bg-accent text-dark text-xs font-bold px-3 py-1 rounded">
                                    -{{ $product->discount_percentage }}%
                                </span>
                            @endif
                        </div>
                        <a href="{{ route('products.show', $product->slug) }}" class="w-full bg-primary text-white py-2 rounded hover:bg-primary/90 transition block text-center font-semibold">
                            View Details
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12">
                    <p class="text-dark/60">No featured products yet.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="py-20 bg-primary text-secondary">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div data-scroll-fade style="opacity: 0; transform: translateY(30px);" class="text-center mb-16">
            <h2 class="text-4xl font-bold mb-4">Why Choose Patel Perfumes?</h2>
            <p class="text-lg text-secondary/80">Experience luxury that's crafted to perfection</p>
        </div>

        <div data-scroll-stagger class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div data-stagger-item style="opacity: 0; transform: translateY(30px);" class="text-center">
                <div class="text-5xl mb-4">✨</div>
                <h3 class="text-xl font-bold mb-2">Premium Quality</h3>
                <p class="text-secondary/80">Only the finest fragrances sourced globally</p>
            </div>
            <div data-stagger-item style="opacity: 0; transform: translateY(30px);" class="text-center">
                <div class="text-5xl mb-4">🚚</div>
                <h3 class="text-xl font-bold mb-2">Fast Shipping</h3>
                <p class="text-secondary/80">Delivered to your door within 5-7 business days</p>
            </div>
            <div data-stagger-item style="opacity: 0; transform: translateY(30px);" class="text-center">
                <div class="text-5xl mb-4">💰</div>
                <h3 class="text-xl font-bold mb-2">Best Prices</h3>
                <p class="text-secondary/80">Competitive pricing without compromising quality</p>
            </div>
            <div data-stagger-item style="opacity: 0; transform: translateY(30px);" class="text-center">
                <div class="text-5xl mb-4">🛡️</div>
                <h3 class="text-xl font-bold mb-2">Guaranteed Authenticity</h3>
                <p class="text-secondary/80">All products are 100% authentic and original</p>
            </div>
        </div>
    </div>
</section>

<!-- Statistics -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div data-scroll-fade style="opacity: 0; transform: translateY(30px);" class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
            <div>
                <div class="text-5xl font-bold text-accent mb-2">
                    <span data-counter="50000">0</span>+
                </div>
                <p class="text-dark/60 font-semibold">Happy Customers</p>
            </div>
            <div>
                <div class="text-5xl font-bold text-primary mb-2">
                    <span data-counter="500">0</span>+
                </div>
                <p class="text-dark/60 font-semibold">Fragrances</p>
            </div>
            <div>
                <div class="text-5xl font-bold text-accent mb-2">
                    <span data-counter="98">0</span>%
                </div>
                <p class="text-dark/60 font-semibold">Satisfaction Rate</p>
            </div>
            <div>
                <div class="text-5xl font-bold text-primary mb-2">
                    <span data-counter="20">0</span>+
                </div>
                <p class="text-dark/60 font-semibold">Years in Business</p>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter CTA -->
<section class="py-16 bg-gradient-to-r from-primary to-primary/80">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div data-scroll-fade style="opacity: 0; transform: translateY(30px);">
            <h2 class="text-3xl font-bold text-secondary mb-4">Subscribe to Our Newsletter</h2>
            <p class="text-secondary/80 mb-6">Get exclusive offers, new releases, and fragrance tips delivered to your inbox.</p>
            <form class="flex flex-col sm:flex-row gap-3">
                <input type="email" placeholder="Enter your email" class="flex-1 px-4 py-3 rounded text-dark" required>
                <button type="submit" class="bg-accent text-dark px-8 py-3 rounded font-bold hover:bg-secondary transition">
                    Subscribe
                </button>
            </form>
        </div>
    </div>
</section>
@endsection
