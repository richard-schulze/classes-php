<?php 
session_start();

class Userpdo {
    private $id;
    public $login;
    private $password;
    public $email;
    public $firstname;
    public $lastname;
    public $bdd;

    //création du constructeur
public function __construct(){
    // pour la connexion à la base de donnée
    $servername = 'localhost';
    $dbname = 'classes';
    $db_username = 'root';
    $db_password = '';

    // on essaie la connexion
    try{
        $this->bdd = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8,$db_username,$db_password");

    // gestion des erreurs de PDO sur Exception
    $this->bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Votre connexion à la base de donnée est bonne";
    }
    catch(PDOException $e){
        echo "Echec de la connexion avec la base de donnée" .$e->getMessage();
        exit;
    }
    // On vérifie la connexion
    if (isset($_SESSION['user'])){
        $this->id = $_SESSION['user']['id'];
        $this->login = $_SESSION['user']['login'];
        $this->password = $_SESSION['user']['password'];
        $this->email = $_SESSION['user']['email'];
        $this->firstname = $_SESSION['user']['firstname'];
        $this->lastname = $_SESSION['user']['lastname'];
    }
}
}
