<?php


class Wrk
{
    private $con;

    /**
     * The Wrk Constructor that get an instance of the databse
     */
    public function __construct()
    {
        $this->con = Connexion::getInstance();
    }


    public function getChampions()
    {
      try {
        
        $result = $this->con->selectQuery('SELECT * FROM t_champion', null);

        $list = array();
        foreach ($result as $var) {
          $type = $this->con->selectSingleQuery("SELECT nom FROM t_type where PK_Type= ?;", array($var['FK_Type'])); 
          $role = $this->con->selectQuery("SELECT table_role.nom FROM t_role as table_role inner join tr_champion_role on PFK_Role = PK_Role inner join t_champion on PK_Champion = PFK_Champion where PK_Champion= ?;", array($var['PK_Champion']));
          $mana = ($var['mana'] == 0) ? "non" : "oui";
          $champ = new Champions($var['nom'], $mana, $var['image'], $var['description'], $type['nom'], $var['FK_User'], $var['FK_Region'], $role);

            if (isset($var['FK_User'])) {
                $user = $this->getUserByPK($var['FK_User']);
                $champ->setUser($user);
                
            }
            
            
           
          
            $champ->setRegion($this->getRegionById($var['FK_Region']));
            $list[] = $champ;
        }
        return $list;
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage() . "<br/>";
        die();
    }
    }
    public function getRegionById($pk)
    {
        try {
            $resulat = $this->con->selectSingleQuery("SELECT * FROM t_region where PK_Region = :region", ["region" => $pk]);
            return $resulat['nom'];
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br/>";
            die;
        }


    }


    public function getUserByPK($pk)
    {
        
            $resulat = $this->con->selectSingleQuery("SELECT * FROM t_user where PK_User = :user", ["user" => $pk]);
            return $resulat['username'];
       
    }

    public function registerUser($username, $password)
    {
        //vérifier si le nom d'utilisateur existe déjà dans la base de données 
        try {
            $doubloon = $this->getUserPK($username);
            //Si un utilisateur existant est trouvé (signifié par un retour différent de 0)
            if ($doubloon != 0) {
                return NULL;
            } else {
                //insert un nouvel utilisateur ( prévenir les injections SQL )
                return $this->con->executeQuery("INSERT INTO t_user (`username`, `password`) values (:user, :pwd)", ["user" => htmlspecialchars($username), "pwd" => $password]);
            }

        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br/>";
            die;
        }
    }

    

    public function getUserPK($username)
    {
        try {
            $res = $this->con->selectSingleQuery("SELECT * FROM t_user where `username` = :user", ["user" => $username]);
            if ($res) {
                return $res["PK_users"];
            } else {
                return 0;
            }
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br/>";
            die;
        }
    }


    public function insertChampion($champ)
    {
        
        $this->con->startTransaction();
            $res = $this->con->executeQuery("INSERT INTO t_champion (`nom`, `mana`, `image`, `description`, `FK_Type`, `FK_User`, `FK_region`, 'role') VALUES (?, ?, ?, ?, ?, ?, ?, ?);", array($champ->getNom(), $champ->getMana(), $champ->getImage(), $champ->getDescription(), $champ->getType(), $champ->getUser(), $champ->getRegion(), $champ->getRole()));
            
    
}
#_____________wrkLogin____________


public function checkLogin($user)
    {
        //sélectionne un utilisateur dans la base de données où le username correspond à celui fourni.
        $requete = "SELECT * FROM `t_user` WHERE username = ?";
        //Si un utilisateur correspondant est trouvé, le résultat est stocké dans $result
        $result = $this->con->selectSingleQuery($requete, [$user->getUsername()]);
        if ($result) {
            //Si un utilisateur est trouvé, la fonction vérifie que le mot de passe fourni correspond au mot de passe (hashé) 
            if (password_verify($user->getPassword(), $result['password'])) {
                return true;
            } else {
                return false;
            }
        } else {
            //Utilisateur innexistant
            return false;
 
 
        }
 
    }
}