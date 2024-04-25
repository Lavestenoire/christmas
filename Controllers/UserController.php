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
    // public function pageCreateUser()
    // {
    //     $this->render('user/createUser');
    // }


    // #############################
    //          AJOUT USER 
    // #############################
    public function createUser()
    {
        $tag_account = $_POST['tag_user'];

        $accountModel = new AccountModel();
        $account = $accountModel->getAccountByTag($tag_account);

        if ($account) {
            $nicknameUser = $_POST['nickname_user'];
            $emailUser = $_POST['email_user'];
            $passwordUser = $_POST['password_user'];
            $confirmPasswordUser = $_POST['confirmPassword_user'];
            // var_dump($_POST);
            // die;

            if ($passwordUser === $confirmPasswordUser) {
                $user = new User();
                $user->setNickname_user($nicknameUser);
                $user->setEmail_user($emailUser);
                $user->setPassword_user(password_hash($passwordUser, PASSWORD_DEFAULT));
                $user->setStatus_user(0);
                $user->setPicture_user(DEFAULT_AVATAR);
                $user->setId_account($account['id_account']);

                $userModel = new UserModel();
                $existingUser = $userModel->getUserByEmail($emailUser);
                if ($existingUser) {
                    http_response_code(409);
                    $_SESSION['error_message'] = "Cet email existe déjà, merci d'en sélectionner un autre.";
                    header("Location: signUp");
                    exit();
                }

                $userModel->createUser($user, $passwordUser);
                header('Location: home');
                exit();
            } else {
                $_SESSION['error_messageUser'] = "Les mots de passe ne correspondent pas";
                header('Location: signUp');
                exit();
            }
        } else {
            // Le tag_account n'existe pas, afficher un message d'erreur
            $_SESSION['error_messageUser'] = 'Le code cadeau n\'existe pas';

            // Rediriger l'utilisateur vers la page d'inscription
            header('Location: signUp');
            exit();
        }
    }

    // ########################################
    //          PAGE CONNEXION USER
    // ########################################
    // public function pageLoginUser()
    // {
    //     if (isset($_SESSION['id_user'])) {
    //         header("Location: home");
    //         exit();
    //     }
    //     if (isset($_GET['id_user'])) {
    //         $user = new User();
    //         $getIdUser = $user->setId_user($_GET['id_user']);

    //         $userModel = new UserModel();
    //         $user = $userModel->getUserByIdUser($getIdUser);

    //         $account = new Account();
    //         $account->setId_account($_SESSION['id_account']);
    //         $questions = new AccountModel();
    //         $questions = $userModel->questionsUsers($account);
    //         $this->render('user/loginUser', ['user' => $user, 'questions' => $questions]);
    //     }
    // }

    // ########################################
    //              CONNEXION USER
    // ########################################
    // public function loginUser()
    // {
    //     // je veux connecter un user avec question et réponse, lui-même lié à l'id_account, et le mettre en session. donc en principe si on var_dump($_SESSION) on aura la session account + la session user
    //     if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //         $account = new Account();
    //         $account->setId_account($_SESSION['id_account']);

    //         $id_user = $_POST['id_user'];
    //         $nickname_user = $_POST['nickname_user'];
    //         $question = $_POST['email_user'];
    //         $response = $_POST['password_user'];

    //         $user = new User();

    //         $user->setNickname_user($nickname_user);
    //         $user->setEmail_user($question);
    //         $user->setPassword_user($response);


    //         // instancer la classe userModel
    //         $userModel = new UserModel();
    //         // appeler la méthode du model qui gère la requete
    //         $userData = $userModel->loginUser($user);
    //         if ($userData !== false && $userData['nickname_user'] === $nickname_user && $userData['email_user'] === $question && $userData['password_user'] === $response) {
    //             $_SESSION['id_user'] = $userData['id_user'];
    //             $_SESSION['nickname_user'] = $userData['nickname_user'];
    //             $_SESSION['role_user'] = $userData['role_user'];
    //             $_SESSION['status_user'] = $userData['status_user'];

    //             // Mettre à jour le status_user à 1
    //             $user->setId_user($userData['id_user']);
    //             $user->setStatus_user(1);
    //             $userModel->updateUserStatus($account, $user);

    //             header('Location: home');
    //             exit();
    //         } else {
    //             $_SESSION['error_message'] = "Les informations de connexion sont incorrectes.";
    //             header("Location: pageLoginUser?id_user=" . $id_user);
    //         }
    //     }
    // }

    // ########################################
    //             DECONNEXION USER
    // ########################################
    // public function logoutUser()
    // {
    //     if (isset($_SESSION['id_user']) && isset($_SESSION['id_account'])) {
    //         // Récupérer l'ID de l'utilisateur depuis la session
    //         $id_user = $_SESSION['id_user'];

    //         // Instancier la classe User
    //         $user = new User();
    //         $user->setId_user($id_user);
    //         $user->setStatus_user(0);

    //         // Instancier la classe Account
    //         $account = new Account();
    //         $account->setId_account($_SESSION['id_account']);

    //         // Instancier la classe UserModel
    //         $userModel = new UserModel();

    //         // Mettre à jour le status_user à 0
    //         $userModel->updateUserStatus($account, $user);

    //         // Supprimer les variables de session spécifiques à l'utilisateur
    //         unset($_SESSION['id_user']);
    //         unset($_SESSION['nickname_user']);
    //         unset($_SESSION['role_user']);
    //         unset($_SESSION['status_user']);

    //         // Rediriger vers la page de connexion
    //         header('Location: home');
    //         exit();
    //     } else {
    //         echo "Erreur lors de la déconnexion de l'utilisateur.";
    //     }
    // }

    // ########################################
    //             PROFILE USER
    // ########################################
    // public function profileUser()
    // {
    //     $user = new User();
    //     $user->setId_user($_SESSION['id_user']);
    //     // var_dump($_SESSION['id_user']);
    //     // var_dump($_SESSION['id_account']);


    //     $userModel = new UserModel();
    //     $userProfile = $userModel->getUserByIdUser($user);
    //     // var_dump($userProfile);
    //     // die;

    //     $this->render('user/profileUser', ['userProfile' => $userProfile]);
    // }

    // ########################################
    //           DELETE PROFILE USER
    // ########################################
    // public function deleteUser()
    // {
    //     $user = new User();
    //     $user->setId_user($_SESSION['id_user']);

    //     $userModel = new UserModel();
    //     $userModel->deleteUser($user);
    //     unset($_SESSION['id_user']);

    //     header("Location: home");
    // }

    // public function editUser()
    // {
    //     $nickname_user = $_POST['nickname_user'];
    //     $email_user = $_POST['email_user'];
    //     $password_user = $_POST['password_user'];

    //     $account = new Account();
    //     $account->setId_account($_SESSION['id_account']);

    //     $user = new User();
    //     $user->setId_user($_SESSION['id_user']);
    //     $user->setNickname_user($nickname_user);
    //     $user->setEmail_user($email_user);
    //     $user->setPassword_user($password_user);

    //     $userModel = new UserModel();
    //     $userProfile = $userModel->getUserByIdUser($user);

    //     $newAvatar = null;
    //     if (isset($_FILES['avatar']) && !empty($_FILES['avatar']['name'])) {
    //         //target_dir est le chemin du fichier dans lequel les images seront stockées
    //         $target_dir = "../public/pictures/";
    //         //basename($_FILES["avatar"]["name"]) extrait le nom du fichier image téléchargé par l'utilisateur, sans le chemin d'accès. Cette valeur est ensuite concaténée avec $target_dir pour former le chemin complet où le fichier sera téléchargé sur le serveur.
    //         $target_file = $target_dir . basename($_FILES["avatar"]["name"]);
    //         // Vérifiez si le fichier est une image valide
    //         $check = getimagesize($_FILES["avatar"]["tmp_name"]);

    //         if ($check !== false) {
    //             if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {

    //                 // Enregistrez le chemin de l'image dans la base de données
    //                 $newAvatar = 'pictures/' . basename($_FILES["avatar"]["name"]);
    //             } else {
    //                 $_SESSION['error_message'] = "Désolé, une erreur s'est produite lors du téléchargement de l'image.t";
    //             }
    //         } else {
    //             $_SESSION['error_message'] = "Ce fichier est invalide.";
    //         }
    //     } else {
    //         //si (!isset($_FILES['avatar])), on met l'avatar déjà enregistré
    //         $newAvatar = $userProfile['picture_user'];
    //     }
    //     $userModel->editUser($user, $account, $newAvatar);
    //     $_SESSION['nickname_user'] = $nickname_user;
    //     $_SESSION['email_user'] = $email_user;
    //     $_SESSION['password_user'] = $password_user;
    //     $_SESSION['picture_user'] = $newAvatar;
    //     // $_SESSION['role_user'] = $role_user;
    //     // Assurez-vous de ne pas stocker la réponse de l'utilisateur en session pour des raisons de sécurité

    //     header("Location: profileUser");
    //     exit();
    //     // $this->render('user/profileUser', ['userProfile' => $userProfile]);
    // }

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
