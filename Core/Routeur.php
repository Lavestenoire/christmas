<?php


namespace App\Core;

// Dans la structure MVC, il n'y a qu'un seul point d'entrée. Il est représenté par un fichier, quelle que soit la page appelée. Ce fichier est le routeur qui a le rôle d'aller demander auprès du bon contrôleur, le bon chemin pour diriger l'utilisateur sur la bonne page. D'où le nom de routeur.

// premier élément sollicité par l'utilisateur
// objectif du rooter: récupérer nos URL. pour diriger vers la bonne page
//controller, et action (méthode dans le controller)

class Routeur
{
    /* Le routeur récupère l'URL suite à une action de l'utilisateur puis dirige vers le bon Controller, puis la bonne méthode dans ce Controller
     */
    public function routes()
    {
        $controller = isset($_GET['controller']) ? ucfirst($_GET['controller']) : 'home'; /* le isset($_GET['controller']) vérifie si le paramètre controller est présent dans la requete GET
        S'il est présent, il est stocké dans la propriété $controller avec une majuscule, sinon c'est home qui est stocké*/
        $controller = '\\App\\Controllers\\' . $controller . 'Controller';

        $action = isset($_GET['action']) ? $_GET['action'] : 'index';

        $controller = new $controller();

        $controller->$action();
    }
}
/* opérateur ternaire: 

test ? code exécuté si true : code exécuté si false
$$$ =  xxxx ? yyyy : zzz
si x est vrai -> on stocke le y dans $
si x est faux -> on stocke le z dans $

https://monsite.com/index.php?controller=nomDuControleur&action=nomDeLaMethode


Dans la CLASSE "Routeur", nous déclarons une méthode "routes" qui sera appelée plus tard dans l'index de notre application. 
Cette méthode permet de récupérer les valeurs de chaque paramètre présent dans l'URL grâce à la superglobale "$_GET". Cette variable $_GET est un tableau et c'est donc dans ce dernier que nous récupérons, au minimum, les deux paramètres "controller" et "action", et potentiellement d'autres paramètres tels qu'un identifiant.


Pour bien comprendre je vais donner d’autres noms aux propriétés
$controller =
> on teste si la super globale $_GET[‘controller’] est déclarée et non vide. 
Si isset($_GET[‘controller’] est true, on le stock dans la propriété $controller
sinon on stocke ’ home’ dans la propriété $controller

$toto = $controller . ‘Controller’;

$tata = new $toto();
comme $toto est égal à ce qu’on a fait passer en get, par exemple controller = creation, concaténé à ‘Controller’ (ce qui donne CreationController), il devient finalement une classe qu’on instancie. Il devient une classe et c’est pour ça qu’ensuite on créé un fichier MachinController “

http://localhost:8888/MVC/public/index.php?controller=User&action=index

ce qu’il y a après le ? sont des variable (ici, controller et action) et on pourra les appeler dans le code
-> $controller
-> $action

Nous faisons ensuite la même chose avec le paramètre "action". Sauf que dans ce cas, l'objectif étant d'exécuter la méthode du contrôleur concerné, nous ne récupérons que le nom de cette méthode. Par défaut, pour accéder à la page d'accueil, la méthode exécutée se nomme "index".

Nous instancions le contrôleur concerné en utilisant la variable "$controller" qui contient le chemin vers ce contrôleur. Nous obtenons ainsi un objet du contrôleur qui nous permet d'accéder à ses paramètres, et ici, à la méthode exécutant la page, par la variable "$action".

*/