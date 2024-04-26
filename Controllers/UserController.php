<?php

namespace App\Controllers;

use App\Entities\User;
use App\Entities\Account;
use App\Models\AccountModel;
use App\Models\UserModel;

class UserController extends Controller
{
    // ########################################
    //        AFFICHAGE PAGE AJOUT USER 
    // ########################################
    // public function pageSignUpUser()
    // {
    //     $this->render('user/signUpAccount');
    // }


    // #############################
    //          AJOUT USER 
    // #############################
    public function signUpUser()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $tag_account = $_POST['tag_user'];

            $accountModel = new AccountModel();
            $tag = $accountModel->getAccountByTag($tag_account);

            if ($tag) {
                $nicknameUser = $_POST['nickname_user'];
                $email_user = $_POST['email_user'];
                $passwordUser = $_POST['password_user'];
                $confirmPasswordUser = $_POST['confirmPassword_user'];

                // si une variable est définie (donc déclarée) et différente de null > message d'erreur
                if (!isset($nicknameUser) || !isset($email_user) || !isset($passwordUser) || !isset($confirmPasswordUser)) {
                    http_response_code(400);
                    $_SESSION['error_messageUser'] = "Toutes les valeurs ne sont pas soumises.";
                    header("Location: signUpAccount");
                    exit();
                }
                if (!filter_var($email_user, FILTER_VALIDATE_EMAIL)) {
                    $_SESSION['error_messageUser'] = "L'adresse e-mail n'est pas valide.";
                    header("Location: signUpAccount");
                    exit();
                }
                if (strlen($passwordUser) < 8 || !preg_match("/[A-Z]/", $passwordUser) || !preg_match("/[a-z]/", $passwordUser) || !preg_match("/[0-9]/", $passwordUser)) {
                    http_response_code(400);
                    $_SESSION['error_messageUser'] = "Le mot de passe doit contenir au moins 8 caractères, une lettre majuscule, une lettre minuscule et un chiffre.";
                    header("Location: signUpAccount");
                    exit();
                }
                if ($passwordUser !== $confirmPasswordUser) {
                    http_response_code(400);
                    $_SESSION['error_messageUser'] = "Les mots de passe ne correspondent pas.";
                    header("Location: signUpAccount");
                    exit();
                }
                $user = new User();
                $user->setNickname_user($nicknameUser);
                $user->setEmail_user($email_user);
                $user->setPassword_user(password_hash($passwordUser, PASSWORD_DEFAULT));
                $user->setStatus_user(0);
                $user->setPicture_user(DEFAULT_AVATAR);
                $user->setId_account($tag['id_account']);

                $userModel = new UserModel();
                $existingUser = $userModel->getUserByEmail($email_user);
                if ($existingUser) {
                    http_response_code(409);
                    $_SESSION['error_message'] = "Cet email existe déjà, merci d'en sélectionner un autre.";
                    header("Location: signUpAccount");
                    exit();
                }
                $userId = $userModel->signUpUser($user, $passwordUser);
                $userInfos = $userModel->getUserById($userId);

                $_SESSION['id_user'] = $userInfos['id_user'];
                $_SESSION['nickname_user'] = $userInfos['nickname_user'];
                $_SESSION['email_user'] = $userInfos['email_user'];

                header('Location: home');
                exit();
            } else {
            }
        } else {
            $this->render("account/signUpAccount");
        }
    }


    // ########################################
    //          PAGE CONNEXION USER
    // ########################################
    // public function pageSignInUser()
    // {
    //     $this->render('user/signInUser');
    // }


    // ########################################
    //              CONNEXION USER
    // ########################################
    public function signInUser()
    {
        // je veux connecter un user avec question et réponse, lui-même lié à l'id_account, et le mettre en session. donc en principe si on var_dump($_SESSION) on aura la session account + la session user
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $nickname_user = $_POST['nickname_user'];
            $password_user = $_POST['loginPasswordUser'];


            // Vérification si les valeurs sont vides
            if (!$nickname_user || !$password_user) {
                http_response_code(400);
                $_SESSION['error_message'] = "Merci de saisir un pseudo et un mot de passe";
                header("Location: signInUser");
                exit();
            }

            $user = new User();
            $user->setNickname_user($nickname_user);
            $user->setPassword_user($password_user);


            // instancer la classe userModel
            $userModel = new UserModel();
            // appeler la méthode du model qui gère la requete
            $userData = $userModel->signInUser($user);

            if ($userData !== false && password_verify($password_user, $userData['password_user'])) {
                $_SESSION['id_user'] = $userData['id_user'];
                $_SESSION['nickname_user'] = $userData['nickname_user'];
                $_SESSION['status_user'] = $userData['status_user'];
                $_SESSION['id_account'] = $userData['id_account'];
            } else {
                $_SESSION['error_message'] = "Les informations de connexion sont incorrectes.";
                header("Location: signInUser");
            }
            // Mettre à jour le status_user à 1
            $user->setNickname_user($userData['nickname_user']);
            $user->setPassword_user($userData['password_user']);
            $user->setId_user($userData['id_user']);
            $user->setStatus_user(1);
            // echo '<pre>';
            // var_dump($user);
            // echo '</pre>';
            // die;
            $userModel->updateUserStatus($user);

            header('Location: home');
            exit();
        } else {
            $this->render("user/signInUser");
        }
    }

    // ########################################
    //             DECONNEXION USER
    // ########################################
    public function logOutUser()
    {
        if (isset($_SESSION['id_user'])) {
            // Récupérer l'ID de l'utilisateur depuis la session
            $id_user = $_SESSION['id_user'];

            // Instancier la classe User
            $user = new User();
            $user->setId_user($id_user);
            $user->setStatus_user(0);


            // Instancier la classe UserModel
            $userModel = new UserModel();

            // Mettre à jour le status_user à 0
            $userModel->updateUserStatus($user);

            // Supprimer les variables de session spécifiques à l'utilisateur
            unset($_SESSION['id_user']);
            unset($_SESSION['id_account']);
            unset($_SESSION['nickname_user']);
            unset($_SESSION['role_user']);
            unset($_SESSION['status_user']);

            // Rediriger vers la page de connexion
            header('Location: home');
            exit();
        } else {
            echo "Erreur lors de la déconnexion de l'utilisateur.";
        }
    }

    // ########################################
    //             PROFILE USER
    // ########################################
    public function profileUser()
    {
        $user = new User();
        $user->setId_user($_SESSION['id_user']);
        // var_dump($_SESSION['id_user']);
        // var_dump($_SESSION['id_account']);


        $userModel = new UserModel();
        $userProfile = $userModel->getUserByIdUser($user);
        // var_dump($userProfile);
        // die;

        $this->render('user/profileUser', ['userProfile' => $userProfile]);
    }


    // ########################################
    //           EDIT PROFILE USER
    // ########################################
    public function editUser()
    {
        $nickname_user = $_POST['nickname_user'];
        $email_user = $_POST['email_user'];
        $current_password_user = $_POST['current_password_user'];
        $new_password_user = $_POST['new_password_user'];
        $confirm_new_password_user = $_POST['confirm_new_password_user'];

        // Vérifier si un nouveau mot de passe a été fourni
        if (!empty($new_password_user)) {
            // Hasher le nouveau mot de passe
            $hashed_new_password = password_hash($new_password_user, PASSWORD_DEFAULT);
        } else {
            // Si aucun nouveau mot de passe n'a été fourni, utiliser le mot de passe actuel
            $hashed_new_password = $current_password_user;
        }


        $user = new User();
        $user->setId_user($_SESSION['id_user']);
        $user->setNickname_user($nickname_user);
        $user->setEmail_user($email_user);
        $user->setPassword_user($hashed_new_password);

        $userModel = new UserModel();
        $userProfile = $userModel->getUserByIdUser($user);

        $newAvatar = null;
        if (isset($_FILES['avatar']) && !empty($_FILES['avatar']['name'])) {
            //target_dir est le chemin du fichier dans lequel les images seront stockées
            $target_dir = "../public/pictures/";
            //basename($_FILES["avatar"]["name"]) extrait le nom du fichier image téléchargé par l'utilisateur, sans le chemin d'accès. Cette valeur est ensuite concaténée avec $target_dir pour former le chemin complet où le fichier sera téléchargé sur le serveur.
            $target_file = $target_dir . basename($_FILES["avatar"]["name"]);
            // Vérifiez si le fichier est une image valide
            $check = getimagesize($_FILES["avatar"]["tmp_name"]);

            if ($check !== false) {
                if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {

                    // Enregistrez le chemin de l'image dans la base de données
                    $newAvatar = 'pictures/' . basename($_FILES["avatar"]["name"]);
                } else {
                    $_SESSION['error_message'] = "Désolé, une erreur s'est produite lors du téléchargement de l'image.t";
                }
            } else {
                $_SESSION['error_message'] = "Ce fichier est invalide.";
            }
        } else {
            //si (!isset($_FILES['avatar])), on met l'avatar déjà enregistré
            $newAvatar = $userProfile['picture_user'];
        }
        $userModel->editUser($user, $newAvatar);
        $_SESSION['nickname_user'] = $nickname_user;
        $_SESSION['email_user'] = $email_user;
        $_SESSION['picture_user'] = $newAvatar;
        // $_SESSION['role_user'] = $role_user;
        // Assurez-vous de ne pas stocker la réponse de l'utilisateur en session pour des raisons de sécurité

        header("Location: profileUser");
        exit();
        // $this->render('user/profileUser', ['userProfile' => $userProfile]);
    }

    // ########################################
    //           DELETE PROFILE USER
    // ########################################
    public function deleteUser()
    {
        $user = new User();
        $user->setId_user($_SESSION['id_user']);

        $userModel = new UserModel();
        $userModel->deleteUser($user);
        unset($_SESSION['id_user']);

        header("Location: home");
    }

    // public function adminPage()
    // {
    //     $id_account = $_SESSION['id_account'];
    //     $account = new Account();
    //     $account->setId_account($id_account);

    //     $userModel = new UserModel();
    //     $listUsers = $userModel->getUsersByAccountId($account);

    //     $accountModel = new AccountModel();
    //     $accountInfos = $accountModel->getAccountById($id_account);

    //     $this->render("user/profileAdmin", ['listUsers' => $listUsers, 'accountInfos' => $accountInfos]);
    // }
}
