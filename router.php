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
        '/admin/orders/(\d+)' => ['controller' => 'AdminController', 'action' => 'viewOrder'], 
        '/admin/users' => ['controller' => 'AdminController', 'action' => 'users'],
        '/admin/user/(\d+)/edit' => ['controller' => 'AdminController', 'action' => 'editUser'],
        '/cart/add' => ['controller' => 'CartController', 'action' => 'add'],
        '/cart/remove' => ['controller' => 'CartController', 'action' => 'remove'],
        '/order' => ['controller' => 'CartController', 'action' => 'order'],
        '/search' => ['controller' => 'ProductController', 'action' => 'search'],
        '/review/add' => ['controller' => 'ProductController', 'action' => 'addReview'],
        '/favorite/add' => ['controller' => 'ProductController', 'action' => 'addFavorite'],
        '/favorite/remove' => ['controller' => 'ProductController', 'action' => 'removeFavorite'],
        '/checkout' => ['controller' => 'CartController', 'action' => 'checkout']
    ];

    public function route() {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Vérifier les routes
        foreach ($this->routes as $route => $config) {
            if (preg_match("#^$route$#", $path, $matches)) {
                array_shift($matches); // Retirer le match complet (l'URL)
                $controllerName = $config['controller'];
                $action = $config['action'];

                require_once "controllers/$controllerName.php";
                $controller = new $controllerName();

                // Appeler la méthode avec les paramètres dynamiques si présents
                call_user_func_array([$controller, $action], $matches);
                return;
            }
        }

        // Si aucune route ne correspond, afficher une erreur 404
        header("HTTP/1.0 404 Not Found");
        echo "Page not found";
    }
}
