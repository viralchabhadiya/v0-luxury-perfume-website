<?php

class CreateCommunicationLogsTable {
    public static function up() {
        $db = new PDO('sqlite:' . __DIR__ . '/../../database/app.db');
        
        $db->exec("CREATE TABLE IF NOT EXISTS communication_logs (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            service_type VARCHAR(100) NOT NULL,
            recipient VARCHAR(255) NOT NULL,
            message_content TEXT,
            status VARCHAR(50) DEFAULT 'pending',
            response TEXT,
            retry_count INTEGER DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            sent_at TIMESTAMP NULL
        )");
    }
    
    public static function down() {
        $db = new PDO('sqlite:' . __DIR__ . '/../../database/app.db');
        $db->exec("DROP TABLE IF EXISTS communication_logs");
    }
}
