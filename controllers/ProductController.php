<?php
require_once 'models/Product.php';

class ProductController {
    public function index() {
        $productModel = new Product();
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $perPage = 6; // Produits par page
        $totalProducts = $productModel->getTotalCount();
        $totalPages = ceil($totalProducts / $perPage);
        $products = $productModel->getPaginated($page, $perPage);
        require_once 'views/products/index.php';
    }

    public function search() {
        $productModel = new Product();
        $search = isset($_GET['q']) ? trim($_GET['q']) : '';
        $minPrice = isset($_GET['min_price']) ? (float)$_GET['min_price'] : null;
        $maxPrice = isset($_GET['max_price']) ? (float)$_GET['max_price'] : null;
        $products = $productModel->search($search, $minPrice, $maxPrice);
        require_once 'views/products/search.php';
    }
}
?>