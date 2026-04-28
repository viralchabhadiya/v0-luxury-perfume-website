<?php

return new class {
    /**
     * Production-level Activity Logs table migration
     * Tracks all admin and user activities for audit trail
     */
    public function up()
    {
        $db = new \PDO('sqlite:' . database_path('patel_perfumes.db'));
        
        $db->exec("DROP TABLE IF EXISTS activity_logs");
        
        $db->exec("
            CREATE TABLE activity_logs (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                
                -- User Information
                admin_user_id INTEGER,
                user_id INTEGER,
                
                -- Activity Details
                action VARCHAR(255) NOT NULL,
                description TEXT,
                model_type VARCHAR(100),
                model_id INTEGER,
                
                -- Data Changes
                old_values JSON,
                new_values JSON,
                
                -- IP & User Agent
                ip_address VARCHAR(45),
                user_agent VARCHAR(255),
                
                -- Status
                status VARCHAR(50),
                
                -- Timestamps
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                
                FOREIGN KEY (admin_user_id) REFERENCES admin_users(id),
                FOREIGN KEY (user_id) REFERENCES users(id)
            )
        ");
        
        $db->exec("CREATE INDEX idx_activity_logs_admin_user_id ON activity_logs(admin_user_id)");
        $db->exec("CREATE INDEX idx_activity_logs_action ON activity_logs(action)");
        $db->exec("CREATE INDEX idx_activity_logs_model_type ON activity_logs(model_type)");
        $db->exec("CREATE INDEX idx_activity_logs_created_at ON activity_logs(created_at)");
    }
};
