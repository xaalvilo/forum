<?php
namespace Framework\Modeles ;
require_once './Framework/autoload.php';
/**
 *
 * @author Frédéric Tarreau
 *
 * 21 oct. 2014 - ManagerArticle.class.php
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
    * méthode renvoyant la liste des Articles de la BDD regroupés par $nombre
    *
    * @param int $curseur ligne à partir de laquelle sont récupérés les résultats
    * @param int $nombre nombre d'article récupéré
    * @return PDOStatement la liste des articles
    */
    public function getArticles($curseur,$nombre,$libelle=NULL)
    {
        // requête avec classement des articles dans l'ordre décroissant des dates
        $sql = 'select ART_ID as id, ART_TITRE as titre, ART_LIBELLE as libelle, ART_DATE as date,'
                . ' ART_DATE_MODIF as dateModif,  ART_CONTENU as contenu, ART_IMAGE as image,'
                . ' ART_NBCOMENTS as nbComents from T_ARTICLE';

        if(!empty($libelle))
            $sql.= ' where ART_LIBELLE=?';

        $sql.= ' order by ART_DATE desc LIMIT '.$curseur.','.$nombre.'';

        // instanciation d'objets "Modele\Article" dont les attributs prennent pour valeur les donn�es de la BDD
        $requete = $this->executerRequete($sql,array($libelle),'\Framework\Entites\Article');

        // la requ�te retourne un tableau contenant toutes les lignes du jeu d'Inscriptions , les colonnes sont li�s aux attributs de la
        // la classe
        $articles = $requete->fetchAll();

        // spécification de la langue utilisée pour l'affichage de la date et heure
        // en utilisant un trait
        $this->setHeureDateLocale();

        // conversion  du format BBD Mysql en format Php
        foreach ($articles as $article)
        {
                // il faut transformer l'attribut Date et DateModif en objet DateTime
        		$article->setDate(new \DateTime($article->date()));
        		$article->setDateModif(new \DateTime($article->dateModif()));
        }

        //permettre � la requ�te d'être de nouveau exécutée
        $requete->closeCursor();
        return $articles;
    }

    /**
     *
     * Méthode getNombreArticles
     *
     * return_type
     * @param string libelle éventuellement choisi
     * @return int nombre d'articles dans la BDD
     */
    public function getNombreArticles($choixLibelle=NULL)
    {
        //requête avec classement des articles dans l'ordre décroissant des dates
        $sql = 'select count(*) from T_ARTICLE';

        if(!empty($choixLibelle))
            $sql.=' where ART_LIBELLE=?';

        // instanciation d'objets "Modele\Article" dont les attributs prennent pour valeur les donn�es de la BDD
        $requeteSQL = $this->executerRequete($sql,array($choixLibelle),'\Framework\Entites\Article');

        $count = $requeteSQL->fetchcolumn();
        return $count;
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
        $sql = 'select ART_ID as id, ART_TITRE as titre, ART_LIBELLE as libelle, ART_DATE as date,'
                . ' ART_DATE_MODIF as dateModif, ART_CONTENU as contenu, ART_IMAGE as image, ART_NBCOMENTS as nbComents from T_ARTICLE'
                . ' where ART_ID=?';

  		// instanciation d'objet "Modele\Article" dont les attributs prennent pour valeur les donn�es de la BDD de cet article
        $requete =$this->executerRequete($sql,array($idArticle),'\Framework\Entites\Article');


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
     * Méthode getDernierArticle
     *
     * méthode renvoyant l'article le plus récent
     *
     * @return array l'Article le plus récent
     * @throws Exception si aucun article n'est trouvé"
     */
    public function getDernierArticle()
    {
        // requête de classement des articles par date, dans l'ordre décroissant avec filtre sur le premier, donc le plus récent
        $sql = 'select ART_ID as id, ART_TITRE as titre, ART_LIBELLE as libelle, ART_DATE as date,'
                . ' ART_DATE_MODIF as dateModif, ART_CONTENU as contenu, ART_IMAGE as image, ART_NBCOMENTS as nbComents'
                . ' from T_ARTICLE order by ART_DATE desc limit 0,1';

      	// instanciation d'objet "Modele\Article" dont les attributs prennent pour valeur les donn�es de la BDD de cet article
        $requete =$this->executerRequete($sql,NULL,'\Framework\Entites\Article');

        // spécification de la langue utilisée pour l'affichage de la date et heure
        // grâce au trait Affichage utilisé par la classe mère
    	$this->setHeureDateLocale();

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
            throw new \Exception("Aucun article dans la base");
        }
    }

    /**
     *
     * Méthode ajouterArticle
     *
     * Cette méthode insère un nouveau Article en BDD
     *
     * @param string $titre
     * @param string $libelle
     * @param string $image
     * @param string $contenu
     */
    public function ajouterArticle($titre,$libelle,$contenu,$image,$nbComents)
    {
        //requ�te avec insertion de l'article
        $sql = 'insert into T_ARTICLE( ART_TITRE, ART_LIBELLE, ART_DATE, ART_CONTENU, ART_IMAGE, ART_NBCOMENTS)'
                . ' values(?, ?, ?, ?, ?, ?)';

        // utilisation de la classe DateTime pour faire correspondre le format Php avec le format DateTime de MySql, time courant de la machine
        $odate = new \DateTime();

        // il faut formater la date en cha�ne de caract�re
        $date = $odate->format('Y-m-d H:i:s');

        $this->executerRequete($sql,array($titre,$libelle,$date,$contenu,$image,$nbComents),'\FrameWork\Entites\Article');
    }

    /**
     *
     * Méthode getLibelles
     *
     * Cette méthode recupere l'ensemble des libelles de la BDD
     * @return array tableau des libelles
     */
    public function getLibelles()
    {
        //requête sur les libellés avec suppression des doublons
        $sql = 'select distinct ART_LIBELLE as libelle from T_ARTICLE';

        $requeteSQL = $this->executerRequete($sql,NULL,'\FrameWork\Entites\Article');

        // modification du type de récupération des données de la BDD, ici sous forme de tableau
        $tableauResultat = $requeteSQL->fetchAll(\PDO::FETCH_COLUMN);

        //permettre � la requ�te d'être de nouveau exécutée
        $requeteSQL->closeCursor();
        return $tableauResultat;
    }

    /**
     *
     * Méthode actualiserNbComents
     *
     * permet d'actualiser le nbre de commentaires associés à l'article
     *
     * @param int $idArticle
     * @param int $modif
     */
    public function actualiserNbComents($idArticle,$modif)
    {
        // préparation de la requête SQL UPDATE
        $sql = 'update T_ARTICLE set ART_NBCOMENTS=ART_NBCOMENTS + '.$modif.' where ART_ID=?';

        $resultat = $this->executerRequete($sql,array($idArticle),'Framework\Entites\Article');

        if ($resultat===FALSE)
        {
            //TODO msg Flash non OK
            throw new \Exception("Données de l'article '$idArticle' non mises à jour");
        }
    }
}


