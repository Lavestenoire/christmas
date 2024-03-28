<?php

use App\Autoloader;
use App\Core\Routeur;

session_start();

include '../Autoloader.php';
Autoloader::register();
$route = new Routeur();

$route->routes();
