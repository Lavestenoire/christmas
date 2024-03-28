<?php

namespace App\Models;

use App\Core\DbConnect;
use Exception;
use PDO;
use App\Entities\Account;

class AccountModel extends DbConnect
{
    // ############################################################
    // #######################CREATE ACCOUNT#######################
    // ############################################################
    public function createAccount(Account $account, $password)
    // Passer le $password en argument: Pour hacher le mot de passe, vous devez accéder au mot de passe brut, ce qui nécessite de le passer en argument.
    {
        try {
            $hashpassword = password_hash($password, PASSWORD_DEFAULT);

            $this->request = $this->connection->prepare("INSERT into c_account VALUES (NULL, :nickname, :email, :password)");
            $this->request->bindValue(":nickname", $account->getNickname_account());
            $this->request->bindValue(":email", $account->getEmail_account());
            $this->request->bindValue(":password", $hashpassword);
            // Dans le modèle, la méthode createAccount() récupère les données de l'objet Account en utilisant les getters, prépare la requête d'insertion et lie les valeurs aux paramètres nommés. Enfin, elle exécute la requête pour insérer les données dans la base de données.
            $this->request->execute();
        } catch (Exception $e) {
            echo "Erreur lors de la connexion à la base de données : " . $e->getMessage();
        }
    }

    public function getAccountByEmail($email)
    {
        $this->request = $this->connection->prepare('SELECT * FROM c_account WHERE email_account = :email');
        $this->request->bindValue(":email", $email);
        $this->request->execute();

        return $this->request->fetch(PDO::FETCH_ASSOC);
    }


    // ############################################################
    // ######################### LOGIN ############################
    // ############################################################
    public function loginAccount(Account $account)
    {
        try {
            // ici on utilise l'opérateur = pour comparer la valeur de la colonne nickname_account. Si la valeur correspond, la ligne est renvoyée dans le résultat de la requête
            $this->request = $this->connection->prepare("SELECT * FROM c_account WHERE nickname_account = :nicknameLogin");
            $this->request->bindValue(":nicknameLogin", $account->getNickname_account());
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
