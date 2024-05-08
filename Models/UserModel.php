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

    public function getUsersByTagAccount(Account $account)
    {
        try {
            $this->request = $this->connection->prepare("SELECT * FROM c_user JOIN c_account ON c_user.id_account = c_account.id_account WHERE c_account.tag_account = :tag_account");
            $this->request->bindValue('tag_account', $account->getTag_account());
            $this->request->execute();

            return $this->request->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Erreur lors de la connexion à la base de données : " . $e->getMessage();
        }
    }


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
    public function getUserByIdUser($idUser)
    {
        try {
            $this->request = $this->connection->prepare("SELECT * FROM c_user WHERE id_user = :id_user");
            $this->request->bindValue(':id_user', $idUser);
            $this->request->execute();

            return $this->request->fetch(PDO::FETCH_ASSOC);
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
