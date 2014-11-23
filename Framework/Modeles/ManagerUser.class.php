<?php
namespace Framework\Modeles ;
require_once './Framework/autoload.php';

/**
* classe héritée de la classe abstraite Modèle dont le rôle est la gestion des accès à la base de données des Users
*/

class ManagerUser extends \Framework\Manager
{
    /**
    *
    * Méthode getUsers
    * 
    * méthode renvoyant la liste de l'ensemble des Users de la BDD
    *
    * @return PDOStatement la liste des Users
    */
    public function getUsers()
    {
        //requête avec classement des Users dans l'ordre décroissant 
        $sql = 'select BIL_ID as id, BIL_DATE as date,'
                . ' BIL_AUTEUR as auteur, BIL_TITRE as titre, BIL_CONTENU as contenu from T_User'
                . ' order by BIL_ID desc';
        
        // instanciation d'objets "Modele\User" dont les attributs publics prennent pour valeur les donn�es de la BDD
        $requete = $this->executerRequete($sql,NULL,'\Framework\Entites\User');
        
        //la requ�te retourne un tableau contenant toutes les lignes du jeu d'enregistrements , les colonnes sont li�s aux attributs de la
        //la classe
        $Users = $requete->fetchAll();
        
        // spécification de la langue utilisée pour l'affichage de la date et heure
        // cela permet d'utliser la fonction strftime() au moment d'afficher l'heure
    	$this->setHeureDateLocale();
        
        foreach ($Users as $User)
        {
        		$User->setDate(new \DateTime($User->date()));
        		$User->setDateModif(new \DateTime($User->dateModif()));
        }
        
        //permettre � la requ�te d'�tre de nouveau ex�cut�e
        $requete->closeCursor();
        return $Users;
    }
    
    /**
    * 
    * Méthode getUser
    * 
    * méthode renvoyant l'ensemble des informations sur le User sélectionné
    *
    * @param int $idUser identifiant du User
    * @return array le User sélectionné
    * @throws Exception si l'identifiant du User est inconnu
    */
    public function getUser($idUser)
    {      
        $sql = 'select BIL_ID as id, BIL_DATE as date,'
                . ' BIL_AUTEUR as auteur, BIL_TITRE as titre, BIL_CONTENU as contenu from T_User'
                . ' where BIL_ID=?';
  		
  		// instanciation d'objet "Modele\User" dont les attributs publics prennent pour valeur les donn�es de la BDD
        $requete =$this->executerRequete($sql, array($idUser),'\Framework\Entites\User');
        
        
        //si un User correspond (row_count() retourne le nombre de lignes affectées par la dernière requête) , renvoyer ses informations 
        //(fetch() renvoie la première ligne d'une requête )
        
        if ($requete->rowcount()==1)
        {
            $User = $requete->fetch();
                                    
        	$User->setDate(new \DateTime($User->date()));
        	$User->setDateModif(new \DateTime($User->dateModif()));
        	return $User;
        }
        else
        {
            throw new \Exception("Aucun User ne correspond à l'identifiant '$idUser'");
        }
    }
    
    /**
     * 
     * Méthode ajouterUser
     *
     * Cette méthode insère un nouveau User en BDD
     * 
     * @param string $titre
     * @param string $auteur
     * @param string $contenu
     */
    public function ajouterUser($titre,$auteur,$contenu)
    {
        //requ�te avec insertion du commentaire
        $sql = 'insert into T_User(BIL_DATE, BIL_TITRE, BIL_AUTEUR, BIL_CONTENU)'
                . ' values(?, ?, ?, ?)';
        // utilisation de la classe DateTime pour faire correspondre le format Php avec le format DateTime de MySql, time courant de la machine
        $odate = new \DateTime();
    
        // il faut formater la date en cha�ne de caract�re
        $date = $odate->format('Y-m-d H:i:s');
    
        $this->executerRequete($sql,array($date,$titre,$auteur,$contenu),'\Framework\Entites\User');
    }
}

    
    