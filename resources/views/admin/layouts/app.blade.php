<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - Patel Perfumes')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --primary: #8B6F47;
            --secondary: #F5E6D3;
            --accent: #D4AF37;
            --dark: #2C2C2C;
            --light: #FAFAF8;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--dark);
            background-color: var(--light);
        }

        .text-primary { color: var(--primary); }
        .bg-primary { background-color: var(--primary); }
        .text-accent { color: var(--accent); }
        .bg-accent { background-color: var(--accent); }
    </style>
    @yield('styles')
</head>
<body>
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-primary text-secondary shadow-lg">
            <div class="p-6 border-b border-primary/50">
                <h1 class="text-2xl font-bold">Admin Panel</h1>
                <p class="text-secondary/80 text-sm">Patel Perfumes</p>
            </div>

            <nav class="p-4 space-y-2">
                <a href="/admin/dashboard" class="block px-4 py-3 rounded hover:bg-primary/80 transition">Dashboard</a>
                <a href="/admin/products" class="block px-4 py-3 rounded hover:bg-primary/80 transition">Products</a>
                <a href="/admin/categories" class="block px-4 py-3 rounded hover:bg-primary/80 transition">Categories</a>
                <a href="/admin/orders" class="block px-4 py-3 rounded hover:bg-primary/80 transition">Orders</a>
                <a href="/admin/customers" class="block px-4 py-3 rounded hover:bg-primary/80 transition">Customers</a>
            </nav>

            <div class="p-4 border-t border-primary/50 absolute bottom-0 w-64">
                <a href="/" class="block px-4 py-3 rounded bg-primary/80 hover:bg-primary text-center transition font-semibold">
                    Back to Store
                </a>
                <a href="/logout" class="block px-4 py-3 rounded hover:bg-primary/80 transition text-center mt-2">
                    Logout
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col">
            <!-- Top Bar -->
            <header class="bg-white shadow sticky top-0 z-40">
                <div class="max-w-full mx-auto px-8 py-4 flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-primary">@yield('page-title', 'Dashboard')</h1>
                    <div class="flex items-center space-x-4">
                        <span class="text-dark/60">Admin</span>
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold">A</div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="flex-1 overflow-auto">
                <div class="max-w-full mx-auto px-8 py-8">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>

    @yield('scripts')
</body>
</html>
