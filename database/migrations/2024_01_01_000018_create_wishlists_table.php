<?php

return new class {
    /**
     * Production-level Wishlists table migration
     * Customer product wishlists for favorites and saved items
     */
    public function up()
    {
        $db = new \PDO('sqlite:' . database_path('patel_perfumes.db'));
        
        $db->exec("DROP TABLE IF EXISTS wishlists");
        
        $db->exec("
            CREATE TABLE wishlists (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                
                -- References
                user_id INTEGER NOT NULL,
                product_id INTEGER NOT NULL,
                
                -- Status
                is_active BOOLEAN DEFAULT 1,
                
                -- Timestamps
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                
                UNIQUE(user_id, product_id),
                FOREIGN KEY (user_id) REFERENCES users(id),
                FOREIGN KEY (product_id) REFERENCES products(id)
            )
        ");
        
        $db->exec("CREATE INDEX idx_wishlists_user_id ON wishlists(user_id)");
        $db->exec("CREATE INDEX idx_wishlists_product_id ON wishlists(product_id)");
        $db->exec("CREATE INDEX idx_wishlists_created_at ON wishlists(created_at)");
    }
};
