<?php

return new class {
    /**
     * Production-level Notifications table migration
     * Multi-channel notification system (Email, SMS, WhatsApp, Telegram, Push)
     */
    public function up()
    {
        $db = new \PDO('sqlite:' . database_path('patel_perfumes.db'));
        
        $db->exec("DROP TABLE IF EXISTS notifications");
        
        $db->exec("
            CREATE TABLE notifications (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                
                -- User Reference
                user_id INTEGER NOT NULL,
                order_id INTEGER,
                
                -- Notification Details
                type VARCHAR(100) NOT NULL,
                category VARCHAR(50),
                title VARCHAR(255),
                subject VARCHAR(255),
                message TEXT NOT NULL,
                
                -- Multi-Channel
                channel VARCHAR(100) NOT NULL,
                recipient VARCHAR(255) NOT NULL,
                
                -- Status Tracking
                status VARCHAR(50) DEFAULT 'pending',
                retry_count INTEGER DEFAULT 0,
                error_message TEXT,
                
                -- Delivery Information
                sent_at TIMESTAMP,
                read_at TIMESTAMP,
                clicked_at TIMESTAMP,
                
                -- Additional Data
                data JSON,
                template_id VARCHAR(255),
                
                -- Timestamps
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                
                FOREIGN KEY (user_id) REFERENCES users(id),
                FOREIGN KEY (order_id) REFERENCES orders(id)
            )
        ");
        
        $db->exec("CREATE INDEX idx_notifications_user_id ON notifications(user_id)");
        $db->exec("CREATE INDEX idx_notifications_order_id ON notifications(order_id)");
        $db->exec("CREATE INDEX idx_notifications_type ON notifications(type)");
        $db->exec("CREATE INDEX idx_notifications_channel ON notifications(channel)");
        $db->exec("CREATE INDEX idx_notifications_status ON notifications(status)");
        $db->exec("CREATE INDEX idx_notifications_created_at ON notifications(created_at)");
    }
};
