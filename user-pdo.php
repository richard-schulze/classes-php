<?php 
session_start();

class Userpdo {
    private $id;
    public $login;
    private $password;
    public $email;
    public $firstname;
    public $lastname;
    private $bdd;

    //création du constructeur
public function __construct(){
    // pour la connexion à la base de donnée
    $servername = 'localhost';
    $dbname = 'classes';
    $username = 'root';
    $password = '';

    // on essaie la connexion
    try{
        $this->bdd = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8",$username,$password);

    // gestion des erreurs de PDO sur Exception
    $this->bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Votre connexion à la base de donnée est bonne";
    }catch(PDOException $e){
        echo "Echec : " .$e->getMessage();
        exit;
    
}
    
}
// inscription en base de donnée
public function register($login,$password,$email,$firstname,$lastname){
    $nouvelUser = $this->bdd->prepare("INSERT INTO utilisateurs(login,password,email,firstname,lastname)VALUE(?,?,?,?,?)");
    $nouvelUser->execute([$login,$password,$email,$firstname,$lastname]);
    
    $donneesUser = $this->bdd->prepare("SELECT * FROM utilisateurs WHERE login= ?");
    $donneesUser->execute([$_SESSION['login']]);
    $result = $donneesUser->fetchAll(PDO::FETCH_ASSOC);
    return $result;
    
}

}
/* section de test*/

//création d'un nouvel utilisateur
$user = new Userpdo();

// Test pour l'inscription
$user->register("ric", "ric","ric","ric","ric");
//var_dump($_SESSION['login']);
