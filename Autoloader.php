<?php

namespace App;

class Autoloader
{
    // une méthode statique appartient à une classe mais peut être appelée sans être instanciée. Contrairement aux méthodes non statiques, les méthodes statiques ne peuvent pas accéder aux propriétés non statiques de la classe ou appeler des méthodes non statiques de la classe. Elles sont destinées à être utilisées pour effectuer des tâches spécifiques liées à la classe elle-même plutôt qu'à un objet particulier de la classe.
    static function register()
    {
        spl_autoload_register([
            __CLASS__,
            "autoload"
        ]);
    }

    static function autoload($class)
    {
        $class = str_replace(__NAMESPACE__ . '\\', '', $class);
        $class = str_replace('\\', '/', $class);
        $fichier = __DIR__ . '/' . $class . '.php';
        if (file_exists($fichier)) {
            include $fichier;
        }
    }
}
