<?php

namespace App;

use PDO;
use PDOStatement;

class Database
{
    private static $instance;
    private $pdo;

    private function __construct()
    {
        $dbPath = database_path('patel_perfumes.db');
        $this->pdo = new PDO('sqlite:' . $dbPath);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->pdo;
    }

    public function migrate()
    {
        $files = glob(database_path('migrations/*.php'));
        sort($files);

        foreach ($files as $file) {
            $migration = require $file;
            if (method_exists($migration, 'up')) {
                $migration->up();
            }
        }
    }
}
