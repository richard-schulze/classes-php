<?php
session_start();

class User {
    private $id;
    public $login;
    public $password;
    public $email;
    public $firstname;
    public $lastname;
    public $bdd;

 //creation du constructeur
 public function __construct(){
    //on se connecte à la base de donnée
    $this->bdd = new mysqli('localhost', 'root', '', 'classes');

    // Vérification de la connexion
if (isset($_SESSION['user'])){
        $this->id = $_SESSION['user']['id'];
        $this->login = $_SESSION['user']['login'];
        $this->password = $_SESSION['user']['password'];
        $this->email = $_SESSION['user']['email'];
        $this->firstname = $_SESSION['user']['firstname'];
        $this->lastname = $_SESSION['user']['lastname'];
    }

 }
 // creation de la fonction d'inscription (enregistrement)
 public function register($login,$password,$email,$firstname,$lastname){
    // je crée ma requete pour l'insérer dans ma table utilisateurs de ma db
    $requete = "INSERT INTO utilisateurs (login, password, email, firstname, lastname) VALUES ('$login','$password','$email','$firstname','$lastname')";
    $this->bdd->query($requete);
    return "Votre inscription s'est correctement déroulée";
 }

 // creation d'une connexion 
 public function connect($login,$password){
    // on va verifier que le login et passwd sont presents
    if($login !== "" && $password !== ""){
        //on va verifier que l'utilisateur et le mot de passe sont valables
        $requete = "SELECT count(*) FROM utilisateurs WHERE login='".$login."'AND password = '".$password."' ";
        $excecute_requete = $this->bdd->query($requete);
        $resp = mysqli_fetch_array($excecute_requete);
        $count = $resp['count(*)'];

        // je verifie si le nom de l'utilisateur est bon 
        if($count!=0){
            $verif = "SELECT * FROM utilisateurs WHERE login = '".$login."' ";
            $excecute_verif = $this->bdd->query($verif);
            $respverif = mysqli_fetch_array($excecute_verif);
            //var_dump($respverif);

            $this->id = $respverif['id'];
            $this->login = $respverif['login'];
            $this->password = $respverif['password'];
            $this->email = $respverif['email'];
            $this->firstname = $respverif['firstname'];
            $this->lastname = $respverif['lastname'];

            $_SESSION['user'] = [
                'id' => $respverif['id'],
                'login' => $respverif['login'],
                'password'=>$respverif['password'],
                'email' => $respverif['email'],
                'firstname'=> $respverif['firstname'],
                'lastname'=>$respverif['lastname']
            ];
            echo "Votre connexion a réussie"."<br>";

        }else{
            return "Votre connexion a échouée: utilisateur inexistant";
        }
    }
 }
 

}

// Créer un nouvel utilisateur
$user = new User('bob', 'bob', 'bob', 'bob');

// // Enregistrement dans la base de donnée
echo $user->register("bob", "bob", "bob", "bob", "bob")."<br>";
//var_dump($_SESSION);

