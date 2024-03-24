<?php

namespace App\Core;


class Validator
{
    static function control($liste)
    {
        foreach ($liste as $key => $value) {
            if ($value == '') {
                return false;
            }
        }

        foreach ($liste as $key => $value) {
            if ($value != '') {
                return true;
            }
        }
    }
}


/* EXEMPLE D'UTILISATION DU VALIDATOR
$formData = [
    'name' => 'John',
    'email' => '',
    'password' => 'password123'
];

if (Validator::control($formData)) {
    // toutes les valeurs sont remplies
    // traiter les données du formulaire
} else {
    // une ou plusieurs valeurs sont vides
    // afficher un message d'erreur à l'utilisateur
}
 */