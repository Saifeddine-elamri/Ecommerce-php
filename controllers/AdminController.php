<?php
require_once 'models/Product.php';
require_once 'models/User.php';
require_once 'models/Cart.php';
require_once 'models/Order.php';

class AdminController {
    private function checkAdmin() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login?error=login_required');
            exit;
        }
        $userModel = new User();
        $user = $userModel->getById($_SESSION['user_id']);
        if (!$user['is_admin']) {
            header('Location: /products?error=access_denied');
            exit;
        }
    }

    public function index() {
        $this->checkAdmin();
        require_once 'views/admin/index.php';
    }

    public function products() {
        $this->checkAdmin();
        $productModel = new Product();
        $products = $productModel->getAll();
        $categories = $productModel->getCategories();
        require_once 'views/admin/products.php';
    }

    public function addProduct() {
        $this->checkAdmin();
        $productModel = new Product();
        $categories = $productModel->getCategories();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $this->verifyCsrfToken()) {
            $name = trim($_POST['name'] ?? '');
            $price = (float)($_POST['price'] ?? 0);
            $stock = (int)($_POST['stock'] ?? 0);
            $categoryId = (int)($_POST['category_id'] ?? 0);
            $description = trim($_POST['description'] ?? '');
            $image = trim($_POST['image'] ?? 'default.jpg');

            if (empty($name) || $price <= 0 || $stock < 0 || $categoryId <= 0) {
                $error = "Tous les champs obligatoires doivent être remplis correctement.";
            } else {
                $productModel->addProduct($name, $price, $stock, $categoryId, $description, $image);
                header('Location: /admin/products?success=product_added');
                exit;
            }
        }
        require_once 'views/admin/add_product.php';
    }

    public function editProduct() {
        $this->checkAdmin();
        $productModel = new Product();
        $categories = $productModel->getCategories();

        if (!isset($_GET['id'])) {
            header('Location: /admin/products?error=missing_id');
            exit;
        }
        $product = $productModel->getById($_GET['id']);
        if (!$product) {
            header('Location: /admin/products?error=product_not_found');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $this->verifyCsrfToken()) {
            $name = trim($_POST['name'] ?? '');
            $price = (float)($_POST['price'] ?? 0);
            $stock = (int)($_POST['stock'] ?? 0);
            $categoryId = (int)($_POST['category_id'] ?? 0);
            $description = trim($_POST['description'] ?? '');
            $image = trim($_POST['image'] ?? 'default.jpg');

            if (empty($name) || $price <= 0 || $stock < 0 || $categoryId <= 0) {
                $error = "Tous les champs obligatoires doivent être remplis correctement.";
            } else {
                $productModel->updateProduct($_GET['id'], $name, $price, $stock, $categoryId, $description, $image);
                header('Location: /admin/products?success=product_updated');
                exit;
            }
        }
        require_once 'views/admin/edit_product.php';
    }

    public function orders() {
        $this->checkAdmin();
        $userModel = new User();
        $orders = $userModel->getAllOrders();
        require_once 'views/admin/orders.php';
    }

    private function verifyCsrfToken() {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            header('Location: /admin?error=invalid_csrf');
            exit;
        }
        return true;
    }

    public function users() {
        // Vérifier que l'utilisateur est authentifié et a les droits d'accès
        $this->checkAdmin();
        $userModel = new User();

        // Exemple de récupération des utilisateurs
        $users = $userModel->getAllUsers();  // Supposons que tu as une méthode pour récupérer tous les utilisateurs

        // Charger la vue
        require_once 'views/admin/users.php';
    }

    public function viewOrder($userId) {
        // Récupérer les commandes de l'utilisateur $userId
        $orderModel = new Order();
        $orders = $orderModel->getByUserId($userId);
        
        // Afficher la vue
        require_once 'views/admin/user_orders.php';
    }
}
?>