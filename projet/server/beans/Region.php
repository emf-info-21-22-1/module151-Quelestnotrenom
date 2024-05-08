<?php


class Region
{
    private $nom;

    public function __construct($nom)
    {
        $this->nom = $nom;
    }
    public function toXML()
    {
        return "<region><nom>$this->nom</nom></region>";
    }

}