<?php

class Type
{
    private $nom;

    public function __construct($nom)
    {
        $this->nom = $nom;
    }
    public function toXML()
    {
        return "<type><nom>$this->nom</nom></type>";
    }

}