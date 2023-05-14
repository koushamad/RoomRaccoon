<?php

namespace Kousha\RoomRaccoon\App;

use Bramus\Router\Router;
use Kousha\RoomRaccoon\App\Controllers\ShoppingListController;
use Pimple\Container;

class Route
{
    private Router $router;
    private ShoppingListController $shoppingListController;

    private string $enviroment;

    public function __construct(Router $router, Container $container)
    {
        $this->router = $router;
        $this->shoppingListController = $container['shoppingListController'];
        $this->enviroment = $container['config']['app']['env'];
    }

    public function registerRoutes(): void
    {
        $controller = $this->shoppingListController;

        $this->setCorsHeaders();

        $this->router->get('/api/shoppinglist', [$controller, 'index']);
        $this->router->post('/api/shoppinglist', [$controller, 'add']);
        $this->router->put('/api/shoppinglist/(\d+)', [$controller, 'update']);
        $this->router->delete('/api/shoppinglist/(\d+)', [$controller, 'delete']);
        $this->router->patch('/api/shoppinglist/(\d+)/check', [$controller, 'markAsChecked']);
    }

    protected function setCorsHeaders(): void
    {
        $this->router->options('/.*', function () {});

        if ($this->enviroment === 'production') {
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE, PATCH");
            header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
            header('Content-Type: application/json');
        }
    }
}