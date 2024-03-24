<?php

namespace App\Controllers;

use App\Entities\User;

//controller qui conditionne l'entrée au site. LoginController à étendre dans tous les controller où il y a des routes à protéger et dans lesquelles on ajoute donc $this->protectedRoute

class LoginController extends Controller
{
    public function isLoggedIn()
    {
        return isset($_SESSION['username_user']);
    }

    public function protectRoute()
    {
        if (!$this->isLoggedIn()) {
            // Redirigez l'utilisateur vers la page de connexion s'il n'est pas connecté
            header("Location: /quizz/app_web/public/user/login");
            exit();
        }
    }
}


/* mettre ça: $this->protectRoute(); dans les méthodes rendant la vue à protéger par un loggin */