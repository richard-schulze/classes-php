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
    echo "Votre connexion à la base de donnée est bonne<br>";
    }catch(PDOException $e){
        echo "Echec : " .$e->getMessage();
        exit;
    
}
    
}

// inscription en base de donnée
public function register($login,$password,$email,$firstname,$lastname){
    // $_SESSION['login'] = $login;
    $nouvelUser = $this->bdd->prepare("INSERT INTO utilisateurs(login,password,email,firstname,lastname)VALUE(?,?,?,?,?)");
    $nouvelUser->execute([$login,$password,$email,$firstname,$lastname]);
    $_SESSION['login'] = $login;
    $donneesUser = $this->bdd->prepare("SELECT * FROM utilisateurs WHERE login= ?");
    $donneesUser->execute([$_SESSION['login']]);
    $result = $donneesUser->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Nouvel utilisateur enregistré en Base de donnée<br>";
    return $result;
}

public function connect($login, $password){
    $donneesUser = $this->bdd->prepare("SELECT login, password FROM utilisateurs WHERE login = ? AND password = ?");
    $donneesUser->execute([$login,$password]);

    if($donneesUser->rowCount()>0){
        $_SESSION['login'] = $login;
        $_SESSION['password'] = $password;
        echo 'Bienvenue dans votre connexion : '.$login;
    }else{
        echo "Login ou Password inconnu dans notre base de donnée";
    }
}

public function disconnect(){
    session_destroy();
    echo "Vous avez été déconnecté";
}
public function delete(){
    
    $deleteUser = $this->bdd->prepare("DELETE FROM utilisateurs WHERE login = ?");
    $deleteUser->execute([$_SESSION['login']]);
    session_destroy();
    echo "L'utilisateur a été supprimé de la base de donnée ";
    
}
public function update($login,$password,$email,$firstname,$lastname){
    $updateUser = $this->bdd->prepare("UPDATE utilisateurs SET login =?, password =?, email =?, firstname =?, lastname =? WHERE login =?");
    $updateUser->execute([$login,$password,$email,$firstname,$lastname,$_SESSION['login']]);
    if(isset($_SESSION['login'])){

        echo "Les modifications demandées ont bien été enregistrées";
    }else{
        echo "Aucun utilisateur connecté pour modifier les renseignements";
    }
}

public function isConnect(){
    if(isset($_SESSION['login'])){
        echo "utilisateur isConnect";
        return true;
    }else{
        echo "utlisateur noConnect";
        return false;
    }
}


}
/* section de test*/

//création d'un nouvel utilisateur
$user = new Userpdo();

// Test pour l'inscription
//$user->register("ric", "ric","ric","ric","ric");
//var_dump($_SESSION['login']);

//Test pour la connection
//$user->connect("ric","ric");

//test pour la deconnection
//$user->disconnect();

//Test pour supprimer l'utilisateur
//$user->delete();

//Test pour update utilisateur
//$user->update("test1","test1","test1","test1","test1");

//Test pour isConnect
$user->isConnect();