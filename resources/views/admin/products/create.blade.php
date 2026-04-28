@extends('admin.layouts.app')

@section('page-title', 'Create Product')

@section('content')
<div class="mb-8">
    <a href="/admin/products" class="text-primary hover:underline font-semibold">← Back to Products</a>
</div>

<div class="bg-white rounded-lg shadow p-8 max-w-2xl">
    <h2 class="text-3xl font-bold text-primary mb-8">Add New Product</h2>

    <form action="/admin/products" method="POST" class="space-y-6">
        @csrf

        <div>
            <label for="name" class="block text-sm font-bold text-dark mb-2">Product Name *</label>
            <input type="text" id="name" name="name" required class="w-full px-4 py-2 border border-dark/20 rounded focus:outline-none focus:ring-2 focus:ring-primary" value="{{ old('name') }}">
            @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="description" class="block text-sm font-bold text-dark mb-2">Short Description *</label>
            <textarea id="description" name="description" rows="3" required class="w-full px-4 py-2 border border-dark/20 rounded focus:outline-none focus:ring-2 focus:ring-primary">{{ old('description') }}</textarea>
            @error('description') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="long_description" class="block text-sm font-bold text-dark mb-2">Long Description *</label>
            <textarea id="long_description" name="long_description" rows="5" required class="w-full px-4 py-2 border border-dark/20 rounded focus:outline-none focus:ring-2 focus:ring-primary">{{ old('long_description') }}</textarea>
            @error('long_description') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="price" class="block text-sm font-bold text-dark mb-2">Price *</label>
                <input type="number" id="price" name="price" step="0.01" required class="w-full px-4 py-2 border border-dark/20 rounded focus:outline-none focus:ring-2 focus:ring-primary" value="{{ old('price') }}">
                @error('price') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="discount_price" class="block text-sm font-bold text-dark mb-2">Discount Price</label>
                <input type="number" id="discount_price" name="discount_price" step="0.01" class="w-full px-4 py-2 border border-dark/20 rounded focus:outline-none focus:ring-2 focus:ring-primary" value="{{ old('discount_price') }}">
                @error('discount_price') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label for="category_id" class="block text-sm font-bold text-dark mb-2">Category *</label>
            <select id="category_id" name="category_id" required class="w-full px-4 py-2 border border-dark/20 rounded focus:outline-none focus:ring-2 focus:ring-primary">
                <option value="">Select a category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="volume" class="block text-sm font-bold text-dark mb-2">Volume *</label>
                <input type="text" id="volume" name="volume" placeholder="e.g., 100ml" required class="w-full px-4 py-2 border border-dark/20 rounded focus:outline-none focus:ring-2 focus:ring-primary" value="{{ old('volume') }}">
                @error('volume') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="scent_profile" class="block text-sm font-bold text-dark mb-2">Scent Profile *</label>
                <input type="text" id="scent_profile" name="scent_profile" placeholder="e.g., Floral" required class="w-full px-4 py-2 border border-dark/20 rounded focus:outline-none focus:ring-2 focus:ring-primary" value="{{ old('scent_profile') }}">
                @error('scent_profile') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="longevity" class="block text-sm font-bold text-dark mb-2">Longevity *</label>
                <input type="text" id="longevity" name="longevity" placeholder="e.g., 8-10 hours" required class="w-full px-4 py-2 border border-dark/20 rounded focus:outline-none focus:ring-2 focus:ring-primary" value="{{ old('longevity') }}">
                @error('longevity') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="projection" class="block text-sm font-bold text-dark mb-2">Projection *</label>
                <input type="text" id="projection" name="projection" placeholder="e.g., Moderate" required class="w-full px-4 py-2 border border-dark/20 rounded focus:outline-none focus:ring-2 focus:ring-primary" value="{{ old('projection') }}">
                @error('projection') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="flex items-center">
                <input type="checkbox" name="in_stock" value="1" {{ old('in_stock') ? 'checked' : '' }} class="w-4 h-4 text-primary">
                <span class="ml-2 text-dark font-semibold">In Stock</span>
            </label>
        </div>

        <div>
            <label class="flex items-center">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="w-4 h-4 text-primary">
                <span class="ml-2 text-dark font-semibold">Featured Product</span>
            </label>
        </div>

        <div class="flex gap-4 pt-4">
            <button type="submit" class="flex-1 bg-primary text-white py-3 rounded font-bold hover:bg-primary/90 transition">
                Create Product
            </button>
            <a href="/admin/products" class="flex-1 bg-dark/10 text-dark py-3 rounded font-bold hover:bg-dark/20 transition text-center">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
