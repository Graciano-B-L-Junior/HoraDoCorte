<?php
include_once '../src/App.php';
use \Router\Router;
$router = new Router();
$router->route(parse_url($_SERVER['REQUEST_URI'])['path'],$_SERVER['REQUEST_METHOD']);
?>