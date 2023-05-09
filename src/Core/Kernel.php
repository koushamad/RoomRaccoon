<?php

namespace Kousha\RoomRaccoon\Core;

use Bramus\Router\Router;
use Kousha\RoomRaccoon\App\Route;
use Pimple\Container;
use Kousha\RoomRaccoon\App\Controllers\ShoppingListController;
use Kousha\RoomRaccoon\App\Models\ShoppingListModel;
use Exception;

class Kernel
{
    private Container $container;
    private Router $router;

    public function __construct()
    {
        $this->container = new Container();
        $this->registerServices();
        $this->router = new Router();
        $this->registerRoutes();
    }

    public function run(): void
    {
        try {
            $this->router->run();
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }

    private function registerServices(): void
    {
        $config = require __DIR__ . '/../config.php';
        $this->container['config'] = $config;


        $this->container['database'] = function ($c) {
            return Database::getInstance($c['config']['database'])->getConnection();
        };

        $this->container['shoppingListModel'] = function ($c) {
            return new ShoppingListModel($c['database']);
        };

        $this->container['shoppingListController'] = function ($c) {
            return new ShoppingListController($c['shoppingListModel']);
        };
    }

    private function registerRoutes(): void
    {
        $route = new Route($this->router, $this->container);
        $route->registerRoutes();
    }

    private function handleException(Exception $e): void
    {
        http_response_code(500);
        header('Content-Type: application/json');
        echo json_encode([
            'error' => 'An internal server error occurred',
            'message' => $e->getMessage()
        ]);
    }

    public function getContainer(string $name)
    {
        return $this->container->offsetGet($name);
    }
}
