<?php
include_once('Ctrl/EquipeCtrl.php');
include_once('Ctrl/JoueurCtrl.php');


switch ($_GET['action']) {
    case 'equipe':
        $equipes = new EquipeCtrl();
        echo $equipes->getEquipesXML();
        break;
    case 'joueur':
        $joueurs = new JoueurCtrl();
        echo $joueurs->getJoueursXML($_GET['equipeId']);
        break;
}
?>