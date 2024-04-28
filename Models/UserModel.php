<?php

namespace App\Models;


// On spécifie l'emplacement de la classe DbConnect à l'aide de la déclaration use pour permettre à PHP de localiser la classe DbConnect et de l'utiliser dans le code de UserModel. 
use App\Core\DbConnect;
use Exception;
use PDO;
use App\Entities\User;
use App\Entities\Account;

class UserModel extends DbConnect
{

    // ########################################
    //              INSERT USER
    // ########################################
    public function signUpUser(User $user, $passwordUser)
    {
        // suppression de la colone role_user car elle a une valeur par défaut dans la bdd
        try {
            $hashpassword = password_hash($passwordUser, PASSWORD_DEFAULT);
            $this->request = $this->connection->prepare("INSERT INTO c_user (nickname_user, picture_user, email_user, password_user, status_user, id_account)
            VALUES (:nickname_user, :picture_user, :email_user, :password_user, :status_user, :id_account)");

            $this->request->bindValue(':nickname_user', $user->getNickname_user());

            if (empty($user->getPicture_user())) {
                $this->request->bindValue(':picture_user', DEFAULT_AVATAR);
            } else {
                $this->request->bindValue(':picture_user', $user->getPicture_user());
            }

            $this->request->bindValue(':email_user', $user->getEmail_user());
            $this->request->bindValue(':password_user', $hashpassword);
            $this->request->bindValue(':status_user', $user->getStatus_user());
            $this->request->bindValue(':id_account', $user->getId_account());
            $this->request->execute();
        } catch (Exception $e) {
            echo "Erreur lors de la connexion à la base de données : " . $e->getMessage();
        }
    }

    // ########################################
    //              GET USER BY EMAIL
    // ########################################
    public function getUserByEmail($email_user)
    {
        try {
            $this->request = $this->connection->prepare('SELECT * FROM c_user WHERE email_user = :email_user');
            $this->request->bindValue(":email_user", $email_user);
            $this->request->execute();

            return $this->request->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Erreur lors de la connexion à la base de données : " . $e->getMessage();
        }
    }

    public function getUserById($userId)
    {
        try {
            $this->request = $this->connection->prepare("SELECT * FROM c_user WHERE id_user = :id_user");
            $this->request->bindValue('id_user', $userId);
            $this->request->execute();

            return $this->request->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Erreur lors de la connexion à la base de données : " . $e->getMessage();
        }
    }

    // ########################################
    //  SELECT USER PAR NICKNAME ET ID_ACCOUNT
    // ########################################
    // public function getUserByNicknameAndAccountId($nicknameUser, $idAccount)
    // {
    //     try {
    //         $this->request = $this->connection->prepare("SELECT * FROM `c_user` WHERE nickname_user = :nicknameUser AND id_account = :id_account");
    //         $this->request->bindValue(":nicknameUser", $nicknameUser);
    //         $this->request->bindValue(":id_account", $idAccount);
    //         $this->request->execute();

    //         $result = $this->request->fetch(PDO::FETCH_ASSOC);
    //         // var_dump($result);
    //         // die;
    //         return $result;
    //     } catch (Exception $e) {
    //         echo "Erreur lors de la connexion à la base de données : " . $e->getMessage();
    //     }
    // }

    // ########################################
    //       SELECT USERS PAR ID_ACCOUNT
    // ########################################
    // public function getUsersByAccountId(Account $account)
    // {
    //     try {
    //         $this->request = $this->connection->prepare("SELECT * FROM c_user WHERE id_account = :id_account");
    //         $this->request->bindValue(':id_account', $account->getId_account());
    //         $this->request->execute();

    //         $usersData = $this->request->fetchAll(PDO::FETCH_ASSOC);

    //         $listUsers = [];
    //         foreach ($usersData as $userData) {
    //             $user = new User();
    //             $user->setId_user($userData['id_user']);
    //             $user->setNickname_user($userData['nickname_user']);
    //             $user->setPicture_user($userData['picture_user']);
    //             $user->setEmail_user($userData['email_user']);
    //             $listUsers[] = $user;
    //         }
    //         return $listUsers;
    //     } catch (Exception $e) {
    //         echo "Erreur lors de la connexion à la base de données : " . $e->getMessage();
    //     }
    // }

    // ########################################
    //                LOGIN USER
    // ########################################
    public function signInUser(User $user)
    {
        try {
            $this->request = $this->connection->prepare("SELECT * FROM c_user WHERE nickname_user = :nickname_user");
            $this->request->bindValue(':nickname_user', $user->getNickname_user());

            $this->request->execute();

            $data = $this->request->fetch(PDO::FETCH_ASSOC);

            return $data;
        } catch (Exception $e) {
            echo "Erreur lors de la connexion à la base de données : " . $e->getMessage();
        }
    }


    // ########################################
    //       SELECT USERS PAR ID_ACCOUNT
    // ########################################
    public function getUserByIdUser(User $user)
    {
        try {
            $this->request = $this->connection->prepare("SELECT * FROM c_user WHERE id_user = :id_user");
            $this->request->bindValue(':id_user', $user->getId_user());
            $this->request->execute();

            $user = $this->request->fetch(PDO::FETCH_ASSOC);
            // var_dump($user);
            // die;
            return $user;
        } catch (Exception $e) {
            echo "Erreur lors de la connexion à la base de données : " . $e->getMessage();
        }
    }

    // ########################################
    //       SELECT USERS PAR STATUS
    // pour afficher la liste de chaque utilisateur non connecté
    // ########################################
    public function getUserByStatus(Account $account, User $user)
    {
        $this->request = $this->connection->prepare("SELECT * FROM c_user WHERE c_user.status_user = :status_user AND c_user.id_account = :id_account");
        $this->request->bindValue(':status_user', $user->getStatus_user());
        $this->request->bindValue(':id_account', $account->getId_account());
        $this->request->execute();
        $userByStatus = $this->request->fetchAll(PDO::FETCH_ASSOC);
        // echo '<pre>';
        // var_dump($userByStatus);
        // echo '</pre>';
        return $userByStatus;
    }

    // ########################################
    //      UPDATE STATUS USER SI CONNECTÉ
    // ########################################
    public function updateUserStatus(User $user)
    {
        try {
            $this->request = $this->connection->prepare("UPDATE c_user SET status_user = :status_user WHERE id_user = :id_user");
            $this->request->bindValue(':status_user', $user->getStatus_user());
            $this->request->bindValue(':id_user', $user->getId_user());
            $this->request->execute();
        } catch (Exception $e) {
            echo "Erreur lors de la mise à jour du statut de l'utilisateur : " . $e->getMessage();
        }
    }

    // ########################################
    //           DELETE PROFILE USER
    // ########################################
    public function deleteUser(User $user)
    {
        $this->request = $this->connection->prepare("DELETE FROM c_user WHERE id_user = :id_user");
        $this->request->bindValue('id_user', $user->getId_user());
        $this->request->execute();
    }

    // ########################################
    //           EDIT PROFILE USER
    // ########################################
    public function editUser(User $user, $avatar)
    {
        try {
            $this->request = $this->connection->prepare("UPDATE c_user SET nickname_user = :nickname_user, picture_user = :picture_user, email_user = :email_user, password_user = :password_user WHERE id_user = :id_user");
            $this->request->bindValue(':id_user', $user->getId_user());
            $this->request->bindValue(':nickname_user', $user->getNickname_user());
            $this->request->bindValue(':picture_user', $avatar);
            $this->request->bindValue(':email_user', $user->getEmail_user());
            $this->request->bindValue(':password_user', $user->getPassword_user());
            $this->request->execute();
        } catch (Exception $e) {
            echo "Erreur lors de la mise à jour du statut de l'utilisateur : " . $e->getMessage();
        }
    }
}
