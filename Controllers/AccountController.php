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
        // les :: sont utilisés pour appeler une méthode statique de la classe Token. Elle peut être appelée sur la classe elle-même plutôt que sur une instance de classe
        Token::tokenGenerator('create_account');
        Token::tokenGenerator('login_account');
        $this->render('account/loginAccount');
    }

    // ############################################################
    // ####################### CREATE AND LOGIN ACCOUNT ###########
    // ############################################################
    public function createAccount()
    {
        // var_dump($_SESSION['csrf_token']);
        // die;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // vérification TOKEN
            if (!Token::tokenValidator($_POST['csrf_token'], 'create_account')) {
                http_response_code(400);
                $_SESSION['error_messageC'] = "Erreur de jeton CSRF.";
                header("Location: viewLogin");
                exit();
            }

            $nicknameAccount = $this->protectedValues($_POST['nickname_account']);
            $emailAccount = $this->protectedValues($_POST['email_account']);
            $password = trim($_POST['password']);
            $confirmPassword = trim($_POST['confirmPassword']);

            // si une variable est définie (donc déclarée) et différente de null > message d'erreur
            if (!isset($_POST['nickname_account']) || !isset($_POST['email_account']) || !isset($_POST['password']) || !isset($_POST['confirmPassword'])) {
                http_response_code(400);
                $_SESSION['error_messageC'] = "Toutes les valeurs ne sont pas soumises.";
                header("Location: viewLogin");
                exit();
            }
            if (!filter_var($emailAccount, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error_messageC'] = "L'adresse e-mail n'est pas valide.";
                header("Location: viewLogin");
                exit();
            }
            if ($password !== $confirmPassword) {
                http_response_code(400);
                $_SESSION['error_messageC'] = "Les mots de passe ne correspondent pas.";
                header("Location: viewLogin");
                exit();
            }

            // récupérer les données du model
            $account = new Account();
            $account->setNickname_account($nicknameAccount);
            $account->setEmail_account($emailAccount);
            $account->setPassword_account($password);


            $accountModel = new AccountModel();
            $existingAccount = $accountModel->getAccountByEmail($emailAccount);
            // si mail existe déjà, afficher message d'erreur
            if ($existingAccount) {
                http_response_code(409);
                $_SESSION['error_messageC'] = "Cet email existe déjà, merci d'en sélectionner un autre.";
                header("Location: viewLogin");
                exit();
            }
            // Insérer un nouvel utilisateur dans la base de données
            $accountId = $accountModel->createAccount($account, $password);

            // Récupérer les informations de l'utilisateur nouvellement inséré
            $accountInfos = $accountModel->getAccountById($accountId);

            // Stocker les informations de l'utilisateur en session
            $_SESSION['id_account'] = $accountInfos['id_account'];
            $_SESSION['nickname_account'] = $accountInfos['nickname_account'];
            $_SESSION['email_account'] = $accountInfos['email_account'];

            // Redirection vers la page d'accueil
            header('Location: home');
            exit();
        }
        $this->render('account/viewLogin');
    }
    public function loginAccount()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Vérification du jeton CSRF
            if (!Token::tokenValidator($_POST['csrf_token'], 'login_account')) {
                http_response_code(400);
                $_SESSION['error_messageC'] = "Erreur de jeton CSRF.";
                header("Location: viewLogin");
                exit();
            }

            $nickname = $_POST['nickname_account'];
            $password = $_POST['loginPassword'];

            // Vérification si les valeurs sont vides
            if (!$nickname || !$password) {
                http_response_code(400);
                $_SESSION['error_message'] = "Merci de saisir un pseudo et un mot de passe";
                header("Location: viewLogin");
                exit();
            }
            // Récupération des données
            $account = new Account();
            $account->setNickname_account($nickname);
            $account->setPassword_account($password);

            $loginAccount = new AccountModel();

            $accountInfos = $loginAccount->loginAccount($account);

            if ($accountInfos !== NULL && password_verify($password, $accountInfos['password_account'])) {
                $_SESSION['id_account'] = $accountInfos['id_account'];
                $_SESSION['nickname_account'] = $accountInfos['nickname_account'];
                $_SESSION['email_account'] = $accountInfos['email_account'];
                // var_dump($_SESSION['id_account']);
                // die;
                header("Location: home");
                exit();
            } else {
                $_SESSION['error_message'] = "Le pseudo ou le mot de passe sont invalides";
                header("Location: viewLogin");
                exit();
            }
        } else {
            header("Location: viewLogin");
            exit();
            // $this->render("account/viewLogin");
            $_SESSION['error_message'] = 'La connexion a échouée';
        }
        $this->render("account/viewLogin");
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