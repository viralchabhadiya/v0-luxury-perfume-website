<?php

class CreateNotificationsTable {
    public static function up() {
        $db = new PDO('sqlite:' . __DIR__ . '/../../database/app.db');
        
        $db->exec("CREATE TABLE IF NOT EXISTS notifications (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL,
            order_id INTEGER,
            type VARCHAR(255) NOT NULL,
            channel VARCHAR(100) NOT NULL,
            subject VARCHAR(255),
            message TEXT NOT NULL,
            recipient VARCHAR(255) NOT NULL,
            status VARCHAR(50) DEFAULT 'pending',
            sent_at TIMESTAMP NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id),
            FOREIGN KEY (order_id) REFERENCES orders(id)
        )");
    }
    
    public static function down() {
        $db = new PDO('sqlite:' . __DIR__ . '/../../database/app.db');
        $db->exec("DROP TABLE IF EXISTS notifications");
    }
}
