<?php

namespace App\Controllers;

use App\Entities\Gift;
use App\Entities\Category;
use App\Entities\User;
use App\Entities\GiftList;
use App\Models\GiftModel;

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
        // var_dump($_POST);
        // die;

        $gift = new Gift();
        $gift->setName_gift($name_gift);
        $gift->setDescription_gift($description_gift);
        $gift->setReserved_gift($reserved_gift);

        $category = new Category();
        $category->setName_category($category_gift);


        $giftModel = new GiftModel();
        $id_gift = $giftModel->createGift($gift);
        $giftModel->createCategory($category);

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
    // ###################### PAGE LISTE CADEAUX #######################
    // ############################################################

    public function pageGiftList()
    {
        $this->render("gift/giftList");
    }
}
