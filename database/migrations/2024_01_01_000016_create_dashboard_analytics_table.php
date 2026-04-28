<?php

return new class {
    /**
     * Production-level Dashboard Analytics table migration
     * Aggregated analytics for dashboard reports
     */
    public function up()
    {
        $db = new \PDO('sqlite:' . database_path('patel_perfumes.db'));
        
        $db->exec("DROP TABLE IF EXISTS dashboard_analytics");
        
        $db->exec("
            CREATE TABLE dashboard_analytics (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                
                -- Time Period
                date DATE NOT NULL,
                
                -- Sales Metrics
                total_orders INTEGER DEFAULT 0,
                total_revenue DECIMAL(12, 2) DEFAULT 0,
                avg_order_value DECIMAL(10, 2) DEFAULT 0,
                
                -- Product Metrics
                total_products_sold INTEGER DEFAULT 0,
                top_product_id INTEGER,
                
                -- Customer Metrics
                new_customers INTEGER DEFAULT 0,
                returning_customers INTEGER DEFAULT 0,
                
                -- Traffic Metrics
                page_views INTEGER DEFAULT 0,
                unique_visitors INTEGER DEFAULT 0,
                conversion_rate DECIMAL(5, 2) DEFAULT 0,
                
                -- Payment Metrics
                successful_payments INTEGER DEFAULT 0,
                failed_payments INTEGER DEFAULT 0,
                
                -- Additional Data
                data JSON,
                
                -- Timestamps
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                
                UNIQUE(date),
                FOREIGN KEY (top_product_id) REFERENCES products(id)
            )
        ");
        
        $db->exec("CREATE INDEX idx_dashboard_analytics_date ON dashboard_analytics(date)");
    }
};
