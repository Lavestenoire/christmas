<?php

namespace App\Model;


// On spécifie l'emplacement de la classe DbConnect à l'aide de la déclaration use pour permettre à PHP de localiser la classe DbConnect et de l'utiliser dans le code de UserModel. 
use App\Core\DbConnect;
use App\Entities\User;

class UserModel extends DbConnect
{
}
