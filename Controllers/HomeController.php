<?php

namespace App\Controllers;

use App\Entities\User;
use App\Entities\Account;
use App\Models\UserModel;



class HomeController extends Controller
{
    public function index()
    {
        if (isset($_SESSION['idAccount'])) {
            $account = new Account();
            $account->setId_account($_SESSION['idAccount']);

            $userModel = new UserModel();
            $userAdminExists = $userModel->statusAdminExists($account);
            // var_dump($userAdminExists);
            // die;

            if ($userAdminExists) {
                $showProfiles = true;
                $showForm = false;
            } else {
                $showProfiles = false;
                $showForm = true;
            }
            // var_dump($userAdminExists);

            $this->render("home/index", ["showProfiles" => $showProfiles, "showForm" => $showForm]);
        } else {
            $this->render("home/index");
        }
    }
}
