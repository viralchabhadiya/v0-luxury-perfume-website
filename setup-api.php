<?php
/**
 * Patel Perfumes - Setup API
 * Handles database creation, migrations, and configuration
 */

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

try {
    // Get POST data
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!$data) {
        throw new Exception('No setup data provided');
    }
    
    // Step 1: Create database
    createDatabase();
    
    // Step 2: Run migrations
    runMigrations();
    
    // Step 3: Create admin user
    createAdminUser($data['adminEmail'], $data['adminUsername'], $data['adminPassword'], $data['adminName']);
    
    // Step 4: Update .env file
    updateEnvFile($data);
    
    // Step 5: Seed sample data
    seedDatabase();
    
    // Step 6: Create settings records
    createSettings($data);
    
    echo json_encode(['success' => true, 'message' => 'Setup completed successfully']);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

function createDatabase() {
    $dbPath = __DIR__ . '/database/patel_perfumes.db';
    
    // Create database if it doesn't exist
    if (!file_exists($dbPath)) {
        touch($dbPath);
    }
    
    // Test connection
    $pdo = new PDO('sqlite:' . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec('PRAGMA foreign_keys = ON');
    
    return $pdo;
}

function runMigrations() {
    $pdo = new PDO('sqlite:' . __DIR__ . '/database/patel_perfumes.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec('PRAGMA foreign_keys = ON');
    
    // Users table
    $pdo->exec('
        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            role VARCHAR(50) DEFAULT "customer",
            is_active BOOLEAN DEFAULT 1,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ');
    
    // Categories table
    $pdo->exec('
        CREATE TABLE IF NOT EXISTS categories (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name VARCHAR(255) NOT NULL,
            slug VARCHAR(255) UNIQUE NOT NULL,
            description TEXT,
            image VARCHAR(255),
            is_active BOOLEAN DEFAULT 1,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ');
    
    // Products table
    $pdo->exec('
        CREATE TABLE IF NOT EXISTS products (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            category_id INTEGER NOT NULL,
            name VARCHAR(255) NOT NULL,
            slug VARCHAR(255) UNIQUE NOT NULL,
            description TEXT,
            short_description VARCHAR(500),
            price DECIMAL(10, 2) NOT NULL,
            discount_price DECIMAL(10, 2),
            volume VARCHAR(50),
            scent_type VARCHAR(100),
            longevity VARCHAR(100),
            projection VARCHAR(100),
            top_notes TEXT,
            heart_notes TEXT,
            base_notes TEXT,
            image VARCHAR(255),
            images TEXT,
            sku VARCHAR(100) UNIQUE,
            stock INTEGER DEFAULT 0,
            is_featured BOOLEAN DEFAULT 0,
            is_active BOOLEAN DEFAULT 1,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
        )
    ');
    
    // Orders table
    $pdo->exec('
        CREATE TABLE IF NOT EXISTS orders (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER,
            order_number VARCHAR(100) UNIQUE NOT NULL,
            customer_name VARCHAR(255) NOT NULL,
            customer_email VARCHAR(255) NOT NULL,
            customer_phone VARCHAR(20),
            shipping_address TEXT NOT NULL,
            billing_address TEXT,
            total_amount DECIMAL(10, 2) NOT NULL,
            discount_amount DECIMAL(10, 2) DEFAULT 0,
            tax_amount DECIMAL(10, 2) DEFAULT 0,
            shipping_amount DECIMAL(10, 2) DEFAULT 0,
            payment_method VARCHAR(50),
            payment_status VARCHAR(50) DEFAULT "pending",
            order_status VARCHAR(50) DEFAULT "pending",
            notes TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
        )
    ');
    
    // Order items table
    $pdo->exec('
        CREATE TABLE IF NOT EXISTS order_items (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            order_id INTEGER NOT NULL,
            product_id INTEGER NOT NULL,
            product_name VARCHAR(255) NOT NULL,
            quantity INTEGER NOT NULL,
            unit_price DECIMAL(10, 2) NOT NULL,
            total_price DECIMAL(10, 2) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
        )
    ');
    
    // Notifications table
    $pdo->exec('
        CREATE TABLE IF NOT EXISTS notifications (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER,
            type VARCHAR(50) NOT NULL,
            title VARCHAR(255) NOT NULL,
            message TEXT NOT NULL,
            read_at TIMESTAMP,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        )
    ');
    
    // Communication logs table
    $pdo->exec('
        CREATE TABLE IF NOT EXISTS communication_logs (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            channel VARCHAR(50) NOT NULL,
            recipient VARCHAR(255) NOT NULL,
            message TEXT,
            status VARCHAR(50) DEFAULT "pending",
            response TEXT,
            error_message TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ');
    
    // AI recommendations table
    $pdo->exec('
        CREATE TABLE IF NOT EXISTS ai_recommendations (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER,
            product_id INTEGER NOT NULL,
            score DECIMAL(5, 2),
            reason TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
        )
    ');
    
    // Settings table
    $pdo->exec('
        CREATE TABLE IF NOT EXISTS settings (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            key VARCHAR(255) UNIQUE NOT NULL,
            value LONGTEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ');
}

function createAdminUser($email, $username, $password, $name) {
    $pdo = new PDO('sqlite:' . __DIR__ . '/database/patel_perfumes.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    
    $stmt = $pdo->prepare('
        INSERT OR REPLACE INTO users (name, email, password, role, is_active)
        VALUES (?, ?, ?, ?, 1)
    ');
    
    $stmt->execute([$name, $email, $hashedPassword, 'admin']);
}

function updateEnvFile($data) {
    $envFile = __DIR__ . '/.env';
    
    $envContent = file_exists($envFile) ? file_get_contents($envFile) : '';
    
    // Update or add environment variables
    $updates = [
        'APP_NAME' => $data['appName'] ?? 'Patel Perfumes',
        'APP_URL' => $data['appUrl'] ?? 'http://localhost:8000',
        'DB_PATH' => 'database/patel_perfumes.db',
    ];
    
    // Email configuration
    if ($data['enableEmail']) {
        $updates['MAIL_DRIVER'] = $data['mailDriver'] ?? 'log';
        if ($data['mailDriver'] === 'smtp') {
            $updates['MAIL_HOST'] = $data['smtpHost'] ?? '';
            $updates['MAIL_PORT'] = $data['smtpPort'] ?? '';
            $updates['MAIL_USERNAME'] = $data['smtpUsername'] ?? '';
            $updates['MAIL_PASSWORD'] = $data['smtpPassword'] ?? '';
        }
    }
    
    // SMS configuration
    if ($data['enableSMS']) {
        $updates['TWILIO_ENABLED'] = 'true';
        $updates['TWILIO_ACCOUNT_SID'] = $data['twilioSid'] ?? '';
        $updates['TWILIO_AUTH_TOKEN'] = $data['twilioToken'] ?? '';
        $updates['TWILIO_PHONE_NUMBER'] = $data['twilioPhone'] ?? '';
    }
    
    // WhatsApp configuration
    if ($data['enableWhatsApp']) {
        $updates['WHATSAPP_ENABLED'] = 'true';
        $updates['WHATSAPP_PHONE_NUMBER_ID'] = $data['whatsappPhoneId'] ?? '';
        $updates['WHATSAPP_ACCESS_TOKEN'] = $data['whatsappToken'] ?? '';
    }
    
    // AI configuration
    if ($data['enableAI']) {
        $updates['AI_PROVIDER'] = $data['aiProvider'] ?? 'openai';
        if ($data['aiProvider'] === 'openai') {
            $updates['OPENAI_API_KEY'] = $data['aiApiKey'] ?? '';
            $updates['OPENAI_ENABLED'] = 'true';
        } elseif ($data['aiProvider'] === 'groq') {
            $updates['GROQ_API_KEY'] = $data['aiApiKey'] ?? '';
            $updates['GROQ_ENABLED'] = 'true';
        }
    }
    
    // Write updated env
    foreach ($updates as $key => $value) {
        $pattern = '/^' . $key . '=.*/m';
        $envContent = preg_replace($pattern, $key . '=' . $value, $envContent);
        
        if (!preg_match($pattern, $envContent)) {
            $envContent .= "\n" . $key . '=' . $value;
        }
    }
    
    file_put_contents($envFile, $envContent);
}

function seedDatabase() {
    $pdo = new PDO('sqlite:' . __DIR__ . '/database/patel_perfumes.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Check if categories already exist
    $result = $pdo->query('SELECT COUNT(*) as count FROM categories');
    $count = $result->fetch(PDO::FETCH_ASSOC)['count'];
    
    if ($count > 0) {
        return; // Already seeded
    }
    
    // Categories
    $categories = [
        ['name' => 'Men', 'slug' => 'men', 'description' => 'Premium fragrances for men'],
        ['name' => 'Women', 'slug' => 'women', 'description' => 'Elegant fragrances for women'],
        ['name' => 'Unisex', 'slug' => 'unisex', 'description' => 'Universal fragrances for everyone'],
        ['name' => 'Limited Edition', 'slug' => 'limited-edition', 'description' => 'Exclusive limited edition perfumes'],
    ];
    
    foreach ($categories as $cat) {
        $stmt = $pdo->prepare('INSERT INTO categories (name, slug, description, is_active) VALUES (?, ?, ?, 1)');
        $stmt->execute([$cat['name'], $cat['slug'], $cat['description']]);
    }
    
    // Products
    $products = [
        [
            'category_id' => 1,
            'name' => 'Aqua Dominance',
            'slug' => 'aqua-dominance',
            'description' => 'Fresh and powerful eau de toilette',
            'price' => 4999,
            'volume' => '100ml',
            'stock' => 50,
        ],
        [
            'category_id' => 2,
            'name' => 'Rose Paradise',
            'slug' => 'rose-paradise',
            'description' => 'Delicate rose and jasmine fragrance',
            'price' => 5499,
            'volume' => '100ml',
            'stock' => 50,
        ],
        [
            'category_id' => 3,
            'name' => 'Midnight Oud',
            'slug' => 'midnight-oud',
            'description' => 'Rich oud and amber for everyone',
            'price' => 6999,
            'volume' => '100ml',
            'stock' => 50,
        ],
        [
            'category_id' => 4,
            'name' => 'Golden Elixir',
            'slug' => 'golden-elixir',
            'description' => 'Limited edition luxury fragrance',
            'price' => 12999,
            'volume' => '75ml',
            'stock' => 20,
        ],
        [
            'category_id' => 1,
            'name' => 'Bleu Horizon',
            'slug' => 'bleu-horizon',
            'description' => 'Ocean-inspired masculine scent',
            'price' => 4499,
            'volume' => '100ml',
            'stock' => 50,
        ],
        [
            'category_id' => 2,
            'name' => 'Fleur de Luxe',
            'slug' => 'fleur-de-luxe',
            'description' => 'Premium floral composition',
            'price' => 5999,
            'volume' => '100ml',
            'stock' => 50,
        ],
    ];
    
    foreach ($products as $prod) {
        $stmt = $pdo->prepare('
            INSERT INTO products (category_id, name, slug, description, price, volume, stock, is_active)
            VALUES (?, ?, ?, ?, ?, ?, ?, 1)
        ');
        $stmt->execute([
            $prod['category_id'],
            $prod['name'],
            $prod['slug'],
            $prod['description'],
            $prod['price'],
            $prod['volume'],
            $prod['stock'],
        ]);
    }
}

function createSettings($data) {
    $pdo = new PDO('sqlite:' . __DIR__ . '/database/patel_perfumes.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $settings = [
        'app_name' => $data['appName'] ?? 'Patel Perfumes',
        'admin_email' => $data['adminEmail'] ?? '',
        'setup_completed' => 'true',
        'setup_date' => date('Y-m-d H:i:s'),
    ];
    
    foreach ($settings as $key => $value) {
        $stmt = $pdo->prepare('INSERT OR REPLACE INTO settings (key, value) VALUES (?, ?)');
        $stmt->execute([$key, $value]);
    }
}
