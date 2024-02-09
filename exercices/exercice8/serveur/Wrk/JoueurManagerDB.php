<?php
require_once('Wrk/Connexion.php');
require_once('Beans/Joueur.php');
class JoueursDBManager{
  private $connexion;
  
  public function __construct(){
    
    $this->connexion = Connexion::getInstance();
  }
  
  public function getJoueurs($equipeId){
    
    $query = $this->connexion->selectQuery('select pk_joueur, nom, points from t_joueur where fk_equipe=' . $equipeId . ';', null);
    
    $result = array();
    foreach ($query as $row) {
      $joueur = new Joueur($row['pk_joueur'], $row['nom'], $row['points']);
      $result[] = $joueur;
    }
    
    return $result;
  }
}

?>