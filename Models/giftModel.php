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
use App\Entities\Account;
use App\Entities\CategoryGift;

class GiftModel extends DbConnect
{
    // ############################################################
    // ####################### CRÉATION CADEAUX ###################
    // ############################################################
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

    // ############################################################
    // ###################### CRÉATION CATÉGORIES #################
    // ############################################################
    public function createCategory(Category $category)
    {
        try {
            $this->request = $this->connection->prepare("INSERT into c_category (name_category) VALUES (:name_category)");
            $this->request->bindValue(':name_category', $category->getName_category());

            $this->request->execute();

            $lastInsertedCategory = $this->connection->lastInsertId();
            return $lastInsertedCategory;
        } catch (Exception $e) {
            echo "Erreur lors de la connexion à la base de données : " . $e->getMessage();
        }
    }

    // ############################################################
    // ############### RECUPERER LES GIFTS PAR LEUR ID ############
    // ############################################################

    public function getGiftbyId(Gift $gift, Category $category)
    {
        try {
            $this->request = $this->connection->prepare("SELECT * FROM c_gift 
            JOIN c_categorygift ON c_gift.id_gift = c_categorygift.id_gift
            JOIN c_category ON c_categorygift.id_category = c_category.id_category
            WHERE c_gift.id_gift = :id_gift AND c_category.id_category = :id_category");
            $this->request->bindValue('id_gift', $gift->getId_gift());
            $this->request->bindValue(':id_category', $category->getId_category());
            $this->request->execute();
            $result = $this->request->fetch();
            return $result;
        } catch (Exception $e) {
            echo "Erreur lors de la connexion à la base de données : " . $e->getMessage();
        }
    }

    // ############################################################
    // #################### AJOUT IDs À GIFTLIST ##################
    // ############################################################
    public function addIdsToGiftList(GiftList $giftList, User $user)
    {
        try {
            $this->request = $this->connection->prepare("INSERT into c_giftList (id_gift, id_user) VALUES (:id_gift, :id_user)");
            $this->request->bindValue(':id_gift', $giftList->getId_gift());
            $this->request->bindValue(':id_user', $user->getId_user());
            $this->request->execute();
        } catch (Exception $e) {
            echo "Erreur lors de la connexion à la base de données : " . $e->getMessage();
        }
    }

    public function addIdsToCategoryList(CategoryGift $categoryGift)
    {
        $this->request = $this->connection->prepare("INSERT into c_categoryGift (id_category, id_gift) VALUES (:id_category, :id_gift)");
        $this->request->bindValue('id_category', $categoryGift->getId_category());
        $this->request->bindValue('id_gift', $categoryGift->getId_gift());
        $this->request->execute();
    }


    // ############################################################
    // ####### POUR VERIFIER SI LA CATEGORIE EXISTE DEJA ##########
    // ############################################################
    public function getCategoryByName(Category $category)
    {
        try {
            $this->request = $this->connection->prepare("SELECT id_category FROM c_category WHERE name_category = :name_category");
            $this->request->bindValue(':name_category', $category->getName_category());
            $this->request->execute();

            $result = $this->request->fetch();
            // dans ce cas précis, nous n'avons pas besoin de récupérer les données sous forme de tableau associatif. Nous avons simplement besoin de vérifier si la requête renvoie une ligne ou non. Si la requête renvoie une ligne, cela signifie que la catégorie existe déjà dans la base de données. Dans ce cas, nous n'avons pas besoin de récupérer les données de cette ligne, nous avons juste besoin de savoir qu'elle existe. C'est pourquoi nous utilisons fetch() sans paramètre, qui renvoie simplement un tableau numéroté contenant les données de la ligne. Si la requête ne renvoie aucune ligne, fetch() renvoie false.
            if ($result) {
                return $result->id_category;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo "Erreur lors de la connexion à la base de données : " . $e->getMessage();
        }
    }
    // ############################################################
    // ###################### LISTE CADEAUX #######################
    // ############################################################
    public function giftList(GiftList $giftList)
    {
        try {
            $this->request = $this->connection->prepare(
                "SELECT c_gift.id_gift, c_gift.name_gift, c_gift.description_gift, c_category.name_category, c_category.id_category
                FROM c_gift
                JOIN c_categorygift
                ON c_gift.id_gift = c_categorygift.id_gift
                JOIN c_category
                ON c_categorygift.id_category = c_category.id_category
                JOIN c_giftlist
                ON c_gift.id_gift = c_giftlist.id_gift
                WHERE c_giftlist.id_user = :id_user"
            );
            $this->request->bindValue(':id_user', $giftList->getId_user());
            $this->request->execute();

            $list = $this->request->fetchAll(PDO::FETCH_ASSOC);

            return $list;
        } catch (Exception $e) {
            echo "Erreur lors de la connexion à la base de données : " . $e->getMessage();
            return [];
        }
    }
    // ############################################################
    //                      EDIT GIFT
    // ############################################################
    public function editGift(Gift $gift, Category $category)
    {
        try {
            // Update the c_gift table
            $this->request = $this->connection->prepare("UPDATE c_gift JOIN c_categorygift ON c_gift.id_gift = c_categorygift.id_gift
        SET c_gift.name_gift = :name_gift,
            c_gift.description_gift = :description_gift
        WHERE c_gift.id_gift = :id_gift AND c_categorygift.id_category = :id_category");

            $this->request->bindValue(':name_gift', $gift->getName_gift());
            $this->request->bindValue(':description_gift', $gift->getDescription_gift());
            $this->request->bindValue(':id_gift', $gift->getId_gift());
            $this->request->bindValue(':id_category', $category->getId_category());
            $this->request->execute();

            // Update the c_category table
            $this->request = $this->connection->prepare("UPDATE c_category
        SET name_category = :name_category
        WHERE id_category = :id_category");

            $this->request->bindValue(':name_category', $category->getName_category());
            $this->request->bindValue(':id_category', $category->getId_category());
            $this->request->execute();
        } catch (Exception $e) {
            echo "Erreur lors de la récupération des données : " . $e->getMessage();
        }
    }
    // ############################################################
    //                      DELETE GIFT
    // ############################################################
    public function deleteGift(GiftList $giftList)
    {
        try {
            $this->request = $this->connection->prepare(
                "DELETE c_gift.*
                FROM c_gift
                JOIN c_categorygift ON c_gift.id_gift = c_categorygift.id_gift
                JOIN c_category ON c_categorygift.id_category = c_category.id_category
                JOIN c_giftlist ON c_gift.id_gift = c_giftlist.id_gift
                WHERE c_giftlist.id_user = :id_user AND c_gift.id_gift = :id_gift"
            );
            $this->request->bindValue(':id_user', $giftList->getId_user());
            $this->request->bindValue(':id_gift', $giftList->getId_gift());
            $this->request->execute();
        } catch (Exception $e) {
            echo "Erreur lors de la connexion à la base de données : " . $e->getMessage();
            return [];
        }
    }

    // ############################################################
    //                  LISTE CADEAUX STATUS 0
    // ############################################################
    public function listByStatus(User $user)
    {
        try {
            $this->request = $this->connection->prepare("SELECT c_gift.id_gift, c_gift.name_gift, c_gift.description_gift, c_gift.reserved_gift, c_category.name_category
        FROM c_gift
        JOIN c_giftlist ON c_gift.id_gift = c_giftlist.id_gift
        JOIN c_user ON c_giftlist.id_user = c_user.id_user
        JOIN c_categorygift ON c_gift.id_gift = c_categorygift.id_gift
        JOIN c_category ON c_categorygift.id_category = c_category.id_category
        WHERE c_user.status_user = :status_user AND c_user.id_user = :id_user");
            $this->request->bindValue(':status_user', $user->getStatus_user());
            $this->request->bindValue(':id_user', $user->getId_user());
            $this->request->execute();

            $listByStatus = $this->request->fetchAll(PDO::FETCH_ASSOC);
            return $listByStatus;
        } catch (Exception $e) {
            echo "Erreur lors de la récupération de cadeaux par statut user : " . $e->getMessage();
        }
    }
    // ############################################################
    //        POUR L'AUTOCOMPLETION DES CATEGORIES
    // ############################################################
    public function getNameCategory($search)
    {
        try {
            if (!empty($search)) {
                $this->request = $this->connection->prepare("SELECT name_category FROM c_category WHERE name_category LIKE :search");
                $this->request->bindValue(':search', "%$search%");
            } else {
                $this->request = $this->connection->prepare("SELECT name_category FROM c_category");
            }
            $this->request->execute();
            $catList = $this->request->fetchAll(PDO::FETCH_ASSOC);
            return $catList;
        } catch (Exception $e) {
            echo "Erreur lors de la récupération de catégories de cadeaux : " . $e->getMessage();
        }
    }

    // ############################################################
    //                      MISE A JOUR STATUTS CADEAUX
    // ############################################################

    public function updateReservedGift(Gift $gift)
    {
        try {
            $this->request = $this->connection->prepare("UPDATE c_gift SET reserved_gift = :reserved_gift WHERE id_gift = :id_gift");
            $this->request->bindValue(':reserved_gift', $gift->getReserved_gift());
            $this->request->bindValue(':id_gift', $gift->getId_gift());
            $this->request->execute();
        } catch (Exception $e) {
            echo "Erreur lors de la mise à jour du status de réservation de cadeaux : " . $e->getMessage();
        }
    }

    // ############################################################
    //                      LISTE À OFFRIR
    // ############################################################
    public function giftToOffer(Gift $gift, User $user)
    {
        try {
            $this->request = $this->connection->prepare("SELECT c_gift.id_gift, c_gift.name_gift, c_gift.description_gift, c_gift.reserved_gift, c_category.name_category, c_user.nickname_user
        FROM c_gift
        JOIN c_giftlist ON c_gift.id_gift = c_giftlist.id_gift
        JOIN c_user ON c_giftlist.id_user = c_user.id_user
        JOIN c_account ON c_user.id_account = c_account.id_account
        JOIN c_categorygift ON c_gift.id_gift = c_categorygift.id_gift
        JOIN c_category ON c_categorygift.id_category = c_category.id_category
        WHERE c_gift.reserved_gift = :reserved_gift AND c_user.status_user = :status_user");

            $this->request->bindValue('reserved_gift', $gift->getReserved_gift());
            $this->request->bindValue('status_user', $user->getStatus_user());
            $this->request->execute();

            $listToOffer = $this->request->fetchAll(PDO::FETCH_ASSOC);
            // echo '<pre>';
            // var_dump($listToOffer);
            // echo '</pre>';
            // die;
            return $listToOffer;
        } catch (Exception $e) {
            echo "Erreur lors de la récupération des données : " . $e->getMessage();
        }
    }
}
