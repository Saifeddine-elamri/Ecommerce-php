<?php
require_once 'config/database.php';

class Cart {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getCart($userId) {
        $stmt = $this->conn->prepare("SELECT * FROM cart_items WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add($userId, $productId, $quantity) {
        $stmt = $this->conn->prepare("
            INSERT INTO cart_items (user_id, product_id, quantity) 
            VALUES (:user_id, :product_id, :quantity)
            ON DUPLICATE KEY UPDATE quantity = quantity + :quantity
        ");
        $stmt->execute([':user_id' => $userId, ':product_id' => $productId, ':quantity' => $quantity]);
    }

    public function remove($userId, $productId) {
        $stmt = $this->conn->prepare("DELETE FROM cart_items WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute([':user_id' => $userId, ':product_id' => $productId]);
    }

    public function clear($userId) {
        $stmt = $this->conn->prepare("DELETE FROM cart_items WHERE user_id = :user_id");
        $stmt->execute([':user_id' => $userId]);
    }
}
?>