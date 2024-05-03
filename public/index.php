<?php

use App\Autoloader;
use App\Core\Routeur;

define('DEFAULT_AVATAR', 'pictures/avatar.png');

include '../Autoloader.php';
Autoloader::register();
$route = new Routeur();

$route->routes();
