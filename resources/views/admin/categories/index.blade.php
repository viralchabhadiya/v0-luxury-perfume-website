@extends('admin.layouts.app')

@section('page-title', 'Categories Management')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div>
        <h2 class="text-3xl font-bold text-primary mb-2">Categories</h2>
        <p class="text-dark/60">Manage product categories</p>
    </div>
    <a href="/admin/categories/create" class="bg-primary text-white px-6 py-3 rounded font-bold hover:bg-primary/90 transition">
        + Add Category
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
                    <th class="px-6 py-4 text-left text-sm font-bold">Category Name</th>
                    <th class="px-6 py-4 text-left text-sm font-bold">Description</th>
                    <th class="px-6 py-4 text-center text-sm font-bold">Products</th>
                    <th class="px-6 py-4 text-center text-sm font-bold">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr class="border-b border-dark/10 hover:bg-secondary/20 transition">
                        <td class="px-6 py-4">
                            <div class="font-bold text-dark">{{ $category->name }}</div>
                            <div class="text-sm text-dark/60">{{ $category->slug }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-dark/70">{{ substr($category->description, 0, 50) }}...</p>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="font-bold text-primary">{{ $category->products()->count() }}</span>
                        </td>
                        <td class="px-6 py-4 text-center space-x-2">
                            <a href="/admin/categories/{{ $category->id }}/edit" class="text-blue-600 hover:underline text-sm font-semibold">Edit</a>
                            <form method="POST" action="/admin/categories/{{ $category->id }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline text-sm font-semibold" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-dark/60">
                            <p class="mb-4">No categories yet. Create your first category.</p>
                            <a href="/admin/categories/create" class="text-primary hover:underline font-semibold">Create Category</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($categories->hasPages())
        <div class="px-6 py-4 border-t border-dark/10 flex justify-center gap-2">
            @if($categories->onFirstPage())
                <span class="px-3 py-2 bg-dark/10 text-dark/50 rounded">Previous</span>
            @else
                <a href="{{ $categories->previousPageUrl() }}" class="px-3 py-2 bg-primary text-white rounded hover:bg-primary/90">Previous</a>
            @endif

            @foreach ($categories->getUrlRange(1, $categories->lastPage()) as $page => $url)
                @if ($page == $categories->currentPage())
                    <span class="px-3 py-2 bg-primary text-white rounded">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="px-3 py-2 bg-dark/10 text-dark rounded hover:bg-primary hover:text-white">{{ $page }}</a>
                @endif
            @endforeach

            @if($categories->hasMorePages())
                <a href="{{ $categories->nextPageUrl() }}" class="px-3 py-2 bg-primary text-white rounded hover:bg-primary/90">Next</a>
            @else
                <span class="px-3 py-2 bg-dark/10 text-dark/50 rounded">Next</span>
            @endif
        </div>
    @endif
</div>
@endsection
