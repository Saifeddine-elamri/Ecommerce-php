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
                header('Location: /products?success=added');
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
            header('Location: /cart?success=removed');
            exit;
        }
    }

    public function order() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login?error=login_required');
            exit;
        }

        $cartModel = new Cart();
        $cartItems = $cartModel->getCart();
        $productModel = new Product();
        $products = [];
        $total = 0;

        if (!empty($cartItems)) {
            foreach ($cartItems as $productId => $quantity) {
                $product = $productModel->getById($productId);
                if ($product && $product['stock'] >= $quantity) {
                    $products[] = array_merge($product, ['quantity' => $quantity]);
                    $total += $product['price'] * $quantity;
                } else {
                    header('Location: /cart?error=stock_insuffisant');
                    exit;
                }
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Enregistrer la commande
                $db = new Database();
                $conn = $db->getConnection();
                $conn->beginTransaction();

                try {
                    // Insérer la commande
                    $stmt = $conn->prepare("INSERT INTO orders (user_id, total) VALUES (:user_id, :total)");
                    $stmt->execute(['user_id' => $_SESSION['user_id'], 'total' => $total]);
                    $orderId = $conn->lastInsertId();

                    // Insérer les articles de la commande et mettre à jour le stock
                    foreach ($products as $item) {
                        $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)");
                        $stmt->execute(['order_id' => $orderId, 'product_id' => $item['id'], 'quantity' => $item['quantity'], 'price' => $item['price']]);
                        $productModel->updateStock($item['id'], $item['quantity']);
                    }

                    $conn->commit();
                    $_SESSION['cart'] = [];
                    $message = "Commande passée avec succès !";
                    require_once 'views/cart/order.php';
                } catch (Exception $e) {
                    $conn->rollBack();
                    $message = "Erreur lors de la commande : " . $e->getMessage();
                    require_once 'views/cart/order.php';
                }
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