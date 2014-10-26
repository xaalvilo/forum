<?php
namespace Modele ;
require_once './Framework/autoload.php';

/**
 * 
 * @author Frédéric Tarreau
 *
 * 21 oct. 2014 - ManagerArticle.class.php
 * 
 * 
 *  classe héritée de la classe abstraite Manager dont le rôle est la gestion des accès à la base de données des Articles du Blog
 *
 */

class ManagerArticle extends \Framework\Manager
{
    /**
    *
    * Méthode getArticles
    * 
    * méthode renvoyant la liste de l'ensemble des Articles de la BDD
    *
    * @return PDOStatement la liste des articles
    */
    public function getArticles()
    {
        //requête avec classement des articles dans l'ordre décroissant 
        $sql = 'select ART_ID as id, ART_TITRE as titre, ART_DATE as date,'
                . ' ART_DATE_MODIF as dateModif,  ART_CONTENU as contenu, ART_IMAGE as image from T_ARTICLE'
                . ' order by ART_ID desc';
        
        // instanciation d'objets "Modele\Article" dont les attributs prennent pour valeur les donn�es de la BDD
        $requete = $this->executerRequete($sql,NULL,'\Modele\Article');
        
        //la requ�te retourne un tableau contenant toutes les lignes du jeu d'enregistrements , les colonnes sont li�s aux attributs de la
        //la classe
        $articles = $requete->fetchAll();
        
        // conversion  du format BBD Mysql en format Php
        foreach ($articles as $article)
        {
        		$article->setDate(new \DateTime($article->date()));
        		$article->setDateModif(new \DateTime($article->dateModif()));
        }
        
        //permettre � la requ�te d'être de nouveau exécutée
        $requete->closeCursor();
        return $articles;
    }
    
    /**
    * 
    * Méthode getArticle
    * 
    * méthode renvoyant l'ensemble des informations sur l'article sélectionné
    *
    * @param int $idArticle identifiant de l'article
    * @return array l'Article sélectionné
    * @throws Exception si l'identifiant de l'Article est inconnu
    */
    public function getArticle($idArticle)
    {      
        $sql = 'select ART_ID as id, ART_TITRE as titre, ART_DATE as date,'
                . ' ART_DATE_MODIF as dateModif, ART_CONTENU as contenu, ART_IMAGE as image from T_ARTICLE'
                . ' where ART_ID=?';
  		
  		// instanciation d'objet "Modele\Article" dont les attributs prennent pour valeur les donn�es de la BDD de cet article
        $requete =$this->executerRequete($sql,array($idArticle),'Modele\Article');
        
        
        //si un article correspond (row_count() retourne le nombre de lignes affectées par la dernière requête) , renvoyer ses informations 
        //(fetch() renvoie la première ligne d'une requête )
        
        if ($requete->rowcount()==1)
        {
        	$article = $requete->fetch();
        	
        	// conversion  du format BBD Mysql en format Php
        	$article->setDate(new \DateTime($article->date()));
        	$article->setDateModif(new \DateTime($article->dateModif()));
        	return $article;
        }
        else
        {
            throw new \Exception("Aucun article ne correspond à l'identifiant '$idArticle'");
        }
    }
    
    /**
     * 
     * Méthode ajouterArticle
     *
     * Cette méthode insère un nouveau Article en BDD
     * 
     * @param string $titre
     * @param string $image
     * @param string $contenu
     */
    public function ajouterArticle($titre,$contenu,$image)
    {
        //requ�te avec insertion de l'article
        $sql = 'insert into T_ARTICLE( ART_TITRE, ART_DATE, ART_CONTENU, ART_IMAGE)'
                . ' values(?, ?, ?, ?)';
        // utilisation de la classe DateTime pour faire correspondre le format Php avec le format DateTime de MySql, time courant de la machine
        $odate = new \DateTime();
    
        // il faut formater la date en cha�ne de caract�re
        $date = $odate->format('Y-m-d H:i:s');
    
        $this->executerRequete($sql,array($titre,$date,$contenu,$image),'\Modele\Article');
    }
}

    
    