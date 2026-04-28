<?php

class CreateSettingsTable {
    public static function up() {
        $db = new PDO('sqlite:' . __DIR__ . '/../../database/app.db');
        
        $db->exec("CREATE TABLE IF NOT EXISTS settings (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            key VARCHAR(255) UNIQUE NOT NULL,
            value TEXT,
            category VARCHAR(100),
            is_encrypted BOOLEAN DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
    }
    
    public static function down() {
        $db = new PDO('sqlite:' . __DIR__ . '/../../database/app.db');
        $db->exec("DROP TABLE IF EXISTS settings");
    }
}
