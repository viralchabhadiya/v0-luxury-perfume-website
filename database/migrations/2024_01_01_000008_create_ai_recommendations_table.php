<?php

class CreateAiRecommendationsTable {
    public static function up() {
        $db = new PDO('sqlite:' . __DIR__ . '/../../database/app.db');
        
        $db->exec("CREATE TABLE IF NOT EXISTS ai_recommendations (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL,
            product_id INTEGER NOT NULL,
            score DECIMAL(5, 3) DEFAULT 0.0,
            reason VARCHAR(255),
            recommendation_type VARCHAR(100),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id),
            FOREIGN KEY (product_id) REFERENCES products(id)
        )");
    }
    
    public static function down() {
        $db = new PDO('sqlite:' . __DIR__ . '/../../database/app.db');
        $db->exec("DROP TABLE IF EXISTS ai_recommendations");
    }
}
