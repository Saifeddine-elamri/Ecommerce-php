<?php
require_once 'models/User.php';
require_once 'models/Product.php';
require_once 'models/Cart.php';

class UserController {
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';
            if (empty($username) || empty($password)) {
                $error = "Veuillez remplir tous les champs.";
            } else {
                $userModel = new User();
                $user = $userModel->login($username, $password);
                if ($user) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    header('Location: /products?success=logged_in');
                    exit;
                } else {
                    $error = "Nom d'utilisateur ou mot de passe incorrect.";
                }
            }
        }
        require_once 'views/auth/login.php';
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
                $error = "Veuillez remplir tous les champs.";
            } elseif ($password !== $confirm_password) {
                $error = "Les mots de passe ne correspondent pas.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Adresse email invalide.";
            } else {
                $userModel = new User();
                if ($userModel->register($username, $email, $password)) {
                    header('Location: /login?success=registered');
                    exit;
                } else {
                    $error = "Ce nom d'utilisateur ou email est déjà pris.";
                }
            }
        }
        require_once 'views/auth/register.php';
    }

    public function logout() {
        session_destroy();
        header('Location: /login?success=logged_out');
        exit;
    }

    public function orders() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login?error=login_required');
            exit;
        }
        $userModel = new User();
        $orders = $userModel->getOrders($_SESSION['user_id']);
        require_once 'views/auth/orders.php';
    }

    public function profile() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login?error=login_required');
            exit;
        }
        $userModel = new User();
        $user = $userModel->getById($_SESSION['user_id']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $this->verifyCsrfToken()) {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($username) || empty($email)) {
                $error = "Veuillez remplir tous les champs obligatoires.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Adresse email invalide.";
            } else {
                if ($userModel->updateProfile($_SESSION['user_id'], $username, $email, $password)) {
                    $_SESSION['username'] = $username;
                    $success = "Profil mis à jour avec succès !";
                } else {
                    $error = "Erreur lors de la mise à jour. Vérifiez les doublons.";
                }
            }
        }
        require_once 'views/auth/profile.php';
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