<?php
require_once 'config/database.php';

class Product {
    private $conn;
    
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAll() {
        $stmt = $this->conn->prepare("
            SELECT p.*, c.name AS category_name 
            FROM products p 
            LEFT JOIN categories c ON p.category_id = c.id
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("
            SELECT p.*, c.name AS category_name 
            FROM products p 
            LEFT JOIN categories c ON p.category_id = c.id 
            WHERE p.id = :id
        ");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateStock($id, $quantity) {
        $stmt = $this->conn->prepare("
            UPDATE products 
            SET stock = stock - :quantity 
            WHERE id = :id
        ");
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function getPaginated($page, $perPage, $categoryId = null, $sort = 'name_asc', $stockFilter = null) {
        $offset = ($page - 1) * $perPage;
        $query = "
            SELECT p.*, c.name AS category_name 
            FROM products p 
            LEFT JOIN categories c ON p.category_id = c.id 
            WHERE 1=1
        ";
        $params = [];

        if ($categoryId) {
            $query .= " AND p.category_id = :category_id";
            $params[':category_id'] = $categoryId;
        }

        if ($stockFilter === 'in_stock') {
            $query .= " AND p.stock > 0";
        }

        switch ($sort) {
            case 'price_asc':  $query .= " ORDER BY p.price ASC"; break;
            case 'price_desc': $query .= " ORDER BY p.price DESC"; break;
            case 'name_desc':  $query .= " ORDER BY p.name DESC"; break;
            default:           $query .= " ORDER BY p.name ASC"; break;
        }

        $query .= " LIMIT :offset, :perPage";

        $stmt = $this->conn->prepare($query);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value, PDO::PARAM_INT);
        }
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':perPage', $perPage, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalCount($categoryId = null, $stockFilter = null) {
        $query = "SELECT COUNT(*) FROM products WHERE 1=1";
        $params = [];

        if ($categoryId) {
            $query .= " AND category_id = :category_id";
            $params[':category_id'] = $categoryId;
        }

        if ($stockFilter === 'in_stock') {
            $query .= " AND stock > 0";
        }

        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }

    public function search($search, $minPrice, $maxPrice) {
        $query = "
            SELECT p.*, c.name AS category_name 
            FROM products p 
            LEFT JOIN categories c ON p.category_id = c.id 
            WHERE 1=1
        ";
        $params = [];

        if (!empty($search)) {
            $query .= " AND p.name LIKE :search";
            $params[':search'] = "%$search%";
        }

        if ($minPrice !== null) {
            $query .= " AND p.price >= :minPrice";
            $params[':minPrice'] = $minPrice;
        }

        if ($maxPrice !== null) {
            $query .= " AND p.price <= :maxPrice";
            $params[':maxPrice'] = $maxPrice;
        }

        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategories() {
        $stmt = $this->conn->prepare("SELECT * FROM categories");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getReviews($productId) {
        $stmt = $this->conn->prepare("
            SELECT r.*, u.username 
            FROM reviews r 
            LEFT JOIN users u ON r.user_id = u.id 
            WHERE r.product_id = :product_id 
            ORDER BY r.created_at DESC
        ");
        $stmt->bindParam(':product_id', $productId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addReview($productId, $userId, $rating, $comment) {
        $stmt = $this->conn->prepare("
            INSERT INTO reviews (product_id, user_id, rating, comment) 
            VALUES (:product_id, :user_id, :rating, :comment)
        ");
        $stmt->execute([
            ':product_id' => $productId,
            ':user_id' => $userId,
            ':rating' => $rating,
            ':comment' => $comment
        ]);
    }

    public function isFavorite($userId, $productId) {
        $stmt = $this->conn->prepare("
            SELECT COUNT(*) 
            FROM favorites 
            WHERE user_id = :user_id AND product_id = :product_id
        ");
        $stmt->execute([
            ':user_id' => $userId, 
            ':product_id' => $productId
        ]);
        return $stmt->fetchColumn() > 0;
    }

    public function addFavorite($userId, $productId) {
        $stmt = $this->conn->prepare("
            INSERT IGNORE INTO favorites (user_id, product_id) 
            VALUES (:user_id, :product_id)
        ");
        $stmt->execute([
            ':user_id' => $userId, 
            ':product_id' => $productId
        ]);
    }

    public function removeFavorite($userId, $productId) {
        $stmt = $this->conn->prepare("
            DELETE FROM favorites 
            WHERE user_id = :user_id AND product_id = :product_id
        ");
        $stmt->execute([
            ':user_id' => $userId, 
            ':product_id' => $productId
        ]);
    }

    public function addViewHistory($userId, $productId) {
        $stmt = $this->conn->prepare("
            INSERT INTO view_history (user_id, product_id) 
            VALUES (:user_id, :product_id)
        ");
        $stmt->execute([
            ':user_id' => $userId, 
            ':product_id' => $productId
        ]);
    }

    public function getViewedProducts($userId) {
        $stmt = $this->conn->prepare("
            SELECT DISTINCT p.*, c.name AS category_name, vh.viewed_at 
            FROM view_history vh 
            JOIN products p ON vh.product_id = p.id 
            LEFT JOIN categories c ON p.category_id = c.id 
            WHERE vh.user_id = :user_id 
            ORDER BY vh.viewed_at DESC 
            LIMIT 5
        ");
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSuggestedProducts($userId) {
        $query = "
            SELECT p.*, c.name AS category_name 
            FROM products p 
            LEFT JOIN categories c ON p.category_id = c.id 
            WHERE p.category_id IN (
                SELECT p2.category_id 
                FROM favorites f 
                JOIN products p2 ON f.product_id = p2.id 
                WHERE f.user_id = :user_id
                UNION
                SELECT p3.category_id 
                FROM view_history vh 
                JOIN products p3 ON vh.product_id = p3.id 
                WHERE vh.user_id = :user_id
            ) AND p.id NOT IN (
                SELECT product_id FROM favorites WHERE user_id = :user_id
            )
            ORDER BY RAND() 
            LIMIT 4
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addProduct($name, $price, $stock, $categoryId, $description, $image) {
        $stmt = $this->conn->prepare("
            INSERT INTO products (name, price, stock, category_id, description, image) 
            VALUES (:name, :price, :stock, :category_id, :description, :image)
        ");
        $stmt->execute([
            ':name' => $name,
            ':price' => $price,
            ':stock' => $stock,
            ':category_id' => $categoryId,
            ':description' => $description,
            ':image' => $image
        ]);
    }

    public function updateProduct($id, $name, $price, $stock, $categoryId, $description, $image) {
        $stmt = $this->conn->prepare("
            UPDATE products 
            SET name = :name, price = :price, stock = :stock, category_id = :category_id, 
                description = :description, image = :image 
            WHERE id = :id
        ");
        $stmt->execute([
            ':id' => $id,
            ':name' => $name,
            ':price' => $price,
            ':stock' => $stock,
            ':category_id' => $categoryId,
            ':description' => $description,
            ':image' => $image
        ]);
    }
}
?>