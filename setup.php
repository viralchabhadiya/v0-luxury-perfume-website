<?php

// Database Setup and Seeding Script
echo "=== Patel Perfumes Setup ===\n\n";

define('BASEPATH', __DIR__);
define('DATABASEPATH', BASEPATH . '/database');

// Create SQLite database
$dbPath = DATABASEPATH . '/patel_perfumes.db';
if (!file_exists($dbPath)) {
    touch($dbPath);
    echo "✓ Database file created\n";
}

$pdo = new PDO('sqlite:' . $dbPath);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Create tables
echo "Creating tables...\n";

// Users table
$pdo->exec("
    CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        phone VARCHAR(20),
        address VARCHAR(255),
        city VARCHAR(100),
        state VARCHAR(100),
        postal_code VARCHAR(20),
        country VARCHAR(100),
        is_admin BOOLEAN DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
");
echo "✓ Users table created\n";

// Categories table
$pdo->exec("
    CREATE TABLE IF NOT EXISTS categories (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name VARCHAR(255) NOT NULL,
        slug VARCHAR(255) UNIQUE NOT NULL,
        description TEXT,
        image_url VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
");
echo "✓ Categories table created\n";

// Products table
$pdo->exec("
    CREATE TABLE IF NOT EXISTS products (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name VARCHAR(255) NOT NULL,
        slug VARCHAR(255) UNIQUE NOT NULL,
        description TEXT,
        long_description TEXT,
        price DECIMAL(10, 2) NOT NULL,
        discount_price DECIMAL(10, 2),
        category_id INTEGER NOT NULL,
        image_url VARCHAR(255),
        gallery_images JSON,
        volume VARCHAR(100),
        scent_profile VARCHAR(255),
        longevity VARCHAR(100),
        projection VARCHAR(100),
        notes JSON,
        in_stock BOOLEAN DEFAULT 1,
        is_featured BOOLEAN DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY(category_id) REFERENCES categories(id)
    )
");
echo "✓ Products table created\n";

// Orders table
$pdo->exec("
    CREATE TABLE IF NOT EXISTS orders (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL,
        order_number VARCHAR(255) UNIQUE NOT NULL,
        subtotal DECIMAL(10, 2) NOT NULL,
        tax DECIMAL(10, 2) NOT NULL,
        total DECIMAL(10, 2) NOT NULL,
        status VARCHAR(50) DEFAULT 'pending',
        payment_method VARCHAR(100),
        shipping_address JSON,
        billing_address JSON,
        notes TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY(user_id) REFERENCES users(id)
    )
");
echo "✓ Orders table created\n";

// Order Items table
$pdo->exec("
    CREATE TABLE IF NOT EXISTS order_items (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        order_id INTEGER NOT NULL,
        product_id INTEGER NOT NULL,
        quantity INTEGER NOT NULL,
        price DECIMAL(10, 2) NOT NULL,
        subtotal DECIMAL(10, 2) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY(order_id) REFERENCES orders(id),
        FOREIGN KEY(product_id) REFERENCES products(id)
    )
");
echo "✓ Order Items table created\n";

// Seed data
echo "\nSeeding sample data...\n";

// Create admin user
$adminPassword = password_hash('admin123', PASSWORD_BCRYPT);
try {
    $pdo->exec("INSERT INTO users (name, email, password, phone, is_admin) VALUES ('Admin', 'admin@patelperfumes.com', '$adminPassword', '1-800-PERFUME', 1)");
    echo "✓ Admin user created (email: admin@patelperfumes.com, password: admin123)\n";
} catch (Exception $e) {
    echo "  Admin user might already exist\n";
}

// Create categories
$categories = [
    ['name' => 'Men', 'slug' => 'men', 'description' => 'Premium fragrances for men'],
    ['name' => 'Women', 'slug' => 'women', 'description' => 'Elegant fragrances for women'],
    ['name' => 'Unisex', 'slug' => 'unisex', 'description' => 'Versatile fragrances for everyone'],
    ['name' => 'Limited Edition', 'slug' => 'limited-edition', 'description' => 'Exclusive and rare fragrances'],
];

foreach ($categories as $cat) {
    try {
        $stmt = $pdo->prepare("INSERT INTO categories (name, slug, description) VALUES (?, ?, ?)");
        $stmt->execute([$cat['name'], $cat['slug'], $cat['description']]);
    } catch (Exception $e) {
        // Category might already exist
    }
}
echo "✓ Categories seeded\n";

// Get category IDs for products
$categories = $pdo->query("SELECT id, name FROM categories")->fetchAll(PDO::FETCH_ASSOC);
$menCatId = $categories[0]['id'] ?? 1;
$womenCatId = $categories[1]['id'] ?? 2;

// Create sample products
$products = [
    [
        'name' => 'Midnight Elegance',
        'slug' => 'midnight-elegance',
        'description' => 'A sophisticated blend of dark woods and musk',
        'long_description' => 'Midnight Elegance is a timeless fragrance that captures the essence of sophistication. With notes of vetiver, cedarwood, and soft musk, it creates an aura of confidence and mystery. Perfect for evening events and special occasions.',
        'price' => 89.99,
        'discount_price' => 69.99,
        'category_id' => $menCatId,
        'volume' => '100ml',
        'scent_profile' => 'Woody',
        'longevity' => '8-10 hours',
        'projection' => 'Strong',
        'notes' => '["Vetiver", "Cedarwood", "Musk"]'
    ],
    [
        'name' => 'Rose Garden',
        'slug' => 'rose-garden',
        'description' => 'Delicate floral notes with a hint of sweetness',
        'long_description' => 'Experience the beauty of a blooming rose garden with this exquisite fragrance. Featuring top notes of pink pepper, heart notes of damask rose, and base notes of sandalwood, it\'s a romantic and elegant choice.',
        'price' => 79.99,
        'discount_price' => null,
        'category_id' => $womenCatId,
        'volume' => '50ml',
        'scent_profile' => 'Floral',
        'longevity' => '6-8 hours',
        'projection' => 'Moderate',
        'notes' => '["Pink Pepper", "Damask Rose", "Sandalwood"]'
    ],
    [
        'name' => 'Ocean Breeze',
        'slug' => 'ocean-breeze',
        'description' => 'Fresh and invigorating marine scent',
        'long_description' => 'Transport yourself to a coastal paradise with Ocean Breeze. This fresh unisex fragrance combines aquatic notes with hints of citrus and driftwood, creating a refreshing and uplifting experience.',
        'price' => 74.99,
        'discount_price' => 54.99,
        'category_id' => $menCatId,
        'volume' => '100ml',
        'scent_profile' => 'Fresh',
        'longevity' => '5-7 hours',
        'projection' => 'Moderate',
        'notes' => '["Bergamot", "Aquatic Notes", "Driftwood"]',
        'is_featured' => 1
    ],
    [
        'name' => 'Amber Sunset',
        'slug' => 'amber-sunset',
        'description' => 'Warm amber with hints of vanilla and spice',
        'long_description' => 'Amber Sunset is a luxurious fragrance that embodies warmth and comfort. With rich amber, creamy vanilla, and subtle spice notes, it\'s perfect for creating an intimate and memorable impression.',
        'price' => 84.99,
        'discount_price' => null,
        'category_id' => $womenCatId,
        'volume' => '75ml',
        'scent_profile' => 'Oriental',
        'longevity' => '10+ hours',
        'projection' => 'Strong',
        'notes' => '["Cinnamon", "Amber", "Vanilla"]',
        'is_featured' => 1
    ],
    [
        'name' => 'Citrus Paradise',
        'slug' => 'citrus-paradise',
        'description' => 'Vibrant citrus blend perfect for daytime',
        'long_description' => 'Citrus Paradise is an energizing fragrance that features bright notes of grapefruit, lemon, and lime balanced with subtle musky undertones. Ideal for everyday wear and making a fresh impression.',
        'price' => 69.99,
        'discount_price' => null,
        'category_id' => $menCatId,
        'volume' => '100ml',
        'scent_profile' => 'Citrus',
        'longevity' => '5-6 hours',
        'projection' => 'Moderate',
        'notes' => '["Grapefruit", "Lemon", "Musk"]',
        'is_featured' => 1
    ],
    [
        'name' => 'Jasmine Dreams',
        'slug' => 'jasmine-dreams',
        'description' => 'Enchanting jasmine and white florals',
        'long_description' => 'Jasmine Dreams captures the essence of a moonlit garden. Featuring beautiful jasmine combined with tuberose and a whisper of gardenia, this fragrance is pure romance in a bottle.',
        'price' => 94.99,
        'discount_price' => 74.99,
        'category_id' => $womenCatId,
        'volume' => '50ml',
        'scent_profile' => 'Floral',
        'longevity' => '8-9 hours',
        'projection' => 'Moderate',
        'notes' => '["Jasmine", "Tuberose", "Gardenia"]',
        'is_featured' => 1
    ],
];

foreach ($products as $prod) {
    try {
        $stmt = $pdo->prepare("
            INSERT INTO products (name, slug, description, long_description, price, discount_price, category_id, volume, scent_profile, longevity, projection, notes, is_featured, in_stock)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)
        ");
        $stmt->execute([
            $prod['name'],
            $prod['slug'],
            $prod['description'],
            $prod['long_description'],
            $prod['price'],
            $prod['discount_price'],
            $prod['category_id'],
            $prod['volume'],
            $prod['scent_profile'],
            $prod['longevity'],
            $prod['projection'],
            $prod['notes'],
            $prod['is_featured'] ?? 0
        ]);
    } catch (Exception $e) {
        // Product might already exist
    }
}
echo "✓ Sample products seeded\n";

echo "\n=== Setup Complete ===\n";
echo "Database: " . $dbPath . "\n";
echo "\nYou can now run: php -S localhost:8000 -t public\n";
echo "Then visit http://localhost:8000 in your browser\n";
