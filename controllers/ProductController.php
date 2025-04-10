<?php
require_once 'models/Product.php';
require_once 'models/User.php';
require_once 'models/Cart.php';

class ProductController {
    public function index() {
        $productModel = new Product();
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $perPage = 6;
        $categoryId = isset($_GET['category']) ? (int)$_GET['category'] : null;
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'name_asc';
        $stockFilter = isset($_GET['stock']) ? $_GET['stock'] : null;

        $totalProducts = $productModel->getTotalCount($categoryId, $stockFilter);
        $totalPages = ceil($totalProducts / $perPage);
        $products = $productModel->getPaginated($page, $perPage, $categoryId, $sort, $stockFilter);
        $categories = $productModel->getCategories();
        $viewedProducts = isset($_SESSION['user_id']) ? $productModel->getViewedProducts($_SESSION['user_id']) : [];
        $suggestedProducts = $productModel->getSuggestedProducts(isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null);

        require_once 'views/products/index.php';
    }

    public function show() {
        if (!isset($_GET['id'])) {
            header('Location: /products?error=missing_id');
            exit;
        }
        $productModel = new Product();
        $product = $productModel->getById($_GET['id']);
        $reviews = $productModel->getReviews($_GET['id']);
        $isFavorite = isset($_SESSION['user_id']) ? $productModel->isFavorite($_SESSION['user_id'], $_GET['id']) : false;
        if (!$product) {
            header('Location: /products?error=product_not_found');
            exit;
        }
        if (isset($_SESSION['user_id'])) {
            $productModel->addViewHistory($_SESSION['user_id'], $_GET['id']);
        }
        require_once 'views/products/show.php';
    }

    public function search() {
        $productModel = new Product();
        $search = isset($_GET['q']) ? trim($_GET['q']) : '';
        $minPrice = isset($_GET['min_price']) ? (float)$_GET['min_price'] : null;
        $maxPrice = isset($_GET['max_price']) ? (float)$_GET['max_price'] : null;
        $products = $productModel->search($search, $minPrice, $maxPrice);
        require_once 'views/products/search.php';
    }

    public function addReview() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login?error=login_required');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $this->verifyCsrfToken()) {
            $productId = $_POST['product_id'] ?? '';
            $rating = (int)($_POST['rating'] ?? 0);
            $comment = trim($_POST['comment'] ?? '');
            if ($rating < 1 || $rating > 5 || empty($productId)) {
                header('Location: /product?id=' . $productId . '&error=invalid_review');
                exit;
            }
            $productModel = new Product();
            $productModel->addReview($productId, $_SESSION['user_id'], $rating, $comment);
            header('Location: /product?id=' . $productId . '&success=review_added');
            exit;
        }
    }

    public function addFavorite() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login?error=login_required');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $this->verifyCsrfToken()) {
            $productId = $_POST['product_id'] ?? '';
            $productModel = new Product();
            $productModel->addFavorite($_SESSION['user_id'], $productId);
            header('Location: /product?id=' . $productId . '&success=favorite_added');
            exit;
        }
    }

    public function removeFavorite() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login?error=login_required');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $this->verifyCsrfToken()) {
            $productId = $_POST['product_id'] ?? '';
            $productModel = new Product();
            $productModel->removeFavorite($_SESSION['user_id'], $productId);
            header('Location: /product?id=' . $productId . '&success=favorite_removed');
            exit;
        }
    }

    private function verifyCsrfToken() {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            header('Location: /products?error=invalid_csrf');
            exit;
        }
        return true;
    }
}
?>