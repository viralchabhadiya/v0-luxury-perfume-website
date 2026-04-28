<header class="bg-white shadow-sm sticky top-0 z-50">
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
        <div class="flex items-center space-x-8">
            <a href="{{ route('home') }}" class="text-2xl font-bold text-primary">
                Patel Perfumes
            </a>
            <div class="hidden md:flex space-x-6">
                <a href="{{ route('home') }}" class="text-dark hover:text-primary transition">Home</a>
                <a href="{{ route('products.index') }}" class="text-dark hover:text-primary transition">Products</a>
                <a href="#" class="text-dark hover:text-primary transition">About</a>
                <a href="#" class="text-dark hover:text-primary transition">Contact</a>
            </div>
        </div>
        <div class="flex items-center space-x-4">
            <a href="{{ route('cart.index') }}" class="relative">
                <svg class="w-6 h-6 text-dark hover:text-primary transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <span class="absolute -top-2 -right-2 bg-accent text-dark text-xs rounded-full w-5 h-5 flex items-center justify-center">0</span>
            </a>
            @if(auth()->check())
                <a href="#" class="text-dark hover:text-primary transition">Account</a>
            @else
                <a href="#" class="text-dark hover:text-primary transition">Login</a>
            @endif
        </div>
    </nav>
</header>
