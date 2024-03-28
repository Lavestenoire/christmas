<?php

namespace App\Controllers;

use App\Entities\Account;
use App\Models\AccountModel;
use App\Core\Token;


//controller qui conditionne l'entrée au site. LoginController à étendre dans tous les controller où il y a des routes à protéger et dans lesquelles on ajoute donc $this->protectedRoute

class AccountController extends Controller
{
    // ############################################################
    // ###################### VUE CONNEXION #######################
    // ############################################################

    public function viewLogin()
    {
        // tokenGenerator mis là puisqu'il doit être généré avant l'affichage du formulaire
        Token::tokenGenerator();

        $this->render('account/loginAccount');
    }

    // ############################################################
    // ####################### CREATE ACCOUNT #######################
    // ############################################################
    public function createAccount()
    {
        // le lien sur le menu de la base href="/christmas/public/login" va vers la page login de la vue user
        // pour gérer le formulaire, je peux utiliser la même méthode, en mettant un lien action (eéecriture d'url correspondant à la méthode) sur le formulaire qui indiquera que c'est cette méthode (dans laquelle je met ce commentaire) qui va gérer les infos du formulaire
        // il faut mettre une condition: si $_POST['valider'] -> gérer la requête et faire un header location
        // sinon, $this->render('user/login');
        $error = [];
        Token::tokenGenerator();
        // si formulaire validé
        if (isset($_POST['addAccount'])) {
            // si token non validé
            if (!Token::tokenValidator()) {
                // var_dump($_SESSION['token']);
                $error[] = "Erreur de jeton CSRF.";
            }
            // sinon : récupérer les données du model
            else {
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
                // si les deux mdp sont identiques, instancier la class accountmodel et appeler la méthode getaccountbyemail pour vérifier si l'email est déjà dans la BDD
                if ($password == $confirmPassword) {
                    $accountModel = new AccountModel();
                    $existingAccount = $accountModel->getAccountByEmail($emailAccount);
                    // si mail existe déjà, afficher message d'erreur
                    if ($existingAccount) {
                        $error[] = "Cet email existe déjà, merci d'en sélectionner un autre.";
                    }
                    // sinon on appelle la méthode de création de compte du model et on met le nickname en session, puis on redirige vers la maison
                    else {
                        $accountInfos = $accountModel->createAccount($account, $password);
                        $_SESSION['nicknameLogin'] = $accountInfos['nickname_account'];

                        header('Location: home');
                        exit();
                    }
                } else {
                    $error[] = "Les mots de passe ne correspondent pas.";
                }
                unset($_SESSION['token']);
            }
            // la méthode header attend une URL relative, ce qui est le cas puisque index.php?controller=login&action=login est bien une url, même si elle renvoie vers une méthode
            // redirige le navigateur vers une nouvelle URL, ce qui entraîne une nouvelle requête HTTP.
        } else {
            //var_dump($_SESSION['token']);
            $this->render('account/loginAccount');
        }
        // Stocker les messages d'erreur dans la session pour les afficher dans la vue
        if (!empty($error)) {
            $_SESSION['error_messages'] = $error;
        }
    }


    // ############################################################
    // ######################### LOGIN ############################
    // ############################################################

    public function loginAccount()
    {

        if (isset($_POST['connectionAccount'])) {
            // Vérification du jeton CSRF
            if (!Token::tokenValidator($_POST['token'])) {
                $_SESSION['error_message'] = "Erreur de jeton CSRF.";
                header("Location: viewLogin");
                exit();
            }

            $nickname = $_POST['nicknameLogin'];
            $password = $_POST['loginPassword'];

            // Vérification si les valeurs sont vides
            if (!$nickname || !$password) {
                $_SESSION['error_message'] = "Merci de saisir un pseudo et un mot de passe";
            } else {
                // Récupération des données
                $account = new Account();
                $account->setNickname_account($nickname);
                $account->setPassword_account($password);

                $loginAccount = new AccountModel();

                $accountInfos = $loginAccount->loginAccount($account);

                // Si les données ne sont pas nulles, cela veut dire que la requête a renvoyé une ligne de la table account et que le nickname saisi par l'utilisateur correspond à celui de la BDD
                if ($accountInfos !== NULL) {
                    // Si le mdp inscrit est le même que dans la BDD
                    if (password_verify($password, $accountInfos['password_account'])) {
                        $_SESSION['nicknameLogin'] = $accountInfos['nickname_account'];
                        header("Location: home");
                    } else {
                        $_SESSION['error_message'] = "Le pseudo ou le mot de passe sont invalides";
                        header("Location: viewLogin");
                    }
                } else {
                    $_SESSION['error_message'] = "Le pseudo ou le mot de passe sont invalides";
                    header("Location: viewLogin");
                }
            }
        } else {
            echo 'La connexion a échouée';
        }
    }




    public function logoutAccount()
    {
        $_SESSION['logout_message'] = 'Vous avez bien été déconnecté.';
        session_unset();
        session_destroy();
        header("Location: home");
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