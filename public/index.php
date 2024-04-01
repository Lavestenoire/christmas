<?php

use App\Autoloader;
use App\Core\Routeur;

session_start();

define('DEFAULT_PICTURE', 'picture/avatar.png');

include '../Autoloader.php';
Autoloader::register();
$route = new Routeur();

$route->routes();
