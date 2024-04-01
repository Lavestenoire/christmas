<?php

namespace App\Core;

class Token
{
    // Nom de la clé de session pour stocker le jeton CSRF
    const CSRF_TOKEN_KEY = 'csrf_token';


    public static function tokenGenerator()
    {
        // Génère un nouveau jeton CSRF
        $token = bin2hex(openssl_random_pseudo_bytes(32));
        // Stocke le jeton en session
        // $_SESSION[self::CSRF_TOKEN_KEY] = $token;
        // pour avoir un jeton différent pour chaque formulaire:
        $_SESSION[self::CSRF_TOKEN_KEY] = $token;

        // Retourne le jeton généré
        return $token;
    }

    public static function tokenValidator($submittedToken)
    {
        // Vérifie si le jeton soumis est identique à celui stocké en session
        if (isset($_SESSION[self::CSRF_TOKEN_KEY]) && $_SESSION[self::CSRF_TOKEN_KEY] === $submittedToken) {
            // Le jeton est valide, on le supprime de la session pour qu'il ne puisse être réutilisé
            unset($_SESSION[self::CSRF_TOKEN_KEY]);

            // Retourne vrai pour indiquer que la validation a réussi
            return true;
        }

        // Le jeton est invalide, on retourne faux
        return false;
    }
}
