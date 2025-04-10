<?php
require_once 'models/Cart.php';
require_once 'models/Product.php';

class CartController {
    public function index() {
        $cartModel = new Cart();
        $cartItems = $cartModel->getCart();
        $productModel = new Product();
        $products = [];
        $total = 0;
        foreach ($cartItems as $productId => $quantity) {
            $product = $productModel->getById($productId);
            if ($product) {
                $products[] = array_merge($product, ['quantity' => $quantity]);
                $total += $product['price'] * $quantity;
            }
        }
        require_once 'views/cart/index.php';
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id']) && isset($_POST['quantity'])) {
            $productId = $_POST['product_id'];
            $quantity = (int)$_POST['quantity'];
            $productModel = new Product();
            $product = $productModel->getById($productId);
            
            if ($product && $product['stock'] >= $quantity) {
                $cartModel = new Cart();
                $cartModel->add($productId, $quantity);
                header('Location: /products');
            } else {
                header('Location: /products?error=stock_insuffisant');
            }
            exit;
        }
    }

    public function remove() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
            $cartModel = new Cart();
            $cartModel->remove($_POST['product_id']);
            header('Location: /cart');
            exit;
        }
    }

    public function order() {
        $cartModel = new Cart();
        $cartItems = $cartModel->getCart();
        $productModel = new Product();
        $products = [];
        $total = 0;

        if (!empty($cartItems)) {
            foreach ($cartItems as $productId => $quantity) {
                $product = $productModel->getById($productId);
                if ($product) {
                    $products[] = array_merge($product, ['quantity' => $quantity]);
                    $total += $product['price'] * $quantity;
                }
            }
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Simulation de la commande
                $_SESSION['cart'] = [];
                $message = "Commande passée avec succès !";
                require_once 'views/cart/order.php';
            } else {
                require_once 'views/cart/confirm.php';
            }
        } else {
            $message = "Votre panier est vide.";
            require_once 'views/cart/order.php';
        }
    }
}
?>