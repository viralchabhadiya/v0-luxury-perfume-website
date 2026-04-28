<?php

return new class {
    /**
     * Production-level Categories table migration
     * Manages product categories with hierarchical support and SEO optimization
     */
    public function up()
    {
        $db = new \PDO('sqlite:' . database_path('patel_perfumes.db'));
        
        $db->exec("DROP TABLE IF EXISTS categories");
        
        $db->exec("
            CREATE TABLE categories (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                
                -- Basic Information
                name VARCHAR(255) NOT NULL,
                slug VARCHAR(255) UNIQUE NOT NULL,
                description TEXT,
                
                -- Media
                image VARCHAR(255),
                banner VARCHAR(255),
                
                -- Hierarchy
                parent_id INTEGER,
                
                -- Display & SEO
                meta_title VARCHAR(255),
                meta_description VARCHAR(500),
                meta_keywords VARCHAR(500),
                display_order INTEGER DEFAULT 0,
                is_active BOOLEAN DEFAULT 1,
                
                -- Timestamps
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                deleted_at TIMESTAMP DEFAULT NULL,
                
                FOREIGN KEY(parent_id) REFERENCES categories(id)
            )
        ");
        
        $db->exec("CREATE INDEX idx_categories_slug ON categories(slug)");
        $db->exec("CREATE INDEX idx_categories_parent_id ON categories(parent_id)");
        $db->exec("CREATE INDEX idx_categories_is_active ON categories(is_active)");
        $db->exec("CREATE INDEX idx_categories_created_at ON categories(created_at)");
    }
};
