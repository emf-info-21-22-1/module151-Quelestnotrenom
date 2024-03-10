<?php
header('Access-Control-Allow-Origin: http://localhost:8080');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Content-Type');
require_once("beans/Champions.php");
require_once("beans/Region.php");
require_once("beans/Type.php");
require_once("beans/Users.php");
require_once("ctrl/Ctrl.php");
require_once("wrk/Wrk.php");
require_once("wrk/Connexion.php");
require_once("wrk/SessionManager.php");
$sessionMan = new SessionManager();

$Ctrl = new Ctrl($sessionMan);

// Suppression de cette ligne car elle semble redondante avec la suite du code


if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (isset($_GET['action'])) {
        if ($_GET['action'] == "champion") {
            echo $Ctrl->getChampion();
        }        
        
    }
}
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['action'])) {
        
        if ($_POST['action'] == "register") {

            echo $Ctrl->registerUser(new Users($_POST['username'], $_POST['password']));
        } 
        if ($_POST['action'] == "checkLogin") {
            $username = $_POST['username'];
            $password = $_POST['password'];
            echo $Ctrl->checkLogin($username, $password);
         
     
        }
        if($_POST['action'] == "login"){


        }
        if($_POST['action'] == "deconnexion"){
         
            $sessionMan->clear();
            echo "<result>true</result>";
        }
        if ($_POST['action'] == "createChamp") {
        echo $Ctrl->createChamp($_POST['nom'], $_POST['mana'], $_POST['image'], $_POST['description'], $_POST['type'], $_POST['user'], $_POST['region'], $_POST['role']);
        }
        
    }
}
$Ctrl = null;