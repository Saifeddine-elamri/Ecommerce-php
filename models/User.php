<?php
require_once 'config/database.php';

class User {
    private $conn;
    
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function login($username, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public function register($username, $email, $password) {
        $stmt = $this->conn->prepare("SELECT id FROM users WHERE username = :username OR email = :email");
        $stmt->execute([':username' => $username, ':email' => $email]);
        if ($stmt->fetch()) {
            return false;
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
        return $stmt->execute([':username' => $username, ':email' => $email, ':password' => $hashedPassword]);
    }

    public function getById($userId) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $userId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProfile($userId, $username, $email, $password) {
        $query = "UPDATE users SET username = :username, email = :email";
        $params = [':username' => $username, ':email' => $email, ':id' => $userId];
        
        if (!empty($password)) {
            $query .= ", password = :password";
            $params[':password'] = password_hash($password, PASSWORD_DEFAULT);
        }
        $query .= " WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        return $stmt->execute($params);
    }

    public function getOrders($userId) {
        $stmt = $this->conn->prepare("
            SELECT o.id, o.total, o.created_at, oi.product_id, oi.quantity, oi.price, p.name 
            FROM orders o 
            LEFT JOIN order_items oi ON o.id = oi.order_id 
            LEFT JOIN products p ON oi.product_id = p.id 
            WHERE o.user_id = :user_id
        ");
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllOrders() {
        $stmt = $this->conn->prepare("
            SELECT o.id, o.user_id, o.total, o.created_at, u.username, oi.product_id, oi.quantity, oi.price, p.name 
            FROM orders o 
            LEFT JOIN order_items oi ON o.id = oi.order_id 
            LEFT JOIN products p ON oi.product_id = p.id 
            LEFT JOIN users u ON o.user_id = u.id 
            ORDER BY o.created_at DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>