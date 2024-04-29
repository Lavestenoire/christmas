<?php

namespace App\Controllers;

use App\Entities\User;
use App\Entities\Account;
use App\Models\UserModel;



class HomeController extends Controller
{
    // public function index()
    // {
    //     if (isset($_SESSION['id_account'])) {

    //         $account = new Account();

    //         $account->setId_account($_SESSION['id_account']);

    //         $userModel = new UserModel();
    //         // vérifier qu'au moins 1 account est admin
    //         $userCount = $userModel->userCount($account);
    //         //    var_dump($userCount);     
    //         if ($userCount > 0) {
    //             $showProfiles = true;
    //             $showForm = false;
    //             $users = $userModel->getUsersByAccountId($account);
    //         } else {
    //             $showProfiles = false;
    //             $showForm = true;
    //             $users = [];
    //         }
    //         // var_dump($userAdminExists);
    //         $this->render("home/index", ["showProfiles" => $showProfiles, "showForm" => $showForm, 'users' => $users]);
    //     } else {
    //         $users = [];
    //         $this->render("home/index", ["showProfiles" => false, "showForm" => true, 'users' => $users]);
    //     }
    // }
    public function index()
    {
        $this->render("home/index");
    }

    public function cgu()
    {
        $this->render("home/cgu");
    }

    public function signUpPage()
    {
        $this->render("home/signUpPage");
    }
}
