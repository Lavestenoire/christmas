<?php

namespace App\Controllers;

use App\Entities\User;
use App\Entities\Account;
use App\Models\UserModel;



class HomeController extends Controller
{

    public function index()
    {
        $this->render("Home/index");
    }

    public function cgu()
    {
        $this->render("Home/cgu");
    }

    public function pdc()
    {
        $this->render("Home/pdc");
    }

    public function signUpPage()
    {
        $this->render("Home/signUpPage");
    }
}
