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
        Token::tokenGenerator();
        $this->render('account/loginAccount');
    }

    // ############################################################
    // ####################### CREATE AND LOGIN ACCOUNT ###########
    // ############################################################
    public function loginAccount()
    {
        // Condition valisation formulaire CREATION
        if (isset($_POST['addAccount'])) {

            // vérification TOKEN
            if (isset($_POST['csrf_token']) && !Token::tokenValidator($_POST['csrf_token'])) {

                $_SESSION['error_messageC'] = "Erreur de jeton CSRF.";
                header("Location: viewLogin");
                exit();
            }
            // si une variable est définie (donc déclarée) et différente de null > message d'erreur
            if (!isset($_POST['nickname_account']) || !isset($_POST['email_account']) || !isset($_POST['password']) || !isset($_POST['confirmPassword'])) {
                $_SESSION['error_messageC'] = "Toutes les valeurs ne sont pas soumises.";
                header("Location: viewLogin");
                exit();
            }

            // sinon : récupérer les données du model
            else {
                $account = new Account();

                $nicknameAccount = $this->protectedValues($_POST['nickname_account']);
                $emailAccount = $this->protectedValues($_POST['email_account']);
                $password = trim($_POST['password']);
                $confirmPassword = trim($_POST['confirmPassword']);
                if (!filter_var($emailAccount, FILTER_VALIDATE_EMAIL)) {
                    $_SESSION['error_messageC'] = "L'adresse e-mail n'est pas valide.";
                    header("Location: viewLogin");
                    exit();
                }

                $account->setNickname_account($nicknameAccount);
                $account->setEmail_account($emailAccount);
                $account->setPassword_account($password);

                $confirmPassword = $_POST['confirmPassword'];
                // si les deux mdp sont identiques, instancier la class accountmodel et appeler la méthode getaccountbyemail pour vérifier si l'email est déjà dans la BDD
                if ($password == $confirmPassword) {
                    $accountModel = new AccountModel();
                    $existingAccount = $accountModel->getAccountByEmail($emailAccount);
                    // si mail existe déjà, afficher message d'erreur
                    if ($existingAccount) {
                        $_SESSION['error_messageC'] = "Cet email existe déjà, merci d'en sélectionner un autre.";
                        header("Location: viewLogin");
                    }
                    // sinon on appelle la méthode de création de compte du model et on met le nickname en session, puis on redirige vers la maison
                    else {
                        $accountInfos = $accountModel->createAccount($account, $password);
                        $_SESSION['idAccount'] = $accountInfos['idAccount'];
                        var_dump($_SESSION['idAccount']);
                        die;
                        header('Location: home');
                        exit();
                    }
                } else {
                    $_SESSION['error_messageC'] = "Les mots de passe ne correspondent pas.";
                    header("Location: viewLogin");
                }
            }
        }
        // Condition valisation formulaire CONNEXION
        elseif (isset($_POST['connectionAccount'])) {
            // Vérification du jeton CSRF
            if (isset($_POST['csrf_token']) && !Token::tokenValidator($_POST['csrf_token'])) {
                // var_dump($_POST['csrf_token']);
                // die;
                $_SESSION['error_message'] = "Erreur de jeton CSRF.";
                header("Location: viewLogin");
                exit();
            }

            $nickname = $_POST['nicknameLogin'];
            $password = $_POST['loginPassword'];

            // Vérification si les valeurs sont vides
            if (!$nickname || !$password) {
                $_SESSION['error_message'] = "Merci de saisir un pseudo et un mot de passe";
                header("Location: viewLogin");
                exit();
            } else {
                // Récupération des données
                $account = new Account();
                $account->setNickname_account($nickname);
                $account->setPassword_account($password);

                $loginAccount = new AccountModel();

                $accountInfos = $loginAccount->loginAccount($account);
                // var_dump($accountInfos);
                // die;

                // Si les données ne sont pas nulles, cela veut dire que la requête a renvoyé une ligne de la table account et que le nickname saisi par l'utilisateur correspond à celui de la BDD
                if ($accountInfos !== NULL) {
                    // Si le mdp inscrit est le même que dans la BDD
                    if (password_verify($password, $accountInfos['password_account'])) {
                        $_SESSION['nicknameLogin'] = $accountInfos['nickname_account'];
                        $_SESSION['idAccount'] = $accountInfos['id_account'];
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
            header("Location: viewLogin");
            // $this->render("account/viewLogin");
            $_SESSION['error_message'] = 'La connexion a échouée';
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