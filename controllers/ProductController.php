<?php
require_once 'models/Product.php';

class ProductController {
    public function index() {
        $productModel = new Product();
        $products = $productModel->getAll();
        require_once 'views/products/index.php';
    }
}
?>