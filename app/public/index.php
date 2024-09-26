<?php
include_once '../src/App.php';
use \Router\Router;
$router = new Router();

$router->route($_SERVER['REQUEST_URI'],$_SERVER['REQUEST_METHOD']);
?>