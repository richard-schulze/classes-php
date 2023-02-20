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

 }
 // creation de la fonction d'inscription (enregistrement)
 public function register($login,$password,$email,$firstname,$lastname){
    // je crée ma requete pour l'insérer dans ma table utilisateurs de ma db
    $requete = "INSERT INTO utilisateurs (login, password, email, firstname, lastname) VALUES ('$login','$password','$email','$firstname','$lastname')";
    $this->bdd->query($requete);
    return "Votre inscription s'est correctement déroulée";
 }
 

}

