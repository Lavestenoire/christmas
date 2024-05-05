<?php

namespace App\Core;
// use est différent de include: il permet de d'éviter d'avoir à écrire le nom complet de la classe ou de l'espace de noms chaque fois que l'on veut l'utiliser. cela permet ensuite de créer une instance de la classe
// include inclus le code d'un fichier dans le fichier courant (include header.php dans par exemple)
use PDO;
use Exception;

class DbConnect
{

    protected $connection;
    protected $request;

    const SERVER = "localhost";
    const USER = "root";
    const PASSWORD = "root";
    const BASE = "christmas";

    public function __construct()
    {
        try {
            $this->connection = new PDO("mysql:host=" . self::SERVER . ";dbname=" . self::BASE, self::USER, self::PASSWORD);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $this->connection->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES utf8");
        } catch (Exception $e) {
            die('erreur : ' . $e->getMessage());
        }
    }
}
