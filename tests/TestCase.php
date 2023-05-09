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
        $this->client = new Client([
            'base_uri' => 'http://localhost:8080'
        ]);
    }


    public function refreshDatabase() {
        $kernel = New Kernel();
        $connection = $kernel->getContainer('database');

        $connection->exec('TRUNCATE TABLE shopping_list');
    }

    public function tearDown(): void
    {
        $this->refreshDatabase();
    }
}