<?php

return new class {
    /**
     * Production-level Users table migration
     * Handles customer and admin user accounts with proper indexing and constraints
     */
    public function up()
    {
        $db = new \PDO('sqlite:' . database_path('patel_perfumes.db'));
        
        // Drop existing table if migration is being rerun
        $db->exec("DROP TABLE IF EXISTS users");
        
        $db->exec("
            CREATE TABLE users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                
                -- Basic Information
                name VARCHAR(255) NOT NULL,
                email VARCHAR(255) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL,
                phone VARCHAR(20),
                
                -- Address Information
                address VARCHAR(255),
                city VARCHAR(100),
                state VARCHAR(100),
                postal_code VARCHAR(20),
                country VARCHAR(100),
                
                -- Account Type & Status
                is_admin BOOLEAN DEFAULT 0,
                is_active BOOLEAN DEFAULT 1,
                email_verified BOOLEAN DEFAULT 0,
                email_verified_at TIMESTAMP,
                
                -- Additional Fields
                profile_image VARCHAR(255),
                bio TEXT,
                last_login_at TIMESTAMP,
                
                -- Timestamps
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                deleted_at TIMESTAMP DEFAULT NULL
            )
        ");
        
        // Create indexes for better query performance
        $db->exec("CREATE INDEX idx_users_email ON users(email)");
        $db->exec("CREATE INDEX idx_users_is_admin ON users(is_admin)");
        $db->exec("CREATE INDEX idx_users_is_active ON users(is_active)");
        $db->exec("CREATE INDEX idx_users_created_at ON users(created_at)");
        $db->exec("CREATE INDEX idx_users_deleted_at ON users(deleted_at)");
    }
};
