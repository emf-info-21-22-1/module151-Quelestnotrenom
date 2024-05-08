<?php
require_once('Wrk/EquipeManagerDB.php');
class EquipeCtrl{
  
  private $equieDBManager;  
  public function __construct(){
    $this->equieDBManager = new EquipesDBManager();
  } 
  public function getEquipesXML(){
    $equipes = $this->equieDBManager->getEquipes();
    $result = "<equipes>";
    foreach($equipes as $equipe){
      $result = $result . "<equipe>" . "<id>" 
	  . $equipe->getId() . "</id>" . "<nom>" 
	  . $equipe->getNom() . "</nom>" . "</equipe>";
    }
    $result = $result . "</equipes>";
    return $result;
  }
  

}

?>