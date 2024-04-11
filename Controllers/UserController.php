<?php

namespace App\Controllers;

use App\Entities\User;
use App\Entities\Account;
use App\Models\UserModel;

class UserController extends Controller
{
    // ########################################
    //        AFFICHAGE PAGE AJOUT USER 
    // ########################################
    public function pageCreateUser()
    {
        $this->render('user/createUser');
    }


    // #############################
    //          AJOUT USER 
    // #############################
    public function createUser()
    {
        if (isset($_POST['addAUser'])) {
            // var_dump($_SESSION['id_account']);
            $account = new Account();
            $account->setId_account($_SESSION['id_account']);

            $accountId = $account->getId_account();

            $user = new User;
            $user->setId_account($accountId);

            $nicknameUser = $this->protectedValues($_POST['nickname_user']);
            $question = $this->protectedValues($_POST['question_user']);
            $response = $this->protectedValues($_POST['response_user']);
            $role = $this->protectedValues($_POST['role_user']);
            $status = $this->protectedValues($_POST['status_user']);
            // var_dump($_POST);

            $user->setNickname_user($nicknameUser);
            $user->setQuestion_user($question);
            $user->setResponse_user($response);
            $user->setRole_user($role);
            $user->setStatus_user($status);
            $user->setPicture_user(DEFAULT_PICTURE);

            $userModel = new UserModel();
            $existingAccount = $userModel->getUserByNicknameAndAccountId($nicknameUser, $account->getId_account());
            // var_dump($existingAccount);
            // die;
            if ($existingAccount) {
                $_SESSION['error_message'] = "Cet pseudo existe déjà, merci d'en sélectionner un autre.";
                $this->render("user/createUser");
            } else {
                $userModel->createUser($user, $accountId);
                $users = $userModel->getUsersByAccountId($account);
                $this->render('home/index', ['showProfiles' => true, 'users' => $users]);
            }
        }
    }

    // ########################################
    //          PAGE CONNEXION USER
    // ########################################
    public function pageLoginuser()
    {
        if (isset($_GET['id_user'])) {
            $user = new User();
            $getIdUser = $user->setId_user($_GET['id_user']);

            $userModel = new UserModel();
            $user = $userModel->getUserByIdUser($getIdUser);
        }
        // on passe les informations à la vue
        $this->render('user/loginUser', ['user' => $user]);
    }

    // ########################################
    //              CONNEXION USER
    // ########################################
    public function loginUser()
    {
        // je veux connecter un user avec question et réponse, lui-même lié à l'id_account, et le mettre en session. donc en principe si on var_dump($_SESSION) on aura la session account + la session user
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $account = new Account();
            $account->setId_account($_SESSION['id_account']);

            // $id_user = $_GET['id_user'];
            // stocker les $_POST dans des variables
            $nickname_user = $_POST['nickname_user'];
            $question = $_POST['question_user'];
            $response = $_POST['response_user'];
            // $role_user = $_POST['role_user'];
            // $status_user = $_POST['status_user'];

            // instancer la classe user
            $user = new User();

            // setter les valeurs de la table avec les variable qui stockent les données passées en POST
            // $user->setId_user($id_user);
            $user->setNickname_user($nickname_user);
            $user->setQuestion_user($question);
            $user->setResponse_user($response);
            // $user->setRole_user($role_user);
            // $user->setStatus_user($status_user);

            // instancer la classe userModel
            $userModel = new UserModel();
            // appeler la méthode du model qui gère la requete
            $userData = $userModel->loginUser($user);
            if ($userData['nickname_user'] === $nickname_user && $userData['question_user'] === $question && $userData['response_user'] === $response) {
                $_SESSION['id_user'] = $userData['id_user'];
                $_SESSION['nickname_user'] = $userData['nickname_user'];
                $_SESSION['role_user'] = $userData['role_user'];
                $_SESSION['status_user'] = $userData['status_user'];

                // Mettre à jour le status_user à 1
                $user->setId_user($userData['id_user']);
                $user->setStatus_user(1);
                $userModel->updateUserStatus($account, $user);

                header('Location: home');
                exit();
            } else {
                $_SESSION['error_message'] = "Les informations de connexion sont incorrectes.";
            }
            // REQUETE: SELECT id_user WHERE id_account en session?
            // update le status_user à 1
        }
        $this->render("user/loginUser");
    }

    // ########################################
    //             DECONNEXION USER
    // ########################################
    public function logoutUser()
    {
        if (isset($_SESSION['id_user']) && isset($_SESSION['id_account'])) {
            // Récupérer l'ID de l'utilisateur depuis la session
            $id_user = $_SESSION['id_user'];

            // Instancier la classe User
            $user = new User();
            $user->setId_user($id_user);
            $user->setStatus_user(0);

            // Instancier la classe Account
            $account = new Account();
            $account->setId_account($_SESSION['id_account']);

            // Instancier la classe UserModel
            $userModel = new UserModel();

            // Mettre à jour le status_user à 0
            $userModel->updateUserStatus($account, $user);

            // Supprimer les variables de session spécifiques à l'utilisateur
            unset($_SESSION['id_user']);
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
        $this->render('user/profileUser');
    }
}
