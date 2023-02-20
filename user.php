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


}