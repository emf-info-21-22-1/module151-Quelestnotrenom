<?php

class Ctrl
{

    private $wrk;

    public function __construct()
    {
        $this->wrk = new Wrk();
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
    public function login($username, $password)
    {
        $passwordhash = password_hash($password, CRYPT_SHA256);
        $res = $this->wrk->checkLogin($username);
        echo password_verify($password, $res["password"]);
        if (password_verify($password, $res["password"])) {
            $_SESSION['nom'] = $username;
            $_SESSION['id'] = $res['PK_User'];
            http_response_code(200);
            
        }else{
            http_response_code(401);
        }

    }
    public function createChampion($name, $image, $description, $mana, $type, $roles, $region){
        if (isset($_SESSION['nom']) && isset($_SESSION['id'])) {
            $champion = new Champions(htmlspecialchars($name), $mana ,htmlspecialchars($image), htmlspecialchars($description) , $type, null, $region, $roles);
            $champion->setUser($_SESSION['id']);
            $result = $this->wrk->insertChampion($champion);
            if ($result) {
                http_response_code(200);
            } else {
                http_response_code(500);
            }
        } else {
            http_response_code(401);
        }
    }
    /*
  public function createChamp($nom, $mana, $image, $description, $type, $user, $region, $role)
  {
      if ($this->sessionMan->has("nom"))
          $champ = new Champions($nom, $mana, $image, $description, $type, $user, $region, $role);




      //$result = $this->wrk->insertChampion($champ);


      http_response_code(401);

  }*/
}





