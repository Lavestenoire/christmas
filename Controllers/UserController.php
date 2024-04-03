<?php

namespace App\Controllers;

use App\Entities\User;
use App\Models\UserModel;

class UserController extends Controller
{
    public function addUser()
    {
        if (isset($_POST['addAUser'])) {
            // var_dump($_SESSION['id_Account']);
            $user = new User;
            $idAccount = $_SESSION['id_Account'];
            $nicknameUser = $this->protectedValues($_POST['nickname_user']);
            $question = $this->protectedValues($_POST['question']);
            $response = $this->protectedValues($_POST['response']);
            $role = $this->protectedValues($_POST['role_user']);
            $status = $this->protectedValues($_POST['status_user']);
            // var_dump($_POST);

            $user->setId_account($idAccount);
            $user->setNickname_user($nicknameUser);
            $user->setQuestion_user($question);
            $user->setResponse_user($response);
            $user->setStatus_user($role);
            $user->setRole_user($status);
            $user->setPicture_user(DEFAULT_PICTURE);

            $userModel = new UserModel();
            $existingAccount = $userModel->getUserByNicknameAndAccountId($nicknameUser, $idAccount);
            // var_dump($existingAccount);
            // die;
            if ($existingAccount) {
                $_SESSION['error_message'] = "Cet pseudo existe déjà, merci d'en sélectionner un autre.";
                $this->render("user/index");
            } else {
                $userModel->addUser($user);
                $users = $userModel->getUsersByAccountId($idAccount);
                $this->render('home/index', ['showProfiles' => true, 'users' => $users]);
            }
        }
    }

    public function addUserPage()
    {
        $this->render('user/index');
    }
}
