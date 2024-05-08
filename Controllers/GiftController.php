<?php

namespace App\Controllers;

use App\Entities\Account;
use App\Entities\Gift;
use App\Entities\Category;
use App\Entities\CategoryGift;
use App\Entities\User;
use App\Entities\GiftList;
use App\Models\GiftModel;
use App\Models\UserModel;

class giftController extends Controller
{
    // ############################################################
    // ###################### PAGE CREATION CADEAU ################
    // ############################################################
    public function pageCreateGift()
    {
        $this->render("gift/createGift");
    }

    // ############################################################
    // ###################### CREATION CADEAU #####################
    // ############################################################
    public function createGift()
    {
        $name_gift = $this->protectedValues($_POST['name_gift']);
        $description_gift = $this->protectedValues($_POST['description_gift']);
        $reserved_gift = $this->protectedValues($_POST['reserved_gift']);
        $category_gift = $this->protectedValues($_POST['category_gift']);

        $gift = new Gift();
        $gift->setName_gift($name_gift);
        $gift->setDescription_gift($description_gift);
        $gift->setReserved_gift($reserved_gift);

        $category = new Category();
        $category->setName_category($category_gift);

        $giftModel = new GiftModel();
        $id_gift = $giftModel->createGift($gift);

        // Vérifiez si la catégorie existe déjà
        $existing_category_id = $giftModel->getCategoryByName($category);
        if ($existing_category_id) {
            // La catégorie existe déjà, utilisez son ID pour lier le cadeau à cette catégorie
            $categoryGift = new CategoryGift();
            $categoryGift->setId_category($existing_category_id);
            $categoryGift->setId_gift($id_gift);
            $giftModel->addIdsToCategoryList($categoryGift);
        } else {
            // La catégorie n'existe pas, créez-la et liez-la au cadeau
            $id_category = $giftModel->createCategory($category);
            $categoryGift = new CategoryGift();
            $categoryGift->setId_category($id_category);
            $categoryGift->setId_gift($id_gift);
            $giftModel->addIdsToCategoryList($categoryGift);
        }

        $id_user = $_SESSION['id_user'];

        $user = new User();
        $user->setId_user($id_user);

        $giftList = new GiftList();
        $giftList->setId_gift($id_gift);

        $giftModel->addIdsToGiftList($giftList, $user);

        header('Location: pageCreateGift?message=gift_added');
        exit();
    }


    // ############################################################
    // ###################### LISTE CADEAUX #######################
    // ############################################################
    public function giftList()
    {
        $id_user = $_SESSION['id_user'];

        $giftList = new GiftList();
        $giftList->setId_user($id_user);

        $giftModel = new GiftModel();
        $list = $giftModel->giftList($giftList);

        $this->render('gift/giftList', ['list' => $list]);
    }


    public function getUpdatedGift()
    {
        $id_gift = $_POST['id_gift'];
        $id_category = $_POST['id_category'];

        $gift = new Gift();
        $gift->setId_gift($id_gift);

        $category = new Category();
        $category->setId_category($id_category);

        $giftModel = new GiftModel();
        $gift = $giftModel->getGiftById($gift, $category);

        // $categoryName = $gift['category']->getName_category();
        // // le tableau permet de formater les données pour qu'elles soient compatibles en JS
        // $response = array(
        //     'id_gift' => $gift['id_gift'],
        //     'name_gift' => $gift['name_gift'],
        //     'description_gift' => $gift['description_gift'],
        //     'name_category' => $categoryName
        // );


        header('Content-Type: application/json');
        echo json_encode($gift);
    }
    // ############################################################
    //                      DELETE GIFT
    // ############################################################
    public function deleteGift()
    {
        $id_user = $_SESSION['id_user'];
        $id_gift = $_GET['id_gift'];


        $giftList = new GiftList();
        $giftList->setId_user($id_user);
        $giftList->setId_gift($id_gift);


        $giftModel = new GiftModel();
        $giftModel->deleteGift($giftList);

        header("Location: giftList");
    }
    // ############################################################
    //                   EDIT GIFT DANS MA LISTE
    // ############################################################
    public function editGift()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_gift = isset($_POST['id_gift']) ? $_POST['id_gift'] : null;
            $name_gift = isset($_POST['name_gift']) ? $_POST['name_gift'] : null;
            $description_gift = isset($_POST['description_gift']) ? $_POST['description_gift'] : null;
            $name_category = isset($_POST['name_category']) ? $_POST['name_category'] : null;
            $id_category = isset($_POST['id_category']) ? $_POST['id_category'] : null;
            var_dump($_POST);



            // Créer un objet Gift avec les valeurs récupérées
            $gift = new Gift();
            $gift->setId_gift($id_gift);
            $gift->setName_gift($name_gift);
            $gift->setDescription_gift($description_gift);

            // Créer un objet Category avec les valeurs récupérées
            $category = new Category();
            $category->setId_category($id_category);
            $category->setName_category($name_category);

            // Appeler la méthode editGift de votre modèle pour mettre à jour le cadeau dans la base de données
            $model = new GiftModel();
            $success = $model->editGift($gift, $category);

            // Retourner une réponse au client
            if ($success) {
                $response = ['success' => $success];
                header('Content-Type: application/json');
                echo json_encode($response);
            } else {
                $response = ['success' => $success];
                header('Content-Type: application/json');
                echo json_encode($response);
            }
        }
    }




    // ############################################################
    // ###################### PAGE SECRÈTE #######################
    // ############################################################

    public function secretPage()
    {
        if (!isset($_SESSION['id_user'])) {
            header('Location: home');
            exit();
        }

        // Récupérer la giftList de chaque utilisateur n'étant pas connecté
        $id_account = $_SESSION['id_account'];

        $account = new Account();
        $account->setId_account($id_account);

        // Définition du status_user à 0 pour "non connecté"
        $user = new User();
        $user->setStatus_user(0);

        // Récupération la liste des users dont le statut est setté à 0
        $userModel = new UserModel();
        $getUserByStatus = $userModel->getUserByStatus($account, $user);

        $giftLists = [];
        // pour chaque utilisateur non connecté
        foreach ($getUserByStatus as $value) {
            $giftModel = new GiftModel();
            $user->setId_user($value['id_user']);

            // $gift = new Gift();
            // $gift->setReserved_gift(0);

            // Récupérer les données pour la liste des cadeaux de chaque utilisateur non connecté
            $giftList = $giftModel->listByStatus($user);
            $giftLists[$value['nickname_user']] = $giftList;
        }

        // Récupérer la listToOffer
        $gift = new Gift();
        $gift->setReserved_gift(1);

        $account = new Account();
        $account->setId_account($_SESSION['id_account']);


        $giftModel = new GiftModel();
        $listToOffer = $giftModel->giftToOffer($gift, $user, $account);

        $this->render('gift/secretPage', ['giftList' => $giftLists, 'listToOffer' => $listToOffer]);
    }

    // ############################################################
    //           PAGE SECRÈTE UPDATE RESERVED_GIFT 
    //      à la suppression d'un cadeau de la liste à offrir
    // ############################################################
    public function deleteGiftToOffer()
    {
        $id_gift = $_POST['id_gift'];
        $gift = new Gift();
        $gift->setId_gift($id_gift);
        $gift->setReserved_gift(0);

        $giftModel = new GiftModel($gift);
        $giftModel->updateReservedGift($gift);
        header('Location: secretPage');
    }

    // ############################################################
    //                    SEARCH CATEGORY
    // ############################################################
    public function getCategoryHint()
    {
        $search = isset($_GET['q']) ? $_GET['q'] : '';
        $giftModel = new giftModel();
        $categories = $giftModel->getNameCategory($search);
        echo json_encode($categories);
    }

    // ############################################################
    //               MISE E JOUR CADEAU RESERVÉ
    // ############################################################
    public function reservedGift()
    {
        // Vérifier si le formulaire a été soumis
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Vérifier si des cases à cocher ont été cochées
            if (is_array($_POST['gift']) || is_string($_POST['gift'])) {
                // Convertir la chaîne de caractères en tableau si nécessaire
                $gifts = is_string($_POST['gift']) ? array($_POST['gift']) : $_POST['gift'];

                // Faire quelque chose avec les valeurs des cases à cocher cochées
                foreach ($gifts as $giftId) {
                    // Traiter chaque valeur de case à cocher cochée = update status gift à 1 pour réservé
                    $gift = new Gift();
                    $gift->setReserved_gift(1);
                    $gift->setId_gift($giftId);

                    $giftModel = new GiftModel();
                    $giftModel->updateReservedGift($gift);
                }
            }
            header("Location: secretPage");
        }
    }
}
