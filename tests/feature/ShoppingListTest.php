<?php

namespace Kousha\RoomRaccoon\Tests\Feature;


use Kousha\RoomRaccoon\Tests\TestCase;

class ShoppingListTest extends TestCase
{
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
        $responseResult = json_decode($response->getBody(), true);
        $this->assertArrayHasKey('success', $responseResult);
        $this->assertEquals('Item added', $responseResult['success']);
    }

    public function testUpdateItem(): void
    {
        $response = $this->client->request('POST', '/api/shoppinglist', [
            'json' => [
                'item_name' => 'test item',
                'quantity' => 2
            ]
        ]);
        $this->assertEquals(201, $response->getStatusCode());

        $response = $this->client->request('PUT', '/api/shoppinglist/1', [
            'json' => [
                'item_name' => 'updated item',
                'quantity' => 3
            ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getBody());
        $responseResult = json_decode($response->getBody(), true);
        $this->assertArrayHasKey('success', $responseResult);
        $this->assertEquals('Item updated', $responseResult['success']);
    }

    public function testCheckedItem() {
        $response = $this->client->request('POST', '/api/shoppinglist', [
            'json' => [
                'item_name' => 'test item',
                'quantity' => 2
            ]
        ]);
        $this->assertEquals(201, $response->getStatusCode());

        $response = $this->client->patch("/api/shoppinglist/1/check", [
            'json' => [
                'checked' => true
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());
        $responseResult = json_decode($response->getBody(), true);
        $this->assertArrayHasKey('success', $responseResult);
        $this->assertEquals('Item marked as checked', $responseResult['success']);
    }

    public function testDeleteItem(): void
    {
        $response = $this->client->request('POST', '/api/shoppinglist', [
            'json' => [
                'item_name' => 'test item',
                'quantity' => 2
            ]
        ]);
        $this->assertEquals(201, $response->getStatusCode());

        $response = $this->client->request('DELETE', '/api/shoppinglist/1');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getBody());
    }

    public function testGetShoppingList(): void
    {
        $response = $this->client->request('POST', '/api/shoppinglist', [
            'json' => [
                'item_name' => 'test item 1',
                'quantity' => 4
            ]
        ]);
        $this->assertEquals(201, $response->getStatusCode());

        $response = $this->client->request('POST', '/api/shoppinglist', [
            'json' => [
                'item_name' => 'test item 2',
                'quantity' => 2
            ]
        ]);
        $this->assertEquals(201, $response->getStatusCode());

        $response = $this->client->request('GET', '/api/shoppinglist');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getBody());
        $responseResult = json_decode($response->getBody(), true);
        $this->assertIsArray($responseResult);
        $this->assertEquals(2, count($responseResult));
    }
}