<?php

namespace Kousha\RoomRaccoon\App\Models;

use PDO;

class ShoppingListModel {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function getItems(): bool|array
    {
        $sql = 'SELECT * FROM shopping_list';
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addItem($item_name, $quantity): bool
    {
        $sql = 'INSERT INTO shopping_list (item_name, quantity) VALUES (:item_name, :quantity)';
        $query = $this->db->prepare($sql);
        $parameters = [
            ':item_name' => $item_name,
            ':quantity' => $quantity
        ];

        return $query->execute($parameters);
    }

    public function updateItem($id, $item_name, $quantity): bool
    {
        $sql = 'UPDATE shopping_list SET item_name = :item_name, quantity = :quantity WHERE id = :id';
        $query = $this->db->prepare($sql);
        $parameters = [
            ':id' => $id,
            ':item_name' => $item_name,
            ':quantity' => $quantity
        ];

        return $query->execute($parameters);
    }

    public function deleteItem($id): bool
    {
        $sql = 'DELETE FROM shopping_list WHERE id = :id';
        $query = $this->db->prepare($sql);
        $parameters = [
            ':id' => $id
        ];

        return $query->execute($parameters);
    }

    public function markItemAsChecked($id) {
        $sql = 'UPDATE shopping_list SET checked = 1 WHERE id = :id';
        $query = $this->db->prepare($sql);
        $parameters = [
            ':id' => $id
        ];

        return $query->execute($parameters);
    }
}