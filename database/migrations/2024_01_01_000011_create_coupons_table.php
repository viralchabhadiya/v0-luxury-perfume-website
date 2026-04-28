<?php

return new class {
    /**
     * Production-level Coupons table migration
     * Discount codes with flexible configuration
     */
    public function up()
    {
        $db = new \PDO('sqlite:' . database_path('patel_perfumes.db'));
        
        $db->exec("DROP TABLE IF EXISTS coupons");
        
        $db->exec("
            CREATE TABLE coupons (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                
                -- Code & Description
                code VARCHAR(100) UNIQUE NOT NULL,
                description VARCHAR(255),
                
                -- Discount Configuration
                discount_type VARCHAR(20),
                discount_value DECIMAL(10, 2) NOT NULL,
                max_discount DECIMAL(10, 2),
                
                -- Usage Limits
                max_uses INTEGER,
                max_uses_per_customer INTEGER DEFAULT 1,
                current_uses INTEGER DEFAULT 0,
                
                -- Validity
                valid_from TIMESTAMP,
                valid_until TIMESTAMP,
                
                -- Conditions
                min_order_amount DECIMAL(10, 2),
                applicable_categories JSON,
                applicable_products JSON,
                
                -- Status
                is_active BOOLEAN DEFAULT 1,
                
                -- Timestamps
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ");
        
        $db->exec("CREATE INDEX idx_coupons_code ON coupons(code)");
        $db->exec("CREATE INDEX idx_coupons_is_active ON coupons(is_active)");
        $db->exec("CREATE INDEX idx_coupons_valid_from ON coupons(valid_from)");
        $db->exec("CREATE INDEX idx_coupons_valid_until ON coupons(valid_until)");
    }
};
