<?php


include '../Core/Routeur.php';
include '../Controllers/Controller.php';
include '../Controllers/HomeController.php';
// include '../Controllers/UserController.php';
/* Ici on inclie tous les controllers + on instancie le Router et on exécute à l'objet la méthode route
 */

$route = new Routeur();

$route->routes();
