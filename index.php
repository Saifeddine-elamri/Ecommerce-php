<?php
session_start();
require_once 'router.php';

$router = new Router();
$router->route();
?>