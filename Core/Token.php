<?php

namespace App\Core;

class Token
{
    // Nom de la clé de session pour stocker le jeton CSRF
    const CSRF_TOKEN_KEY = 'csrf_token';


    public static function tokenGenerator()
    {
        if (!isset($_SESSION['csrf_token'])) {
            // Génère un nouveau jeton CSRF
            $token = bin2hex(openssl_random_pseudo_bytes(32));
            // Stocke le jeton en session
            $_SESSION['csrf_token'] = $token;
        }

        // Retourne le jeton généré
        return $_SESSION['csrf_token'];
    }

    public static function tokenValidator($submittedToken)
    {
        // Vérifie si le jeton soumis est identique à celui stocké en session pour le formulaire spécifié
        if (isset($_SESSION['csrf_token']) && $_SESSION['csrf_token'] === $submittedToken) {
            // Le jeton est valide, on le supprime de la session pour qu'il ne puisse être réutilisé
            unset($_SESSION['csrf_token']);

            // Retourne vrai pour indiquer que la validation a réussi
            return true;
        }

        // Le jeton est invalide, on retourne faux
        return false;
    }
}
