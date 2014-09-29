<?php
namespace Modele ;
require_once './Framework/autoload.php';

/**
* classe héritée de la classe abstraite Modèle dont le rôle est la gestion des accès à la base de données des Billets
*/

class ManagerBillet extends \Framework\Manager
{
    /**
    * méthode renvoyant la liste de l'ensemble des billets de la BDD
    *
    * @return PDOStatement la liste des billets
    */
    public function getBillets()
    {
        //requête avec classement des billets dans l'ordre décroissant 
        $sql = 'select BIL_ID as id, BIL_DATE as date,'
                . ' BIL_AUTEUR as auteur, BIL_TITRE as titre, BIL_CONTENU as contenu from T_BILLET'
                . ' order by BIL_ID desc';
        
        // instanciation d'objets "Modele\Billet" dont les attributs publics prennent pour valeur les donn�es de la BDD
        $requete = $this->executerRequete($sql,NULL,'\Modele\Billet');
        
        //la requ�te retourne un tableau contenant toutes les lignes du jeu d'enregistrements , les colonnes sont li�s aux attributs de la
        //la classe
        $billets = $requete->fetchAll();
        
        foreach ($billets as $billet)
        {
        		$billet->setDate(new \DateTime($billet->date()));
        		$billet->setDateModif(new \DateTime($billet->dateModif()));
        }
        
        //permettre � la requ�te d'�tre de nouveau ex�cut�e
        $requete->closeCursor();
        return $billets;
    }
    
    /**
    * méthode renvoyant l'ensemble des informations sur le billet sélectionné
    *
    * @param int $idBillet identifiant du billet
    * @return array le billet sélectionné
    * @throws Exception si l'identifiant du billet est inconnu
    */
    public function getBillet($idBillet)
    {      
        $sql = 'select BIL_ID as id, BIL_DATE as date,'
                . ' BIL_AUTEUR as auteur, BIL_TITRE as titre, BIL_CONTENU as contenu from T_BILLET'
                . ' where BIL_ID=?';
  		
  		// instanciation d'objet "Modele\Billet" dont les attributs publics prennent pour valeur les donn�es de la BDD
        $requete =$this->executerRequete($sql, array($idBillet),'Modele\Billet');
        
        
        //si un billet correspond (row_count() retourne le nombre de lignes affectées par la dernière requête) , renvoyer ses informations 
        //(fetch() renvoie la première ligne d'une requête )
        
        if ($requete->rowcount()==1)
        {
        	$billet = $requete->fetch();
        	$billet->setDate(new \DateTime($billet->date()));
        	$billet->setDateModif(new \DateTime($billet->dateModif()));
        	return $billet;
        }
        else
        {
            throw new \Exception("Aucun billet ne correspond à l'identifiant '$idBillet'");
        }
    }
}
    
    