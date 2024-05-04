<?php

namespace App\Controllers;

abstract class Controller
/* asbtract > on ne peut pas instancier la class (Controller) donc elle ne peut être utilisée que comme parent */
{
    //---------------------------------------------------------------------
    protected function render(string $path, array $data = [])
    /* RENDER: inclu la vue dans le controller
        2 paramètres:
        - une string: chemin vers la vue
        - un array: données à afficher dans la vue
le $data est un tableau vide donc on peut soit l'utiliser, soit pas (c'est pour ça qu'on peut avoir deux paramètres d'entrée mais visuellement un de sortie)
         */
    {
        extract($data);
        /* extract = les index du tableau sont transformés en variables, facilitant ainsi leur manipulation dans la vue */

        ob_start(); /* méthode qui sert à créer un espace de stockage Ensuite, la méthode utilise la fonction ob_start pour démarrer la mise en tampon de sortie. Cela signifie que toute sortie générée par la vue sera stockée dans un tampon au lieu d'être envoyée directement au navigateur.*/
        include dirname(__DIR__) . '/Views/' . $path . '.php'; /* on inclut le chemin vers la vue à exécuter. Cette ligne sera automatiquement mise en cache grâce au buffer. La vue est ensuite incluse à l'aide de la fonction include, en utilisant le chemin spécifié dans le premier paramètre de la méthode render. La sortie générée par la vue est stockée dans le tampon de sortie.*/
        $content = ob_get_clean();/* on stocke le contenu de la vue mise en cache dans une variable 
        + $content est utilisé dans la base.php, dans le <main></main>. Le contenur de la variable change à chaque page Enfin, la méthode utilise la fonction ob_get_clean pour récupérer le contenu du tampon de sortie et le stocker dans la variable $content. La variable $content est ensuite utilisée dans le fichier base.php pour afficher le contenu de la vue dans la mise en page générale de la page.*/
        include dirname(__DIR__) . '/Views/base.php';/* Pour terminer, on n'oublie surtout pas d'ajouter le fichier "base.php" dans la méthode pour profiter du gabarit sur toutes les pages. Comme le fichier "base.php" est inclus ici, on a accès au contenu stocké dans "$contenu". */
    }
    //en gros sur les autres pages quand on met un render, ça veut dire qu'on prends le chemin + les infos qu'on stock dans $content qui est mis au préalable dans le main qui est dans la base qui est la structure HTML.
    //---------------------------------------------------------------------


    // ------------------------ MÉTHODE À APPLIQUER SUR LES $POST $GET ($SESSION) -------------
    // ------------------------pour empêcher l'injection de script js ou html --------------
    // trim supprime les espaces blancs avant et après
    // stripslashes supprime les anti slash
    // htmlsepcailchars traduit les caractères spéciaux en html (< = &et)
    protected function protectedValues($value)
    {
        $value = trim($value);
        $value = stripslashes($value);
        $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        return $value;
    }
}
