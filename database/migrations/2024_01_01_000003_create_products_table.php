<?php

return new class {
    public function up()
    {
        $db = new \PDO('sqlite:' . database_path('patel_perfumes.db'));
        
        $db->exec("
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
    }
};
