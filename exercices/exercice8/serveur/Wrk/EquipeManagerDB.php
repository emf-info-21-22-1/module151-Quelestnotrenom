<?php
require_once('Wrk/Connexion.php');
require_once('Beans/Equipe.php');
class EquipesDBManager{
  private $connexion;
  
  public function __construct(){
    $this->connexion = Connexion::getInstance();
  }
  
  public function getEquipes(){
   
    $query = $this->connexion->selectQuery("select pk_equipe, nom from t_equipe;", null);
    
    $result = array();
    foreach ($query as $row) {
      $equipe = new Equipe($row['pk_equipe'], $row['nom']);
      $result[] = $equipe;
    }
    
    return $result;
  }
}

?>