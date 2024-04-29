<?php

namespace App\Controllers;

use App\Entities\Account;
use App\Entities\User;
use App\Models\AccountModel;
use App\Models\UserModel;
use App\Core\Token;


//controller qui conditionne l'entrée au site. LoginController à étendre dans tous les controller où il y a des routes à protéger et dans lesquelles on ajoute donc $this->protectedRoute

class AccountController extends Controller
{
    // ############################################################
    // ###################### VUE CONNEXION #######################
    // ############################################################

    // public function pageSignUpAccount()
    // {
    //     $this->render("account/signUpAccount");
    // }



    // ############################################################
    // ####################### CREATE AND LOGIN ACCOUNT ###########
    // ############################################################
    public function signUpAccount()
    {
        // if ($_POST['signUpAccountWithTag']) {
        // vérification TOKEN
        // if (!Token::tokenValidator($_POST['csrf_token'], 'create_account')) {
        //     http_response_code(400);
        //     $_SESSION['error_message'] = "Erreur de jeton CSRF.";
        //     header("Location: signInAccount");
        //     exit();
        // }
        if (($_SERVER["REQUEST_METHOD"] == "POST")) {
            $nicknameAccount = $this->protectedValues($_POST['nickname_account']);
            $emailAccount = $this->protectedValues($_POST['email_account']);
            $password = trim($_POST['password']);
            $confirmPassword = trim($_POST['confirmPassword']);
            $tag_account = $_POST['tag_account'];

            // si une variable est définie (donc déclarée) et différente de null > message d'erreur
            if (!isset($_POST['nickname_account']) || !isset($_POST['email_account']) || !isset($_POST['password']) || !isset($_POST['confirmPassword']) || !isset($_POST['tag_account'])) {
                http_response_code(400);
                $_SESSION['error_messageAccount'] = "Toutes les valeurs ne sont pas soumises.";
                header("Location: signUpAccount");
                exit();
            }
            if (!filter_var($emailAccount, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error_messageAccount'] = "L'adresse e-mail n'est pas valide.";
                header("Location: signUpAccount");
                exit();
            }
            if (strlen($password) < 8 || !preg_match("/[A-Z]/", $password) || !preg_match("/[a-z]/", $password) || !preg_match("/[0-9]/", $password)) {
                http_response_code(400);
                $_SESSION['error_messageAccount'] = "Le mot de passe doit contenir au moins 8 caractères, une lettre majuscule, une lettre minuscule et un chiffre.";
                header("Location: signUpAccount");
                exit();
            }

            if ($password !== $confirmPassword) {
                http_response_code(400);
                $_SESSION['error_messageAccount'] = "Les mots de passe ne correspondent pas.";
                header("Location: signUpAccount");
                exit();
            }

            $account = new Account();
            $account->setNickname_account($nicknameAccount);
            $account->setEmail_account($emailAccount);
            $account->setPassword_account($password);
            $account->setTag_account($tag_account);


            $accountModel = new AccountModel();
            $existingAccount = $accountModel->getAccountByEmail($emailAccount);
            // si mail existe déjà, afficher message d'erreur
            if ($existingAccount) {
                http_response_code(409);
                $_SESSION['error_message'] = "Cet email existe déjà, merci d'en sélectionner un autre.";
                header("Location: signUpAccount");
                exit();
            }
            // Insérer un nouvel utilisateur dans la base de données
            $accountModel->signUpAccount($account, $password);

            // Récupérer les informations de l'utilisateur nouvellement sinséré pour qu'il soit connecté une fois inscrit
            // $accountInfos = $accountModel->getAccountById($accountId);

            // Stocker les informations de l'utilisateur en session
            // $_SESSION['id_account'] = $accountInfos['id_account'];
            // $_SESSION['nickname_account'] = $accountInfos['nickname_account'];
            // $_SESSION['email_account'] = $accountInfos['email_account'];
            // $_SESSION['tag_account'] = $accountInfos['tag_account'];

            // Redirection vers la page d'accueil
            header('Location: home');
            exit();
        } else {
            $this->render("account/signUpAccount");
        }
    }


    // ############################################################
    // ###################### CONNEXION ###########################
    // ############################################################
    // public function signInAccount()
    // {
    // les :: sont utilisés pour appeler une méthode statique de la classe Token. Elle peut être appelée sur la classe elle-même plutôt que sur une instance de classe
    // Token::tokenGenerator('create_account');
    // Token::tokenGenerator('login_account');
    //     $this->render('account/signInAccount');
    // }
    public function signInAccount()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Vérification du jeton CSRF
            // if (!Token::tokenValidator($_POST['csrf_token'], 'login_account')) {
            //     http_response_code(400);
            //     $_SESSION['error_messageC'] = "Erreur de jeton CSRF.";
            //     header("Location: signInAccount");
            //     exit();
            // }

            $nickname_account = $_POST['nickname_account'];
            $password = $_POST['loginPassword'];

            // Vérification si les valeurs sont vides
            if (!$nickname_account || !$password) {
                http_response_code(400);
                $_SESSION['error_message'] = "Merci de saisir un pseudo et un mot de passe";
                header("Location: signInAccount");
                exit();
            }
            // Récupération des données
            $account = new Account();
            $account->setNickname_account($nickname_account);
            $account->setPassword_account($password);

            $signInAccount = new AccountModel();

            $accountInfos = $signInAccount->signInAccount($account);

            if ($accountInfos !== NULL && password_verify($password, $accountInfos['password_account'])) {
                // Supprimer les informations de l'utilisateur "user" de la session
                unset($_SESSION['id_user']);
                unset($_SESSION['nickname_user']);
                unset($_SESSION['email_user']);

                $_SESSION['id_account'] = $accountInfos['id_account'];
                $_SESSION['nickname_account'] = $accountInfos['nickname_account'];
                $_SESSION['email_account'] = $accountInfos['email_account'];
                $_SESSION['tag_account'] = $accountInfos['tag_account'];
                // var_dump($_SESSION['id_account']);
                // die;
                header("Location: home");
                exit();
            } else {
                $_SESSION['error_message'] = "Le pseudo ou le mot de passe sont invalides";
                header("Location: signInAccount");
                exit();
            }
        } else {
            $this->render("account/signInAccount");
        }
    }


    // ############################################################
    //                        DECONNEXION 
    // ############################################################

    public function logoutAccount()
    {
        $_SESSION['logout_message'] = 'Vous avez bien été déconnecté.';
        session_unset();
        session_destroy();
        header("Location: home");
    }


    // ############################################################
    //                       PROFILE ACCOUNT 
    // ############################################################
    public function profileAccount()
    {
        $account = new Account();
        $account->setId_account($_SESSION['id_account']);
        $account->setTag_account($_SESSION['tag_account']);

        $idAccount = $account->getId_account();


        // si je met $accountModel->getAccountById($Account), comme $account est un objet (récupéré de la requete préparée via bindValue du model), il ne peut être traduit en string. donc je dois passer l'id à la méthode getAccountById, et non l'objet lui-même
        $accountModel = new AccountModel();
        $accountInfos = $accountModel->getAccountById($idAccount);

        $userModel = new UserModel();

        $userInfos = $userModel->getUsersByTagAccount($account);


        $this->render('account/profileAccount', ['accountInfos' => $accountInfos, 'userInfos' => $userInfos]);
    }

    // ############################################################
    //                           UPDATE ACCOUNT 
    // ############################################################
    public function editAccount()
    {
        $id_account = $_SESSION['id_account'];
        $nickname_account = $_POST['nickname_account'];
        $email_account = $_POST['email_account'];
        $current_password_account = $_POST['current_password_account'];
        $new_password_account = $_POST['new_password_account'];
        $confirm_new_password_account = $_POST['confirm_new_password_account'];

        $accountModel = new AccountModel();
        $accountData = $accountModel->getAccountById($id_account);

        // Vérifier si un nouveau mot de passe a été fourni
        if (!empty($new_password_account)) {
            if (!password_verify($current_password_account, $accountData['password_account'])) {
                $_SESSION['error_message'] = 'L\'ancien mot de passe est incorrect';
                header('Location: editAccount');
                exit();
            } elseif ($new_password_account != $confirm_new_password_account) {
                $_SESSION['error_message'] = 'Les nouveaux mots de passe ne correspondent pas';
                header('Location: editAccount');
                exit();
            } else {
                $hashed_new_password = password_hash($new_password_account, PASSWORD_DEFAULT);
            }
        } else {
            $hashed_new_password = $accountData['password_account'];
        }

        $account = new Account();
        $account->setId_account($id_account);
        $account->setNickname_account($nickname_account);
        $account->setEmail_account($email_account);
        $account->setPassword_account($hashed_new_password);



        // Comparer les données
        if ($nickname_account != $accountData['nickname_account']) {
            $account->setNickname_account($nickname_account);
        }

        if ($email_account != $accountData['email_account']) {
            $account->setEmail_account($email_account);
        }


        // Vérifier s'il y a des erreurs
        if (!isset($_SESSION['error_message'])) {
            $accountModel->updateAccount($account);
            header('Location: profileAccount');
            exit();
        }
    }
    public function deleteAccount()
    {
        $account = new Account();
        $account->setId_account($_SESSION['id_account']);

        $userModel = new AccountModel();
        $userModel->deleteAccount($account);
        unset($_SESSION['id_account']);
        unset($_SESSION['nickname_account']);
        unset($_SESSION['role_account']);
        unset($_SESSION['tag_account']);

        header("Location: home");
    }
}
