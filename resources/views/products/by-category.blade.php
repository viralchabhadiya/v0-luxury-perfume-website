@extends('layouts.app')

@section('title', $category->name . ' - Patel Perfumes')

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-b from-secondary to-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold text-primary mb-2">{{ $category->name }}</h1>
        @if($category->description)
            <p class="text-lg text-dark/60">{{ $category->description }}</p>
        @endif
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        <!-- Sidebar -->
        <aside class="md:col-span-1">
            <div data-scroll-fade style="opacity: 0; transform: translateX(-30px);" class="bg-white p-6 rounded-lg shadow sticky top-24">
                <h3 class="text-lg font-bold text-primary mb-4">Categories</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('products.index') }}" class="text-dark hover:text-primary transition">All Products</a></li>
                    <li><a href="{{ route('products.by-category', $category->slug) }}" class="text-primary font-bold">{{ $category->name }}</a></li>
                </ul>

                <h3 class="text-lg font-bold text-primary mt-8 mb-4">Sort By</h3>
                <select class="w-full px-3 py-2 border border-dark/20 rounded text-dark">
                    <option>Newest</option>
                    <option>Price: Low to High</option>
                    <option>Price: High to Low</option>
                    <option>Most Popular</option>
                </select>
            </div>
        </aside>

        <!-- Products Grid -->
        <div class="md:col-span-3">
            <div class="mb-6">
                <p class="text-dark/60">Showing {{ $products->count() }} products</p>
            </div>

            <div data-scroll-stagger class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($products as $product)
                    <div data-stagger-item style="opacity: 0; transform: translateY(30px);" class="bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition duration-300 group">
                        <div class="relative h-48 bg-gradient-to-br from-accent/20 to-primary/20 flex items-center justify-center overflow-hidden">
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition duration-300"></div>
                            <span class="text-5xl">🧴</span>
                            @if($product->discount_price)
                                <div class="absolute top-4 right-4 bg-accent text-dark text-sm font-bold px-3 py-1 rounded">
                                    -{{ $product->discount_percentage }}%
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="text-lg font-bold text-primary mb-2 truncate">{{ $product->name }}</h3>
                            <p class="text-dark/60 text-sm mb-3 line-clamp-2">{{ $product->description }}</p>
                            
                            <div class="mb-3">
                                <p class="text-sm text-dark/70 mb-1">
                                    <span class="font-semibold">Volume:</span> {{ $product->volume }}
                                </p>
                                <p class="text-sm text-dark/70">
                                    <span class="font-semibold">Scent:</span> {{ $product->scent_profile }}
                                </p>
                            </div>

                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    @if($product->discount_price)
                                        <span class="text-lg font-bold text-accent">${{ $product->discount_price }}</span>
                                        <span class="text-sm text-dark/40 line-through ml-2">${{ $product->price }}</span>
                                    @else
                                        <span class="text-lg font-bold text-primary">${{ $product->price }}</span>
                                    @endif
                                </div>
                            </div>
                            
                            <a href="{{ route('products.show', $product->slug) }}" class="w-full bg-primary text-white py-2 rounded hover:bg-primary/90 transition block text-center font-semibold text-sm">
                                View Details
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-12">
                        <p class="text-dark/60 text-lg">No products in this category yet.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
                <div class="mt-12">
                    <div class="flex justify-center gap-2">
                        @if($products->onFirstPage())
                            <span class="px-4 py-2 bg-dark/20 text-dark/50 rounded">← Previous</span>
                        @else
                            <a href="{{ $products->previousPageUrl() }}" class="px-4 py-2 bg-primary text-white rounded hover:bg-primary/90">← Previous</a>
                        @endif

                        @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                            @if ($page == $products->currentPage())
                                <span class="px-4 py-2 bg-primary text-white rounded">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="px-4 py-2 bg-primary/20 text-primary rounded hover:bg-primary hover:text-white">{{ $page }}</a>
                            @endif
                        @endforeach

                        @if($products->hasMorePages())
                            <a href="{{ $products->nextPageUrl() }}" class="px-4 py-2 bg-primary text-white rounded hover:bg-primary/90">Next →</a>
                        @else
                            <span class="px-4 py-2 bg-dark/20 text-dark/50 rounded">Next →</span>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
