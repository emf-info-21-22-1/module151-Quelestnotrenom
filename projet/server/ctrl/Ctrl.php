<?php

class Ctrl
{

    private $wrk;
    private $sessionMan;

    public function __construct($sessionMan)
    {
        $this->wrk = new Wrk();
        $this->sessionMan = $sessionMan;
    }

    public function getChampion()
    {
        $result = "<champions>";
        $ret = $this->wrk->getChampions();
        foreach ($ret as $champ) {
            $result = $result . $champ->toXML();
        }
        return $result . "</champions>";

    }




    #register
    public function registerUser($user)
    {
        // commence par hasher le mot de passe de l'utilisateur
        $passwordhash = password_hash($user->getPassword(), CRYPT_SHA256);
        //elle appelle une autre fonction 
        $res = $this->wrk->registerUser($user->getUsername(), $passwordhash);
        if ($res) {
            //Si l'enregistrement réussit, elle retourne une chaîne XML <result>true</result>
            $value = "<result>true</result>";
        } else {
            // Si l'enregistrement échoue, elle définit le code de réponse HTTP à 401 (non autorisé) et retourne <result>false</result>.
            http_response_code(401);
            $value = "<result>false</result>";
        }
        return $value;
    }
    #login
    //return true / false
    public function checkLogin($username, $password)
    {
        //Cette fonction commence par vérifier si les champs username et password ne sont pas vides
        if (!empty($username) && !empty($password)) {
            $user = new Users($username, $password);
            $result = $this->wrk->checkLogin($user);
            if ($result) {
                http_response_code(200);
                $this->sessionMan->set('nom', $username);

            } else {
                http_response_code(401);
            }
        } else {
            //si vide 
            http_response_code(400);
        }

    }/*
    public function createChamp($nom, $mana, $image, $description, $type, $user, $region, $role)
    {
        if ($this->sessionMan->has("nom"))
            $champ = new Champions($nom, $mana, $image, $description, $type, $user, $region, $role);




        //$result = $this->wrk->insertChampion($champ);


        http_response_code(401);

    }*/
}





