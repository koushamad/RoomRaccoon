<?php

namespace Kousha\RoomRaccoon\app;

use Bramus\Router\Router;
use Kousha\RoomRaccoon\App\Controllers\ShoppingListController;
use Pimple\Container;

class Route {
    private Router $router;
    private ShoppingListController $shoppingListController;

    public function __construct(Router $router, Container $container) {
        $this->router = $router;
        $this->shoppingListController = $container['shoppingListController'];
    }

    public function registerRoutes(): void
    {
        $controller = $this->shoppingListController;

        $this->router->get('/api/shoppinglist', [$controller, 'index']);
        $this->router->post('/api/shoppinglist', [$controller, 'add']);
        $this->router->put('/api/shoppinglist/(\d+)', [$controller, 'update']);
        $this->router->delete('/api/shoppinglist/(\d+)', [$controller, 'delete']);
        $this->router->patch('/api/shoppinglist/(\d+)/check', [$controller, 'markAsChecked']);
    }
}