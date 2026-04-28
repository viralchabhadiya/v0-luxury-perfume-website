<?php

return new class {
    /**
     * Production-level Admin Users table migration
     * Role-based access control for admin panel with permissions tracking
     */
    public function up()
    {
        $db = new \PDO('sqlite:' . database_path('patel_perfumes.db'));
        
        $db->exec("DROP TABLE IF EXISTS admin_users");
        
        $db->exec("
            CREATE TABLE admin_users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                
                -- Basic Information
                name VARCHAR(255) NOT NULL,
                email VARCHAR(255) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL,
                phone VARCHAR(20),
                
                -- Role & Permissions
                role VARCHAR(50) NOT NULL,
                permissions JSON,
                
                -- Status
                is_active BOOLEAN DEFAULT 1,
                last_login_at TIMESTAMP,
                password_changed_at TIMESTAMP,
                
                -- 2FA
                two_factor_enabled BOOLEAN DEFAULT 0,
                two_factor_secret VARCHAR(255),
                
                -- Timestamps
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                deleted_at TIMESTAMP DEFAULT NULL
            )
        ");
        
        $db->exec("CREATE INDEX idx_admin_users_email ON admin_users(email)");
        $db->exec("CREATE INDEX idx_admin_users_role ON admin_users(role)");
        $db->exec("CREATE INDEX idx_admin_users_is_active ON admin_users(is_active)");
    }
};
