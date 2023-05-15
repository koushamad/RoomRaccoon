<?php

namespace Kousha\RoomRaccoon\Core;

use PDO;
use PDOException;

class Database
{
    private static ?Database $instance = null;
    private PDO $connection;

    private function __construct($config)
    {
        try {
            if ($config['connection'] === 'mysql') {
                $this->connection = new PDO(
                    "mysql:host={$config['mysql']['host']};dbname={$config['mysql']['database']};port={$config['mysql']['port']};charset=utf8",
                    $config['mysql']['username'],
                    $config['mysql']['password']
                );
            } else {
                $databasePath = __DIR__ . '/../../' . $config['sqlite']['database'];
                $this->connection = new PDO($config['sqlite']['database'] != ':memory:' ? "sqlite:{$databasePath}" : 'sqlite::memory:',
                    null,
                    null,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    ]
                );
            }

        } catch (PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }

    public static function getInstance($config): ?Database
    {
        if (self::$instance === null) {
            self::$instance = new self($config);
        }
        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}