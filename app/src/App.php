<?php
include_once 'Router/Route.php';
include_once 'Superadm/Generatedb.php';
use Router\Router;
use superadm\GenerateDB;

 $instance = new GenerateDB("FRANCA","franca","franca123");
 $instance->generate_database();
 $instance->generate_tables();
?>