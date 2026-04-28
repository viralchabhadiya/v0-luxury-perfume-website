<?php

return new class {
    /**
     * Production-level Orders table migration
     * Comprehensive order management with payment tracking and shipping information
     */
    public function up()
    {
        $db = new \PDO('sqlite:' . database_path('patel_perfumes.db'));
        
        $db->exec("DROP TABLE IF EXISTS orders");
        
        $db->exec("
            CREATE TABLE orders (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                
                -- User Reference
                user_id INTEGER NOT NULL,
                
                -- Order Identification
                order_number VARCHAR(100) UNIQUE NOT NULL,
                order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                
                -- Pricing Information
                subtotal DECIMAL(10, 2) NOT NULL,
                tax DECIMAL(10, 2) DEFAULT 0,
                shipping DECIMAL(10, 2) DEFAULT 0,
                discount DECIMAL(10, 2) DEFAULT 0,
                total DECIMAL(10, 2) NOT NULL,
                
                -- Status & Payment
                status VARCHAR(50) DEFAULT 'pending',
                payment_status VARCHAR(50) DEFAULT 'pending',
                payment_method VARCHAR(100),
                payment_gateway VARCHAR(100),
                transaction_id VARCHAR(255),
                
                -- Shipping Information
                shipping_method VARCHAR(100),
                tracking_number VARCHAR(255),
                shipping_address JSON,
                billing_address JSON,
                
                -- Customer Information
                customer_email VARCHAR(255),
                customer_phone VARCHAR(20),
                
                -- Additional Information
                notes TEXT,
                admin_notes TEXT,
                coupon_code VARCHAR(100),
                
                -- Timestamps
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                paid_at TIMESTAMP,
                shipped_at TIMESTAMP,
                delivered_at TIMESTAMP,
                cancelled_at TIMESTAMP,
                
                FOREIGN KEY(user_id) REFERENCES users(id)
            )
        ");
        
        $db->exec("CREATE INDEX idx_orders_user_id ON orders(user_id)");
        $db->exec("CREATE INDEX idx_orders_order_number ON orders(order_number)");
        $db->exec("CREATE INDEX idx_orders_status ON orders(status)");
        $db->exec("CREATE INDEX idx_orders_payment_status ON orders(payment_status)");
        $db->exec("CREATE INDEX idx_orders_created_at ON orders(created_at)");
        $db->exec("CREATE INDEX idx_orders_customer_email ON orders(customer_email)");
    }
};
