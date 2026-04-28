<?php

return new class {
    /**
     * Production-level Products table migration
     * Comprehensive product information with inventory, pricing, and fragrance details
     */
    public function up()
    {
        $db = new \PDO('sqlite:' . database_path('patel_perfumes.db'));
        
        $db->exec("DROP TABLE IF EXISTS products");
        
        $db->exec("
            CREATE TABLE products (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                
                -- Basic Information
                name VARCHAR(255) NOT NULL,
                slug VARCHAR(255) UNIQUE NOT NULL,
                description TEXT,
                long_description TEXT,
                
                -- Pricing & Discount
                price DECIMAL(10, 2) NOT NULL,
                discount_price DECIMAL(10, 2),
                cost_price DECIMAL(10, 2),
                
                -- Category & Organization
                category_id INTEGER NOT NULL,
                sku VARCHAR(100) UNIQUE,
                
                -- Media
                image VARCHAR(255),
                gallery_images JSON,
                
                -- Fragrance Details
                volume VARCHAR(100),
                scent_profile VARCHAR(255),
                longevity VARCHAR(100),
                projection VARCHAR(100),
                notes JSON,
                scent_family VARCHAR(100),
                concentration VARCHAR(50),
                
                -- Inventory
                stock_quantity INTEGER DEFAULT 0,
                min_stock_level INTEGER DEFAULT 5,
                in_stock BOOLEAN DEFAULT 1,
                
                -- Display & Visibility
                is_featured BOOLEAN DEFAULT 0,
                is_active BOOLEAN DEFAULT 1,
                display_order INTEGER DEFAULT 0,
                
                -- SEO
                meta_title VARCHAR(255),
                meta_description VARCHAR(500),
                meta_keywords VARCHAR(500),
                
                -- Additional Info
                ratings_count INTEGER DEFAULT 0,
                avg_rating DECIMAL(3, 2) DEFAULT 0,
                
                -- Timestamps
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                deleted_at TIMESTAMP DEFAULT NULL,
                
                FOREIGN KEY(category_id) REFERENCES categories(id)
            )
        ");
        
        $db->exec("CREATE INDEX idx_products_slug ON products(slug)");
        $db->exec("CREATE INDEX idx_products_category_id ON products(category_id)");
        $db->exec("CREATE INDEX idx_products_is_active ON products(is_active)");
        $db->exec("CREATE INDEX idx_products_is_featured ON products(is_featured)");
        $db->exec("CREATE INDEX idx_products_in_stock ON products(in_stock)");
        $db->exec("CREATE INDEX idx_products_sku ON products(sku)");
        $db->exec("CREATE INDEX idx_products_created_at ON products(created_at)");
    }
};
