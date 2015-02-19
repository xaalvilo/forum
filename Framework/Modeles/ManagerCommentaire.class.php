<?php
namespace Framework\Modeles;
require_once './Framework/autoload.php';
/**
 *
 * @author Fr�d�ric Tarreau
 *
 * 7 sept. 2014 - ManagerCommentaire.class.php
 *
 * classe h�rit�e de la classe abstraite Mod�le dont le r�le est la gestion des acc�s aux donn�es Commentaires
 */
class ManagerCommentaire extends \Framework\Manager
{
    /* constantes de différenciation entre la table des commentaires de billet et la table de commentaires
    * d'article
    */
    const TABLE_COMMENTAIRES_BILLET = 1;
    const TABLE_COMMENTAIRES_ARTICLE = 2;

    /**
    *
    * Méthode getListeCommentaires
    *
    * méthode renvoyant la liste de l'ensemble des commentaires d'un Billet ou d'un article
    *
    * @param int $table identifiant de la table concernée dans la BDD
    * @param int $idReference identifiant du billet ou de l'article
    *
    * @return PDOStatement la liste des commentaires
    */
    public function getListeCommentaires($table,$idReference)
    {
        //requête avec classement des commentaires dans l'ordre décroissant
        switch ($table)
        {
            // commentaire d'un billet
            case 1 :
                    $sql = 'select COM_ID as id, COM_DATE as date,'
                    . ' COM_AUTEUR as auteur, COM_CONTENU as contenu from T_COMMENTAIRE'
                    . ' where BIL_ID=?';
                    break;

            // commentaire d'un article
            case 2 :
                    $sql = 'select COM_ART_ID as id, COM_ART_DATE as date,'
                    . ' COM_ART_AUTEUR as auteur, COM_ART_CONTENU as contenu from T_COMMENTAIRE_ARTICLE'
                    . ' where ART_ID=?';
                    break;

            // message d'erreur
            default:
                throw new \Exception ("mauvaise selection de la table");
        }

        //instanciation d'objets "Modele\Commentaire" dont les attributs publics prennent pour valeur les donn�es de la BDD
        $requete = $this->executerRequete($sql,array($idReference),'\Framework\Entites\Commentaire');

        //la requ�te retourne un tableau contenant toutes les lignes du jeu d'Inscriptions, les colonnes sont li�s aux attributs de la
        //la classe
        $commentaires = $requete->fetchAll();

        // spécification de la langue utilisée pour l'affichage de la date et heure
        // grâce au trait Affichage utilisé par la classe mère
    	$this->setHeureDateLocale();

        foreach ($commentaires as $commentaire)
        {
            // il faut transformer l'attribut Date en objet DateTime
            $commentaire->setDate(new \DateTime($commentaire->date()));
        }

        //permettre � la requ�te d'�tre de nouveau ex�cut�e
        $requete->closeCursor();
        return $commentaires;
    }

    /**
     *
     * Méthode getCommentaire
     *
     * méthode renvoyant la liste de l'ensemble des commentaires d'un Billet ou d'un article
     *
     * @param int $table identifiant de la table concernée dans la BDD
     * @param int $idReference identifiant du commentaire de billet ou d'article
     * @return PDOStatement le commentaire sous forme de tableau
     * @throws \Exception en cas d'erreur
     */
    public function getCommentaire($table,$idReference)
    {
    	switch ($table)
    	{
    		// commentaire d'un billet
    		case 1 :
    		$sql = 'select BIL_ID as idParent, COM_CONTENU as contenu from T_COMMENTAIRE'
    		. ' where COM_ID=?';
                    break;

            // commentaire d'un article
            case 2 :
    		$sql = 'select ART_ID as idParent, COM_ART_CONTENU as contenu from T_COMMENTAIRE_ARTICLE'
    		. ' where COM_ART_ID=?';
                    break;

            // message d'erreur
            default:
                throw new \Exception ("mauvaise selection de la table");
    	}

    	//instanciation d'objets "Modele\Commentaire" dont les attributs publics prennent pour valeur les donn�es de la BDD
    	$resultat = $this->executerRequete($sql,array($idReference),'\Framework\Entites\Commentaire');

    	if ($resultat->rowcount()==1)
    	{
    		// récupération sous forme de tableau
    		$commentaire = $resultat->fetch(\PDO::FETCH_ASSOC);

    		// liberer la connexion
    		$resultat->closeCursor();

    		return $commentaire;
    	}
    	else
    	{
    		throw new \Exception("Aucun commentaire ne correspond à l'identifiant '$idReference'");
    	}
    }

    /**
    *
    * Méthode ajouterCommentaire
    *
    * Méthode permettant d'ajouter un commentaire
    *
    * @param int $table identifiant de la table concernée dans la BDD
    * @param string $auteur nom de l'auteur
    * @param int $idBillet identifiant du Billet
    * @param string $contenu texte du commentaire
    */
    public function ajouterCommentaire($table,$idReference, $auteur, $contenu)
    {
       //requ�te avec insertion du commentaire
        switch ($table)
        {
            // commentaire d'un billet
            case 1 :
                    $sql = 'insert into T_COMMENTAIRE(BIL_ID, COM_DATE, COM_AUTEUR, COM_CONTENU)'
                    . ' values(?, ?, ?, ?)';
                     break;

            // commentaire d'un article
            case 2 :
                    $sql = 'insert into T_COMMENTAIRE_ARTICLE(ART_ID, COM_ART_DATE, COM_ART_AUTEUR, COM_ART_CONTENU)'
                    . ' values(?, ?, ?, ?)';
                    break;

            // message d'erreur
            default:
                throw new \Exception ("mauvaise selection de la table");
        }

        // utilisation de la classe DateTime pour faire correspondre le format Php avec le format DateTime de MySql, time courant de la machine
        $odate = new \DateTime();

        // il faut formater la date en cha�ne de caract�re
        $date = $odate->format('Y-m-d H:i:s');

        $requeteSQL = $this->executerRequete($sql,array($idReference,$date,$auteur,$contenu),'\Framework\Entites\Commentaire');
    }

    /**
     * Méthode supprimerCommentaire
     *
     * cette méthode permet de supprimer un commentaire
     *
     * @param int $table identifiant de la table concernée en BDD
     * @param int $idCommentaire
     */
    public function supprimerCommentaire($table, $idCommentaire)
    {
    	switch ($table)
    	{
    		// commentaire d'un billet
    		case 1 :
    			$sql = 'delete from T_COMMENTAIRE where COM_ID = ?';
    							break;

    		// commentaire d'un article
    		case 2 :
    			$sql = 'delete from T_COMMENTAIRE_ARTICLE where COM_ART_ID = ?';
    							break;

    		// message d'erreur
    		default:
    			throw new \Exception ("mauvaise selection de la table");
    	}

        $requeteSQL = $this->executerRequete($sql, array($idCommentaire),'\Framework\Entites\Commentaire');

        return ($requeteSQL->rowcount()==1);
    }

    /**
     *
     * Méthode actualiserCommentaire
     *
     * cette méthode permet d'actualiser le contenu et la date d'un commentaire
     *
     * @param int $table
     * @param int $idCommentaire
     * @param array $donnees à actualiser
     */
    public function actualiserCommentaire ($table, $idCommentaire, $donnees)
    {
        if(array_key_exists('date', $donnees))
        {
            $donnees['date']= $donnees['date']->format('Y-m-d H:i:s');
        }

        if(array_key_exists('dateModif', $donnees))
        {
            $donnees['dateModif']= $donnees['dateModif']->format('Y-m-d H:i:s');
        }

        // création de la chaîne de caractère pour la requête SQL
        // retirer au préalable l'identifiant qui n'est jamais actualisé
        unset ($donnees['id']);
        $nbreModifications=count($donnees);
        $modification ='';
        $i=0;

    	switch ($table)
    	{
    		// commentaire d'un billet
    		case 1 :
    		    foreach ($donnees as $attribut=>$valeur)
    		    {
    		        $i++;
    		        $modification.='COM_'.strtoupper($attribut).'=?';
    		        if ($i<$nbreModifications)
    		        {
    		            $modification.=', ';
    		        }
    		    }
    			$sql = 'update T_COMMENTAIRE set '.$modification.' where COM_ID=?';
    					break;

    		// commentaire d'un article
    		case 2 :
    		    foreach ($donnees as $attribut=>$valeur)
    		    {
    		        $i++;
    		        $modification.='COM_ART_'.strtoupper($attribut).'=?';
    		        if ($i<$nbreModifications)
    		        {
    		            $modification.=', ';
    		        }
    		    }
    			$sql = 'update T_COMMENTAIRE_ARTICLE set '.$modification.' where COM_ART_ID=?';
    					break;

    		// message d'erreur
    		default:
    			throw new \Exception ("mauvaise selection de la table");
    	}

    	// ajout de l'identifiant pour l'exécution de la requête
        $donnees['id']= $idCommentaire;

    	// transformation du tableau en tableau indexé
    	$donnees = array_values($donnees);

    	$resultat = $this->executerRequete($sql,$donnees,'\Framework\Entites\Commentaire');

    	if ($resultat===FALSE)
    	{
    		//TODO msg Flash non OK
    		throw new \Exception("Données du commentaire '$idCommentaire' non mises à jour");
    	}
    }


    /**
     * Méthode getIdParent
     *
     * cette méthode permet de récupérer l'id du billet ou de l'article auquel le commentaire en paramètre est associé
     *
     * @param int $table
     * @param int $idCommentaire
     * @throws \Exception en cas d'échec au choix de la table
     * @throws \Exception en cas d'échec de la requête SQL pour trouver l'identifiant
     * @return array $tableauRésultat, à une entrée comportant l'id du Parent
     */
    public function getIdParent($table, $idCommentaire)
    {
    	switch ($table)
    	{
    		// commentaire d'un billet
    		case 1 :
    			$sql = 'select BIL_ID as idParent from T_COMMENTAIRE where COM_ID = ?';
    			break;

    		// commentaire d'un article
    		case 2 :
    			$sql = 'select ART_ID as idParent from T_COMMENTAIRE_ARTICLE where COM_ART_ID = ?';
    			break;

    		// message d'erreur
    		default:
    			throw new \Exception ("mauvaise selection de la table");
    	}

    	$requeteSQL = $this->executerRequete($sql, array($idCommentaire),'\Framework\Entites\Commentaire');

    	if ($requeteSQL->rowcount()==1)
    	{
    		// modification du type de récupération des données de la BDD, ici sous forme de tableau
    		$tableauResultat = $requeteSQL->fetch(\PDO::FETCH_ASSOC);

    		// liberer la connexion
    		$requeteSQL->closeCursor();

    		return $tableauResultat;
    	}
    	else
    	{
    		throw new \Exception("Impossible d'obtenir l'identifiant du billet");
    	}
    }
}

