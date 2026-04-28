<?php

return new class {
    /**
     * Production-level Reviews table migration
     * Customer product reviews with ratings and moderation
     */
    public function up()
    {
        $db = new \PDO('sqlite:' . database_path('patel_perfumes.db'));
        
        $db->exec("DROP TABLE IF EXISTS reviews");
        
        $db->exec("
            CREATE TABLE reviews (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                
                -- References
                product_id INTEGER NOT NULL,
                user_id INTEGER NOT NULL,
                order_item_id INTEGER,
                
                -- Review Content
                title VARCHAR(255),
                body TEXT NOT NULL,
                rating INTEGER NOT NULL,
                
                -- Review Details
                longevity_rating INTEGER,
                projection_rating INTEGER,
                value_for_money_rating INTEGER,
                
                -- Media
                images JSON,
                video_url VARCHAR(255),
                
                -- Status & Moderation
                status VARCHAR(50) DEFAULT 'pending',
                is_verified_purchase BOOLEAN DEFAULT 0,
                helpful_count INTEGER DEFAULT 0,
                unhelpful_count INTEGER DEFAULT 0,
                
                -- Admin Notes
                admin_notes TEXT,
                
                -- Timestamps
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                published_at TIMESTAMP,
                
                FOREIGN KEY (product_id) REFERENCES products(id),
                FOREIGN KEY (user_id) REFERENCES users(id),
                FOREIGN KEY (order_item_id) REFERENCES order_items(id)
            )
        ");
        
        $db->exec("CREATE INDEX idx_reviews_product_id ON reviews(product_id)");
        $db->exec("CREATE INDEX idx_reviews_user_id ON reviews(user_id)");
        $db->exec("CREATE INDEX idx_reviews_status ON reviews(status)");
        $db->exec("CREATE INDEX idx_reviews_rating ON reviews(rating)");
        $db->exec("CREATE INDEX idx_reviews_created_at ON reviews(created_at)");
    }
};
