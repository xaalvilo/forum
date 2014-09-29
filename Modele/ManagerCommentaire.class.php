<?php
namespace Modele;
require_once './Framework/autoload.php';
/**
 * 
 * @author Fr�d�ric Tarreau
 *
 * 7 sept. 2014 - file_name
 * 
 * classe h�rit�e de la classe abstraite Mod�le dont le r�le est la gestion des acc�s aux donn�es Commentaires 
 */
class ManagerCommentaire extends \Framework\Manager
{
    /**
    * méthode renvoyant la liste de l'ensemble des commentaires d'un Billet 
    * 
    * @param int $idBillet identifiant du billet
    * @return PDOStatement la liste des commentaires
    */
    public function getListeCommentaires($idBillet)
    {
        //requête avec classement des commentaires dans l'ordre décroissant 
        $sql = 'select COM_ID as id, COM_DATE as date,'
                . ' COM_AUTEUR as auteur, COM_CONTENU as contenu from T_COMMENTAIRE'
                . ' where BIL_ID=?';
       
        //instanciation d'objets "Modele\Commentaire" dont les attributs publics prennent pour valeur les donn�es de la BDD
        $requete = $this->executerRequete($sql,array($idBillet),'\Modele\Commentaire');
        
        //la requ�te retourne un tableau contenant toutes les lignes du jeu d'enregistrements, les colonnes sont li�s aux attributs de la
        //la classe
        $commentaires = $requete->fetchAll();
        
        foreach ($commentaires as $commentaire)
        {
        	$commentaire->setDate(new \DateTime($commentaire->date()));
        }
        
        //permettre � la requ�te d'�tre de nouveau ex�cut�e
        $requete->closeCursor();
        return $commentaires;
    }
    
    /** 
    * m�thode permettant d'ajouter un commentaire
    *
    * @param  string $auteur nom de l'auteur
    * @param  int $idBillet identifiant du Billet
    * @param string $contenu texte du commentaire
    */
    public function ajouterCommentaire($idBillet, $auteur, $contenu)
    {
        //requ�te avec insertion du commentaire 
        $sql = 'insert into T_COMMENTAIRE(BIL_ID, COM_DATE, COM_AUTEUR, COM_CONTENU)'
            . ' values(?, ?, ?, ?)';
        // utilisation de la classe DateTime pour faire correspondre le format Php avec le format DateTime de MySql, time courant de la machine
        $odate = new \DateTime();
        // il faut formater la date en cha�ne de caract�re
        $date = $odate->format('Y-m-d H:i:s');
        
        $this->executerRequete($sql,array($idBillet,$date,$auteur,$contenu),'\Modele\Commentaire');
    }
}
    
    