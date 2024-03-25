<?php

namespace App\Controllers;

use App\Entities\Account;
use App\Models\AccountModel;

//controller qui conditionne l'entrée au site. LoginController à étendre dans tous les controller où il y a des routes à protéger et dans lesquelles on ajoute donc $this->protectedRoute

class AccountController extends Controller
{
    public function createAccount()
    {
        // le lien sur le menu de la base href="/christmas/public/login" va vers la page login de la vue user
        // pour gérer le formulaire, je peux utiliser la même méthode, en mettant un lien action (eéecriture d'url correspondant à la méthode) sur le formulaire qui indiquera que c'est cette méthode (dans laquelle je met ce commentaire) qui va gérer les infos du formulaire
        // il faut mettre une condition: si $_POST['valider'] -> gérer la requête et faire un header location
        // sinon, $this->render('user/login');
        if (isset($_POST['addAccount'])) {
            // var_dump($_POST);
            // die;
            $account = new Account();
            $nickameAccount = $this->protectedValues($_POST['nickname_account']);
            $emailAccount = $this->protectedValues($_POST['email_account']);

            $password = trim($_POST['password']);
            $confirmPassword = trim($_POST['confirmPassword']);
            // vous ne devez pas convertir les caractères spéciaux en entités HTML pour le mot de passe, car cela pourrait modifier le mot de passe original et empêcher l'utilisateur de se connecter correctement.
            // $password = trim($_POST['password']);

            $account->setNickname_account($nickameAccount);
            $account->setEmail_account($emailAccount);
            $account->setPassword_account($password);

            $confirmPassword = $_POST['confirmPassword'];

            if ($password == $confirmPassword) {
                $addAccount = new AccountModel();
                $addAccount->createAccount($account, $password);
                header('Location: home');
            } else {
                echo 'KO';
            }
            // la méthode header attend une URL relative, ce qui est le cas puisque index.php?controller=login&action=login est bien une url, même si elle renvoie vers une méthode
            // redirige le navigateur vers une nouvelle URL, ce qui entraîne une nouvelle requête HTTP.
        } else {
            $this->render('account/login');
        }
    }


    public function isLoggedIn()
    {
        return isset($_SESSION['username_user']);
    }

    public function protectRoute()
    {
        if (!$this->isLoggedIn()) {
            // Redirigez l'utilisateur vers la page de connexion s'il n'est pas connecté
            // header("Location: /quizz/app_web/public/user/login");
            exit();
        }
    }
}


/* mettre ça: $this->protectRoute(); dans les méthodes rendant la vue à protéger par un loggin */