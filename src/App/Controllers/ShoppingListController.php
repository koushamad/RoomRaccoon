<?php

namespace Kousha\RoomRaccoon\App\Controllers;


use Kousha\RoomRaccoon\App\Models\ShoppingListModel;
use Kousha\RoomRaccoon\Core\Controller;

class ShoppingListController extends Controller
{
    private ShoppingListModel $model;

    public function __construct(ShoppingListModel $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        $items = $this->model->getItems();

        header('Content-Type: application/json');
        echo json_encode($items);
    }

    public function add()
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json);

        if (!isset($data->item_name) || !isset($data->quantity)) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid request data']);
            return;
        }

        $result = $this->model->addItem($data->item_name, $data->quantity);

        if ($result) {
            http_response_code(201);
            echo json_encode(['success' => 'Item added']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Could not add item']);
        }
    }

    public function update($id)
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json);

        if (!isset($data->item_name) || !isset($data->quantity)) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid request data']);
            return;
        }

        $result = $this->model->updateItem($id, $data->item_name, $data->quantity);

        if ($result) {
            http_response_code(200);
            echo json_encode(['success' => 'Item updated']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Could not update item']);
        }
    }

    public function delete($id)
    {
        $result = $this->model->deleteItem($id);

        if ($result) {
            http_response_code(200);
            echo json_encode(['success' => 'Item deleted']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Could not delete item']);
        }
    }

    public function markAsChecked($id)
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json);

        if (!isset($data->checked)) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid request data']);
            return;
        }

        $result = $this->model->markItemAsChecked($id, $data->checked);

        if ($result) {
            http_response_code(200);
            echo json_encode(['success' => 'Item marked as checked']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Could not mark item as checked']);
        }
    }
}