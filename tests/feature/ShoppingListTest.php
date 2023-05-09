<?php

namespace Kousha\RoomRaccoon\Tests\Feature;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class ShoppingListTest extends TestCase
{
    private $client;

    protected function setUp(): void
    {
        $this->client = new Client([
            'base_uri' => 'http://localhost:8080'
        ]);
    }

    public function testGetShoppingList(): void
    {
        $response = $this->client->request('GET', '/api/shoppinglist');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getBody());
    }

    public function testAddItem(): void
    {
        $response = $this->client->request('POST', '/api/shoppinglist', [
            'json' => [
                'item_name' => 'test item',
                'quantity' => 2
            ]
        ]);
        $this->assertEquals(201, $response->getStatusCode());
        $this->assertJson($response->getBody());
    }

    public function testUpdateItem(): void
    {
        $response = $this->client->request('PUT', '/api/shoppinglist/1', [
            'json' => [
                'item_name' => 'updated item',
                'quantity' => 3
            ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getBody());
    }

    public function testDeleteItem(): void
    {
        $response = $this->client->request('DELETE', '/api/shoppinglist/1');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getBody());
    }
}