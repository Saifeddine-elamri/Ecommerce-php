<?php
require_once 'models/Product.php';
require_once 'models/User.php';
require_once 'models/Cart.php';

class CartController {

    private function isLoggedIn() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login?error=login_required');
            exit;
        }
    }

    public function index() {
        $this->isLoggedIn();

        $cartModel = new Cart();
        $productModel = new Product();
        $cartItems = $cartModel->getCart($_SESSION['user_id']);
        $products = [];
        $total = 0;

        foreach ($cartItems as $item) {
            $product = $productModel->getById($item['product_id']);
            if ($product) {
                $products[] = array_merge($product, ['quantity' => $item['quantity']]);
                $total += $product['price'] * $item['quantity'];
            }
        }

        require_once 'views/cart/index.php';
    }

    public function add() {
        $this->isLoggedIn();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $this->verifyCsrfToken()) {
            $productId = intval($_POST['product_id'] ?? 0);
            $quantity = max(1, intval($_POST['quantity'] ?? 1));

            $productModel = new Product();
            $product = $productModel->getById($productId);

            if ($product && $product['stock'] >= $quantity) {
                $cartModel = new Cart();
                $cartModel->add($_SESSION['user_id'], $productId, $quantity);
                header('Location: /products?success=added');
            } else {
                header('Location: /products?error=stock_insuffisant');
            }
            exit;
        }
    }

    public function remove() {
        $this->isLoggedIn();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $this->verifyCsrfToken()) {
            $productId = intval($_POST['product_id'] ?? 0);
            $cartModel = new Cart();
            $cartModel->remove($_SESSION['user_id'], $productId);
            header('Location: /cart?success=removed');
            exit;
        }
    }

    public function checkout() {
        $this->isLoggedIn();

        $cartModel = new Cart();
        $cartItems = $cartModel->getCart($_SESSION['user_id']);
        $productModel = new Product();
        $products = [];
        $total = 0;

        foreach ($cartItems as $item) {
            $product = $productModel->getById($item['product_id']);
            if ($product) {
                $products[] = array_merge($product, ['quantity' => $item['quantity']]);
                $total += $product['price'] * $item['quantity'];
            }
        }

        require_once 'views/cart/checkout.php';
    }

    public function order() {
        $this->isLoggedIn();

        $cartModel = new Cart();
        $cartItems = $cartModel->getCart($_SESSION['user_id']);
        $productModel = new Product();
        $products = [];
        $total = 0;

        if (empty($cartItems)) {
            $message = "Votre panier est vide.";
            require_once 'views/cart/order.php';
            return;
        }

        foreach ($cartItems as $item) {
            $product = $productModel->getById($item['product_id']);
            if (!$product || $product['stock'] < $item['quantity']) {
                header('Location: /cart?error=stock_insuffisant');
                exit;
            }
            $products[] = array_merge($product, ['quantity' => $item['quantity']]);
            $total += $product['price'] * $item['quantity'];
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $db = new Database();
            $conn = $db->getConnection();
            $conn->beginTransaction();

            try {
                // Insérer la commande
                $stmt = $conn->prepare("INSERT INTO orders (user_id, total) VALUES (:user_id, :total)");
                $stmt->execute(['user_id' => $_SESSION['user_id'], 'total' => $total]);
                $orderId = $conn->lastInsertId();

                // Insérer les articles
                foreach ($products as $item) {
                    $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) 
                                            VALUES (:order_id, :product_id, :quantity, :price)");
                    $stmt->execute([
                        'order_id' => $orderId,
                        'product_id' => $item['id'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price']
                    ]);
//                  $productModel->updateStock($item['id'], $item['quantity']);
                }

                $cartModel->clear($_SESSION['user_id']);
                $conn->commit();

                // Envoi du mail
            //  $userModel = new User();
            //  $user = $userModel->getById($_SESSION['user_id']);
            //  $this->sendOrderConfirmationEmail($user['email'], $orderId, $total);

                $message = "Commande passée avec succès ! Un email de confirmation a été envoyé.";
                require_once 'views/cart/order.php';

            } catch (Exception $e) {
                $conn->rollBack();
                $message = "Erreur lors de la commande : " . $e->getMessage();
                require_once 'views/cart/order.php';
            }
        } else {
            require_once 'views/cart/confirm.php';
        }
    }

    private function verifyCsrfToken() {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) {
            header('Location: /cart?error=invalid_csrf');
            exit;
        }
        return true;
    }

    private function sendOrderConfirmationEmail($email, $orderId, $total) {
        // Simulation d'envoi d'email
        $subject = "Confirmation de votre commande #$orderId";
        $message = "Merci pour votre commande !\nNuméro : $orderId\nTotal : $total €";
        $headers = "From: no-reply@ecommerce.com";
        mail($email, $subject, $message, $headers);
    }
}
