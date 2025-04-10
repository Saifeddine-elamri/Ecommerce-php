<?php
class Router {
    private $routes = [
        '/' => ['controller' => 'ProductController', 'action' => 'index'],
        '/products' => ['controller' => 'ProductController', 'action' => 'index'],
        '/cart' => ['controller' => 'CartController', 'action' => 'index'],
        '/login' => ['controller' => 'UserController', 'action' => 'login'],
        '/cart/add' => ['controller' => 'CartController', 'action' => 'add'],
        '/cart/remove' => ['controller' => 'CartController', 'action' => 'remove'],
        '/order' => ['controller' => 'CartController', 'action' => 'order']
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