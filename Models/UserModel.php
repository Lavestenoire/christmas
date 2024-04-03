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
    public function userCount(Account $account)
    {
        try {
            $this->request = $this->connection->prepare("SELECT COUNT(*) as count FROM c_user WHERE id_account = :id_Account");
            $this->request->bindValue(':id_Account', $account->getId_account());

            $this->request->execute();
            $result = $this->request->fetch(PDO::FETCH_ASSOC);
            // var_dump($result['count']);
            return $result['count'];
            // var_dump($result['count']);
        } catch (Exception $e) {
            echo "Erreur de récupération des données: " . $e->getMessage();
        }
    }


    public function addUser(User $user)
    {
        try {
            $this->request = $this->connection->prepare("INSERT INTO c_user (nickname_user, picture_user, question_user, response_user, role_user, status_user, id_account)
            VALUES (:nickname, :picture, :question, :response, :role, :status, :id_account)");

            $this->request->bindValue(':nickname', $user->getNickname_user());

            if (empty($user->getPicture_user())) {

                $this->request->bindValue(":picture", DEFAULT_PICTURE);
            } else {
                $this->request->bindValue(":picture", $user->getPicture_user());
            }
            $this->request->bindValue(':question', $user->getQuestion_user());
            $this->request->bindValue(':response', $user->getResponse_user());
            $this->request->bindValue(':role', $user->getRole_user());
            $this->request->bindValue(':status', $user->getStatus_user());
            $this->request->bindValue(':id_account', $user->getId_account());

            $this->request->execute();
        } catch (Exception $e) {
            echo "Erreur lors de la connexion à la base de données : " . $e->getMessage();
        }
    }
    // public function getUserbyNickname($idAccount)
    // {
    //     try {
    //         // $this->request = $this->connection->prepare('SELECT * FROM c_user WHERE nickname_user = :nickname');
    //         $this->request = $this->connection->prepare("SELECT nickname_user FROM `c_user` WHERE id_account = :id_Account");
    //         $this->request->bindValue(":id_Account", $idAccount);
    //         $this->request->execute();

    //         $result = $this->request->fetchAll(PDO::FETCH_ASSOC);
    //         // var_dump($result);
    //         // die;
    //         return $result;
    //     } catch (Exception $e) {
    //         echo "Erreur lors de la connexion à la base de données : " . $e->getMessage();
    //     }
    // }
    public function getUserByNicknameAndAccountId($nicknameUser, $idAccount)
    {
        try {
            $this->request = $this->connection->prepare("SELECT * FROM `c_user` WHERE nickname_user = :nicknameUser AND id_account = :idAccount");
            $this->request->bindValue(":nicknameUser", $nicknameUser);
            $this->request->bindValue(":idAccount", $idAccount);
            $this->request->execute();

            $result = $this->request->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $e) {
            echo "Erreur lors de la connexion à la base de données : " . $e->getMessage();
        }
    }

    public function getUsersByAccountId(Account $account)
    {
        try {
            $this->request = $this->connection->prepare("SELECT * FROM c_user WHERE id_account = :id_Account");
            $this->request->bindValue(':id_Account', $account->getId_account());
            $this->request->execute();

            $usersData = $this->request->fetchAll(PDO::FETCH_ASSOC);

            $listUsers = [];
            foreach ($usersData as $userData) {
                $user = new User();
                $user->setNickname_user($userData['nickname_user']);
                $listUsers[] = $user;
            }
            return $listUsers;
        } catch (Exception $e) {
            echo "Erreur lors de la connexion à la base de données : " . $e->getMessage();
        }
    }
}
