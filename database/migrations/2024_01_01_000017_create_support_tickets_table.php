<?php

return new class {
    /**
     * Production-level Support Tickets table migration
     * Customer support ticket management system
     */
    public function up()
    {
        $db = new \PDO('sqlite:' . database_path('patel_perfumes.db'));
        
        $db->exec("DROP TABLE IF EXISTS support_tickets");
        
        $db->exec("
            CREATE TABLE support_tickets (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                
                -- References
                user_id INTEGER NOT NULL,
                order_id INTEGER,
                
                -- Ticket Details
                ticket_number VARCHAR(100) UNIQUE NOT NULL,
                subject VARCHAR(255) NOT NULL,
                description TEXT NOT NULL,
                
                -- Category & Priority
                category VARCHAR(100),
                priority VARCHAR(50) DEFAULT 'medium',
                
                -- Status
                status VARCHAR(50) DEFAULT 'open',
                assigned_to INTEGER,
                
                -- Communication
                latest_reply_at TIMESTAMP,
                reply_count INTEGER DEFAULT 0,
                
                -- Resolution
                resolution TEXT,
                resolved_at TIMESTAMP,
                
                -- Timestamps
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                closed_at TIMESTAMP,
                
                FOREIGN KEY (user_id) REFERENCES users(id),
                FOREIGN KEY (order_id) REFERENCES orders(id),
                FOREIGN KEY (assigned_to) REFERENCES admin_users(id)
            )
        ");
        
        $db->exec("CREATE INDEX idx_support_tickets_user_id ON support_tickets(user_id)");
        $db->exec("CREATE INDEX idx_support_tickets_status ON support_tickets(status)");
        $db->exec("CREATE INDEX idx_support_tickets_priority ON support_tickets(priority)");
        $db->exec("CREATE INDEX idx_support_tickets_assigned_to ON support_tickets(assigned_to)");
        $db->exec("CREATE INDEX idx_support_tickets_created_at ON support_tickets(created_at)");
    }
};
