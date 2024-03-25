<?php

namespace App\Models;

use App\Core\DbConnect;
use Exception;
use PDO;
use App\Entities\Account;

class AccountModel extends DbConnect
{
    public function createAccount(Account $account, $password)
    {
        try {
            $hashpassword = password_hash($account->getPassword_account(), PASSWORD_DEFAULT);

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
}
