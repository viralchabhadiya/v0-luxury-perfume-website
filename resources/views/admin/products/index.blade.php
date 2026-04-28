@extends('admin.layouts.app')

@section('page-title', 'Products Management')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div>
        <h2 class="text-3xl font-bold text-primary mb-2">Products</h2>
        <p class="text-dark/60">Manage your product inventory</p>
    </div>
    <a href="/admin/products/create" class="bg-primary text-white px-6 py-3 rounded font-bold hover:bg-primary/90 transition">
        + Add Product
    </a>
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-primary text-white">
                    <th class="px-6 py-4 text-left text-sm font-bold">Product Name</th>
                    <th class="px-6 py-4 text-left text-sm font-bold">Category</th>
                    <th class="px-6 py-4 text-right text-sm font-bold">Price</th>
                    <th class="px-6 py-4 text-center text-sm font-bold">Stock</th>
                    <th class="px-6 py-4 text-center text-sm font-bold">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr class="border-b border-dark/10 hover:bg-secondary/20 transition">
                        <td class="px-6 py-4">
                            <div class="font-bold text-dark">{{ $product->name }}</div>
                            <div class="text-sm text-dark/60">{{ $product->slug }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="bg-secondary text-primary px-3 py-1 rounded text-sm font-semibold">
                                {{ $product->category?->name ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            @if($product->discount_price)
                                <div class="font-bold text-accent">${{ $product->discount_price }}</div>
                                <div class="text-sm text-dark/40 line-through">${{ $product->price }}</div>
                            @else
                                <div class="font-bold text-primary">${{ $product->price }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($product->in_stock)
                                <span class="text-green-600 font-bold">In Stock</span>
                            @else
                                <span class="text-red-600 font-bold">Out</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center space-x-2">
                            <a href="/admin/products/{{ $product->id }}/edit" class="text-blue-600 hover:underline text-sm font-semibold">Edit</a>
                            <form method="POST" action="/admin/products/{{ $product->id }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline text-sm font-semibold" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-dark/60">
                            <p class="mb-4">No products yet. Create your first product to get started.</p>
                            <a href="/admin/products/create" class="text-primary hover:underline font-semibold">Create Product</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
        <div class="px-6 py-4 border-t border-dark/10 flex justify-center gap-2">
            @if($products->onFirstPage())
                <span class="px-3 py-2 bg-dark/10 text-dark/50 rounded">Previous</span>
            @else
                <a href="{{ $products->previousPageUrl() }}" class="px-3 py-2 bg-primary text-white rounded hover:bg-primary/90">Previous</a>
            @endif

            @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                @if ($page == $products->currentPage())
                    <span class="px-3 py-2 bg-primary text-white rounded">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="px-3 py-2 bg-dark/10 text-dark rounded hover:bg-primary hover:text-white">{{ $page }}</a>
                @endif
            @endforeach

            @if($products->hasMorePages())
                <a href="{{ $products->nextPageUrl() }}" class="px-3 py-2 bg-primary text-white rounded hover:bg-primary/90">Next</a>
            @else
                <span class="px-3 py-2 bg-dark/10 text-dark/50 rounded">Next</span>
            @endif
        </div>
    @endif
</div>
@endsection
