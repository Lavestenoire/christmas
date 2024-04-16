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
        $name_gift = $_POST['name_gift'];
        $description_gift = $_POST['description_gift'];
        $reserved_gift = $_POST['reserved_gift'];
        $category_gift = $_POST['category_gift'];

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

    public function secretPage()
    {
        $id_account = $_SESSION['id_account'];
        $account = new Account();
        $account->setId_account($id_account);

        $user = new User();
        $user->setStatus_user(0);

        $userModel = new UserModel();
        // récupération des users dont le statut est setté à 0
        $getUserByStatus = $userModel->getUserByStatus($account, $user);
        // var_dump($getUserByStatus);

        $giftLists = [];

        foreach ($getUserByStatus as $value) {
            $giftModel = new GiftModel();
            $user->setId_user($value['id_user']);
            $giftList = $giftModel->listByStatus($user);
            $giftLists[$value['nickname_user']] = $giftList;
        }

        // echo '<pre>';
        // var_dump($giftLists);
        // echo '</pre>';
        // die;

        $this->render('gift/secretPage', ['giftLists' => $giftLists]);
    }

    public function getCategoryHint()
    {
        $search = isset($_GET['q']) ? $_GET['q'] : '';
        $giftModel = new giftModel();
        $categories = $giftModel->getNameCategory($search);
        echo json_encode($categories);
    }

    public function reservedGift()
    {
        // Vérifier si le formulaire a été soumis
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Vérifier si des cases à cocher ont été cochées
            if (isset($_POST['gift']) && is_array($_POST['gift'])) {
                // Récupérer les valeurs des cases à cocher cochées
                $gifts = $_POST['gift'];
                // Faire quelque chose avec les valeurs des cases à cocher cochées
                foreach ($gifts as $giftId) {
                    // var_dump($giftId);
                    // die;
                    // Traiter chaque valeur de case à cocher cochée = update status gift à 1 pour réservé
                    $gift = new Gift();
                    $gift->setReserved_gift(1);
                    $gift->setId_gift($gifts);

                    $giftModel = new GiftModel();
                    $giftModel->reservedGift($giftId);
                }
            }
        }
    }
}
