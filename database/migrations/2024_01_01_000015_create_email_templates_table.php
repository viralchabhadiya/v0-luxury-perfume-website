<?php

return new class {
    /**
     * Production-level Email Templates table migration
     * Email templates for transactional and marketing emails
     */
    public function up()
    {
        $db = new \PDO('sqlite:' . database_path('patel_perfumes.db'));
        
        $db->exec("DROP TABLE IF EXISTS email_templates");
        
        $db->exec("
            CREATE TABLE email_templates (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                
                -- Template Details
                name VARCHAR(255) NOT NULL,
                slug VARCHAR(255) UNIQUE NOT NULL,
                description VARCHAR(255),
                
                -- Content
                subject VARCHAR(255) NOT NULL,
                from_name VARCHAR(255),
                from_email VARCHAR(255),
                reply_to VARCHAR(255),
                
                -- Template Body
                body TEXT NOT NULL,
                text_body TEXT,
                
                -- Variables
                variables JSON,
                
                -- Status
                is_active BOOLEAN DEFAULT 1,
                is_default BOOLEAN DEFAULT 0,
                
                -- Email Type
                type VARCHAR(50),
                
                -- Timestamps
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ");
        
        $db->exec("CREATE INDEX idx_email_templates_slug ON email_templates(slug)");
        $db->exec("CREATE INDEX idx_email_templates_type ON email_templates(type)");
        $db->exec("CREATE INDEX idx_email_templates_is_active ON email_templates(is_active)");
    }
};
