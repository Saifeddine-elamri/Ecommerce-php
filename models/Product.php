<?php
require_once 'config/database.php';

class Product {
    private $conn;
    
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAll() {
        $stmt = $this->conn->prepare("SELECT * FROM products");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateStock($id, $quantity) {
        $stmt = $this->conn->prepare("UPDATE products SET stock = stock - :quantity WHERE id = :id");
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function getPaginated($page, $perPage) {
        $offset = ($page - 1) * $perPage;
        $stmt = $this->conn->prepare("SELECT * FROM products LIMIT :offset, :perPage");
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':perPage', $perPage, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalCount() {
        $stmt = $this->conn->query("SELECT COUNT(*) FROM products");
        return $stmt->fetchColumn();
    }

    public function search($search, $minPrice, $maxPrice) {
        $query = "SELECT * FROM products WHERE 1=1";
        $params = [];
        
        if (!empty($search)) {
            $query .= " AND name LIKE :search";
            $params[':search'] = "%$search%";
        }
        if ($minPrice !== null) {
            $query .= " AND price >= :minPrice";
            $params[':minPrice'] = $minPrice;
        }
        if ($maxPrice !== null) {
            $query .= " AND price <= :maxPrice";
            $params[':maxPrice'] = $maxPrice;
        }

        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>