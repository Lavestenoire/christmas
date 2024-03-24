<?php

namespace App\Core;

class Token
{
    static function tokenGenerator()
    {
        if (!isset($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
        }
    }

    static function tokenValidator()
    {
        if (isset($_SESSION['token']) && isset($_POST['token'])) {
            if ($_SESSION['token'] == $_POST['token']) {
                unset($_SESSION['token']);
                return true;
            } else {
                return false;
            }
        }
    }
}
