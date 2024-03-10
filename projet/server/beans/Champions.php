<?php

class Champions {
    private $nom;
    private $mana;
    private $image;
    private $description;
    private $type;
    private $user;
    private $region;
    private $role;
    
    public function __construct($nom, $mana, $image, $description, $type, $user, $region, $role) {
        $this->nom = $nom;
        $this->mana = $mana;
        $this->image = $image;
        $this->description = $description;
        $this->type = $type;
        $this->user = $user;
        $this->region = $region;
        $this->role = $role;
    }
    
    public function getNom() {
        return $this->nom;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function getMana() {
        return $this->mana;
    }

    public function setMana($mana) {
        $this->mana = $mana;
    }

    public function getImage() {
        return $this->image;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function getUser() {
        return $this->user;
    }

    public function setUser($user) {
        $this->user = $user;
    }

    public function getRegion() {
        return $this->region;
    }

    public function setRegion($region) {
        $this->region = $region;
    }
    public function getRole() {
      return $this->role;
  }

  public function setRole($role) {
      $this->role = $role;
  }
    public function toXML()
    {
        $list = "<champion>";
        $list .= "<nom>$this->nom</nom>";
        $list .= "<mana>$this->mana</mana><image>$this->image</image><description>$this->description</description><type>$this->type</type><user>$this->user</user><region>$this->region</region>";
        foreach($this->role as $data){
          $list .= "<roles>" . $data['nom'] . "</roles>";          
        }        
        return $list . "</champion>";
        }
       

    
}
