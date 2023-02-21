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
    $_SESSION['login'] = $login;
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

 public function disconnect(){
    // on deconnecte l'utilisateur 
    session_unset();
    session_destroy();
    return "Vous êtes bien déconnecté de la base de données";
 }
 public function delete(){
    $suprutil = "DELETE FROM `utilisateurs` WHERE `utilisateurs`.`id` = '$this->id'";
    $this->bdd->query($suprutil);
    return "La suppression de l'utilisateur: $this->login a bien été effectuée ";
 }

 public function update($login,$password,$email,$firstname,$lastname){
    $updateuser = $this->bdd->query("UPDATE utilisateurs SET login = '$login', password =  '$password', email = '$email', firstname = '$firstname', lastname = '$lastname' WHERE login = '".$_SESSION['login']."' ");
    return "<br>".'Les modifications ont été enregistrés'."<br>";
    

 }
 public function isConnected(){
    if(isset($_SESSION['login'])){
        echo "vous êtes connecté";
    }else{
        echo "Vous n'êtes pas connecté";
    }
 }

 public function getAllInfos(){
    // on va afficher nos éléments dans un tableau
    ?>
    <h1 style="text-align:center;">Affichage de la fonction getAllInfos</h1>
    <div style="display:flex;justify-content:center; margin-top:10%;">
     
    <table style="text-align:center;" border="2">
    <thead >
        <tr >
            <th>login</th>
            <th>password</th>
            <th>email</th>
            <th>firstname</th>
            <th>lastname</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?= $this->login;?></td>
            <td><?= $this->password;?></td>
            <td><?= $this->email;?></td>
            <td><?= $this->firstname;?></td>
            <td><?= $this->lastname;?></td>
        </tr>
    </tbody>
    </table>
    </div>


<?php
 }

 public function getLogin(){
    return $this->login;
 }
 

}

// Créer un nouvel utilisateur
$user = new User();

// // Enregistrement dans la base de donnée
//echo $user->register("ric", "ric", "ric", "ric", "ric")."<br>";
//var_dump($_SESSION);

// connexion
//echo $user->connect("ric","ric");
//var_dump($_SESSION);

//deconnexion
//echo $user->disconnect();

// suppression de l'utilisateur qui est connecté
//echo $user->delete();

//mise à jour des informations d'utilisateur qui est connecté
//echo $user->update('test3','test3','test3','test3','test3');
//var_dump($user);

// isConnected ou non
//echo $user->isConnected();

//affichage des informations de l'utilisateur dans un tableau
//echo $user->getAllInfos();

//affichage du login de l'utilisateur
echo "Votre login est :".$user->getLogin();