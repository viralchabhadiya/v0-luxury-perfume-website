<?php

return new class {
    /**
     * Production-level Order Items table migration
     * Tracks individual items in orders with pricing snapshot
     */
    public function up()
    {
        $db = new \PDO('sqlite:' . database_path('patel_perfumes.db'));
        
        $db->exec("DROP TABLE IF EXISTS order_items");
        
        $db->exec("
            CREATE TABLE order_items (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                
                -- Order Reference
                order_id INTEGER NOT NULL,
                product_id INTEGER NOT NULL,
                
                -- Product Snapshot
                product_name VARCHAR(255) NOT NULL,
                product_sku VARCHAR(100),
                
                -- Quantity & Pricing
                quantity INTEGER NOT NULL,
                unit_price DECIMAL(10, 2) NOT NULL,
                discount_price DECIMAL(10, 2),
                subtotal DECIMAL(10, 2) NOT NULL,
                tax DECIMAL(10, 2) DEFAULT 0,
                total DECIMAL(10, 2) NOT NULL,
                
                -- Product Details at Time of Order
                variant JSON,
                attributes JSON,
                
                -- Timestamps
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                
                FOREIGN KEY(order_id) REFERENCES orders(id),
                FOREIGN KEY(product_id) REFERENCES products(id)
            )
        ");
        
        $db->exec("CREATE INDEX idx_order_items_order_id ON order_items(order_id)");
        $db->exec("CREATE INDEX idx_order_items_product_id ON order_items(product_id)");
    }
};
