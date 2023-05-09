<?php

namespace Kousha\RoomRaccoon\Tests;

use GuzzleHttp\Client;
use Kousha\RoomRaccoon\Core\Kernel;
use PhpParser\Node\Expr\New_;

class TestCase extends \PHPUnit\Framework\TestCase
{
    protected Client $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->refreshDatabase();
        $this->client = new Client([
            'base_uri' => 'http://localhost:9090'
        ]);
    }

    public function refreshDatabase()
    {
        $kernel = new Kernel();
        $connection = $kernel->getContainer('database');
        $databaseType = $kernel->getContainer('config')['database']['connection'];

        if ($databaseType === 'mysql') {
            $connection->exec('TRUNCATE TABLE shopping_list');
        } else { // Assuming SQLite
            $connection->exec('DELETE FROM shopping_list');
            // Check if SQLITE_SEQUENCE table exists
            $result = $connection->query("SELECT name FROM sqlite_master WHERE type='table' AND name='SQLITE_SEQUENCE'");
            if ($result->fetch()) {
                $connection->exec('UPDATE SQLITE_SEQUENCE SET seq = 0 WHERE name = "shopping_list"');
            }
        }
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }
}