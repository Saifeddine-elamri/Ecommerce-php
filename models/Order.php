<?php
require_once 'config/database.php';

class Order {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Récupérer les commandes d'un utilisateur
    public function getByUserId($userId) {
        $stmt = $this->conn->prepare("
            SELECT o.*, u.username 
            FROM orders o 
            JOIN users u ON o.user_id = u.id
            WHERE o.user_id = :user_id
            ORDER BY o.created_at DESC
        ");
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer une commande par son ID
    public function getById($id) {
        $stmt = $this->conn->prepare("
            SELECT * 
            FROM orders 
            WHERE id = :id
        ");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
