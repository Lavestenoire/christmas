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
    public function statusAdminExists(Account $account)
    {
        $this->request = $this->connection->prepare("SELECT EXISTS(
            SELECT 1
            FROM c_user
            INNER JOIN c_account ON c_user.id_account = c_account.id_account
            WHERE c_user.status_user = 1 AND c_account.id_account = :id_account
        ) as 'exists'
        ");
        // Prepares an SQL statement to be executed by the PDOStatement::execute() method. The statement template can contain zero or more named (:name) or question mark (?) parameter markers for which real values will be substituted when the statement is executed. Both named and question mark parameter markers cannot be used within the same statement template; only one or the other parameter style. Use these parameters to bind any user-input, do not include the user-input directly in the query.
        $this->request->bindValue(':id_account', $account->getId_account());
        // $idAccount correspond à la valeur réelle à lier au marqueur de position ?.
        // PDO::PARAM_INT est utilisé pour spécifier le type de données de la valeur liée (dans ce cas, un entier).
        $this->request->execute();
        $result = $this->request->fetch(PDO::FETCH_ASSOC);

        // si == 1 la méthode renverra true, sinon false
        return $result['exists'] == 1;
    }

    public function addUser(User $user)
    {
        try {
            $this->request = $this->connection->prepare("INSERT INTO c_user (nickname_user, picture_user, question_user, response_user, role_user, status_user, id_account)
            VALUES (:nickname, :picture, :question, :response, :role, :status, :id_account)");
            $this->request->bindValue(':nickname', $user->getNickname_user());
            $this->request->bindValue(':picture', $user->getPicture_user());
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
}
