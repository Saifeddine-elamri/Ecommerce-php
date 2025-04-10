<?php
class Router {
    private $routes = [
        '/' => ['controller' => 'ProductController', 'action' => 'index'],
        '/products' => ['controller' => 'ProductController', 'action' => 'index'],
        '/product' => ['controller' => 'ProductController', 'action' => 'show'],
        '/cart' => ['controller' => 'CartController', 'action' => 'index'],
        '/login' => ['controller' => 'UserController', 'action' => 'login'],
        '/register' => ['controller' => 'UserController', 'action' => 'register'],
        '/logout' => ['controller' => 'UserController', 'action' => 'logout'],
        '/orders' => ['controller' => 'UserController', 'action' => 'orders'],
        '/profile' => ['controller' => 'UserController', 'action' => 'profile'],
        '/admin' => ['controller' => 'AdminController', 'action' => 'index'],
        '/admin/products' => ['controller' => 'AdminController', 'action' => 'products'],
        '/admin/product/add' => ['controller' => 'AdminController', 'action' => 'addProduct'],
        '/admin/product/edit' => ['controller' => 'AdminController', 'action' => 'editProduct'],
        '/admin/orders' => ['controller' => 'AdminController', 'action' => 'orders'],
        '/cart/add' => ['controller' => 'CartController', 'action' => 'add'],
        '/cart/remove' => ['controller' => 'CartController', 'action' => 'remove'],
        '/order' => ['controller' => 'CartController', 'action' => 'order'],
        '/search' => ['controller' => 'ProductController', 'action' => 'search'],
        '/review/add' => ['controller' => 'ProductController', 'action' => 'addReview'],
        '/favorite/add' => ['controller' => 'ProductController', 'action' => 'addFavorite'],
        '/favorite/remove' => ['controller' => 'ProductController', 'action' => 'removeFavorite']
    ];

    public function route() {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        if (array_key_exists($path, $this->routes)) {
            $controllerName = $this->routes[$path]['controller'];
            $action = $this->routes[$path]['action'];
            
            require_once "controllers/$controllerName.php";
            $controller = new $controllerName();
            $controller->$action();
        } else {
            header("HTTP/1.0 404 Not Found");
            echo "Page not found";
        }
    }
}
?>