<?php

namespace App\Models;

use App\Core\DbConnect;
use Exception;
use PDO;
use App\Entities\Account;

class AccountModel extends DbConnect
{
    // ############################################################
    // ####################### CREATE ACCOUNT #####################
    // ############################################################
    public function createAccount(Account $account, $password)
    {
        try {
            $hashpassword = password_hash($password, PASSWORD_DEFAULT);

            $this->request = $this->connection->prepare("INSERT INTO c_account (nickname_account, email_account, password_account) VALUES (:nickname, :email, :password)");
            $this->request->bindValue(":nickname", $account->getNickname_account());
            $this->request->bindValue(":email", $account->getEmail_account());
            $this->request->bindValue(":password", $hashpassword);
            $this->request->execute();

            // Renvoyer l'ID du compte nouvellement créé. Cela permet de le mettre en session afin que l'utilisateurt soit connecté dès qu'il est inscrit. Sinon il serait inscrit, mais devrait se connecter ensuite
            return $this->connection->lastInsertId();
        } catch (Exception $e) {
            // Gérer l'exception de manière appropriée
            throw new Exception("Erreur lors de l'insertion du compte : " . $e->getMessage());
        }
    }
    // ############################################################
    // ####################### GET ACCOUNT BY ID ##################
    // ############################################################
    public function getAccountById($accountId)
    {
        try {
            $this->request = $this->connection->prepare("SELECT * FROM c_account WHERE id_account = :id");
            $this->request->bindValue(":id", $accountId);
            $this->request->execute();

            // Renvoyer les informations du compte sous forme de tableau associatif
            return $this->request->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            // Gérer l'exception de manière appropriée
            throw new Exception("Erreur lors de la récupération du compte : " . $e->getMessage());
        }
    }
    // ############################################################
    // ####################### GET ACCOUNT BY EMAIL ###############
    // ############################################################

    public function getAccountByEmail($email)
    {
        try {
            $this->request = $this->connection->prepare('SELECT * FROM c_account WHERE email_account = :email');
            $this->request->bindValue(":email", $email);
            $this->request->execute();

            return $this->request->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Erreur lors de la connexion à la base de données : " . $e->getMessage();
        }
    }


    // ############################################################
    //                           LOGIN 
    // ############################################################
    public function loginAccount(Account $account)
    {
        try {
            // ici on utilise l'opérateur = pour comparer la valeur de la colonne nickname_account. Si la valeur correspond, la ligne est renvoyée dans le résultat de la requête
            $this->request = $this->connection->prepare("SELECT * FROM c_account WHERE nickname_account = :nickname_account");
            $this->request->bindValue(":nickname_account", $account->getNickname_account());
            $this->request->execute();

            $result = $this->request->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                if (password_verify($account->getPassword_account(), $result['password_account'])) {
                    return $result;
                } else {
                    return false;
                }
            }
        } catch (Exception $e) {
            echo "Erreur :" . $e->getMessage();
            return false;
        }
    }
}
