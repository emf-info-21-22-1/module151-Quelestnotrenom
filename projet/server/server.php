<?php
// header('Access-Control-Allow-Origin: http://localhost:8080');
// header('Access-Control-Allow-Credentials: true');
// header('Access-Control-Allow-Headers: Content-Type');
require_once("beans/Champions.php");
require_once("beans/Region.php");
require_once("beans/Type.php");
require_once("beans/Users.php");
require_once("ctrl/Ctrl.php");
require_once("wrk/Wrk.php");
require_once("wrk/Connexion.php");
session_start();
$Ctrl = new Ctrl();

// Suppression de cette ligne car elle semble redondante avec la suite du code


if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (isset($_GET['action'])) {
        if ($_GET['action'] == "champion") {
            echo $Ctrl->getChampion();
        }else{
            phpinfo();
        }


    }
}
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['action'])) {

        if ($_POST['action'] == "register") {

            echo $Ctrl->registerUser(new Users($_POST['username'], $_POST['password']));
        }
        if ($_POST['action'] == "checkLogin") {
            
            if(isset($_SESSION['nom'])){
                                
            }else{
                http_response_code(401);
            }
            print_r($_SESSION);

        }
        if ($_POST['action'] == "login") {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $Ctrl->login($username, $password);

        }
        if ($_POST['action'] == "deconnexion") {
            session_destroy();
        }
        if ($_POST['action'] == "createChamp") {
            echo $Ctrl->createChamp($_POST['nom'], $_POST['mana'], $_POST['image'], $_POST['description'], $_POST['type'], $_POST['user'], $_POST['region'], $_POST['role']);
        }

    }
}
$Ctrl = null;