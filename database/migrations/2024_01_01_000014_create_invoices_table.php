<?php

return new class {
    /**
     * Production-level Invoices table migration
     * Invoice generation and tracking for orders
     */
    public function up()
    {
        $db = new \PDO('sqlite:' . database_path('patel_perfumes.db'));
        
        $db->exec("DROP TABLE IF EXISTS invoices");
        
        $db->exec("
            CREATE TABLE invoices (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                
                -- Order Reference
                order_id INTEGER NOT NULL,
                
                -- Invoice Details
                invoice_number VARCHAR(100) UNIQUE NOT NULL,
                invoice_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                due_date TIMESTAMP,
                
                -- Amount Information
                subtotal DECIMAL(10, 2) NOT NULL,
                tax DECIMAL(10, 2) DEFAULT 0,
                discount DECIMAL(10, 2) DEFAULT 0,
                shipping DECIMAL(10, 2) DEFAULT 0,
                total DECIMAL(10, 2) NOT NULL,
                
                -- Payment Information
                amount_paid DECIMAL(10, 2) DEFAULT 0,
                payment_status VARCHAR(50) DEFAULT 'unpaid',
                paid_at TIMESTAMP,
                
                -- Notes
                notes TEXT,
                terms_conditions TEXT,
                
                -- Files
                pdf_path VARCHAR(255),
                
                -- Status
                status VARCHAR(50) DEFAULT 'draft',
                is_sent BOOLEAN DEFAULT 0,
                sent_at TIMESTAMP,
                
                -- Timestamps
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                
                FOREIGN KEY (order_id) REFERENCES orders(id)
            )
        ");
        
        $db->exec("CREATE INDEX idx_invoices_order_id ON invoices(order_id)");
        $db->exec("CREATE INDEX idx_invoices_invoice_number ON invoices(invoice_number)");
        $db->exec("CREATE INDEX idx_invoices_status ON invoices(status)");
        $db->exec("CREATE INDEX idx_invoices_payment_status ON invoices(payment_status)");
    }
};
