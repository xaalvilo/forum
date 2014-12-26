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
        	$commentaire->setDate(new \DateTime($commentaire->date()));
        }
        
        //permettre � la requ�te d'�tre de nouveau ex�cut�e
        $requete->closeCursor();
        return $commentaires;
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
        
        $this->executerRequete($sql,array($idReference,$date,$auteur,$contenu),'\Framework\Entites\Commentaire');
    }
}
    
    