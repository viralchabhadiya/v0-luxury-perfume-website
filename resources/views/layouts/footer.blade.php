<footer class="bg-primary text-secondary py-12 mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
            <div>
                <h3 class="text-lg font-bold mb-4">Patel Perfumes</h3>
                <p class="text-secondary/80">Discover the art of fragrance with our luxury collection curated for the discerning.</p>
            </div>
            <div>
                <h4 class="font-bold mb-4">Quick Links</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" class="hover:text-accent transition">Home</a></li>
                    <li><a href="{{ route('products.index') }}" class="hover:text-accent transition">Products</a></li>
                    <li><a href="#" class="hover:text-accent transition">About Us</a></li>
                    <li><a href="#" class="hover:text-accent transition">Contact</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold mb-4">Support</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="hover:text-accent transition">FAQ</a></li>
                    <li><a href="#" class="hover:text-accent transition">Shipping</a></li>
                    <li><a href="#" class="hover:text-accent transition">Returns</a></li>
                    <li><a href="#" class="hover:text-accent transition">Privacy Policy</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold mb-4">Newsletter</h4>
                <p class="text-secondary/80 mb-3">Subscribe for exclusive offers and new releases.</p>
                <form class="flex">
                    <input type="email" placeholder="Your email" class="flex-1 px-3 py-2 text-dark">
                    <button type="submit" class="bg-accent text-dark px-4 py-2 hover:bg-secondary transition">Subscribe</button>
                </form>
            </div>
        </div>
        <div class="border-t border-primary/30 pt-8 text-center text-secondary/70">
            <p>&copy; 2024 Patel Perfumes. All rights reserved.</p>
        </div>
    </div>
</footer>
