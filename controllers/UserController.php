<?php
require_once 'models/User.php';

class UserController {
    public function login() {
        require_once 'views/auth/login.php';
    }
}
?>