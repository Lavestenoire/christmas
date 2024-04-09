<?php

namespace App\Models;


// On spécifie l'emplacement de la classe DbConnect à l'aide de la déclaration use pour permettre à PHP de localiser la classe DbConnect et de l'utiliser dans le code de UserModel. 
use App\Core\DbConnect;
use Exception;
use PDO;
use App\Entities\Gift;
use App\Entities\Category;
use App\Entities\GiftList;
use App\Entities\User;

class GiftModel extends DbConnect
{
    public function createGift(Gift $gift)
    {
        try {
            $this->request = $this->connection->prepare("INSERT into c_gift (name_gift, description_gift, reserved_gift) VALUES(:name_gift, :description_gift, :reserved_gift)");
            $this->request->bindValue(':name_gift', $gift->getName_gift());
            $this->request->bindValue(':description_gift', $gift->getDescription_gift());
            $this->request->bindValue(':reserved_gift', $gift->getReserved_gift());
            $this->request->execute();

            // récupérer l'id du cadeau afin de l'ajouter à c_giftList
            $lastIntertedGift = $this->connection->lastInsertId();
            return $lastIntertedGift;
            // 
        } catch (Exception $e) {
            echo "Erreur lors de la connexion à la base de données : " . $e->getMessage();
        }
    }

    public function createCategory(Category $category)
    {
        try {
            $this->request = $this->connection->prepare("INSERT into c_category (name_category) VALUE(:name_category)");
            $this->request->bindValue(':name_category', $category->getName_category());

            $this->request->execute();
        } catch (Exception $e) {
            echo "Erreur lors de la connexion à la base de données : " . $e->getMessage();
        }
    }

    public function addIdsToGiftList(GiftList $giftList, User $user)
    {
        $this->request = $this->connection->prepare("INSERT into c_giftList (id_gift, id_user) VALUES (:id_gift, :id_user)");
        $this->request->bindValue(':id_gift', $giftList->getId_gift());
        $this->request->bindValue(':id_user', $user->getId_user());
        $this->request->execute();
    }
}
