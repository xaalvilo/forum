<?php
namespace Framework\Modeles ;
require_once './Framework/autoload.php';

/**
 * 
 * @author Frédéric Tarreau
 *
 * 28 nov. 2014 - ManagerUser.class.php
 * 
 * Classe héritée de Manager permettant d'interagir avec la BBD des utilisateurs/clients
 *
 */
class ManagerUser extends \Framework\Manager
{
    /**
    *
    * Méthode getUsers
    * 
    * méthode renvoyant la liste de l'ensemble des users de la BDD
    *
    * @return PDOStatement la liste des Users
    */
    public function getUsers()
    {
        //requête avec classement des Users dans l'ordre décroissant 
        $sql = 'select USER_ID as id, USER_DATE_ENREG as dateEnregistrement,'
                . ' USER_STATUT as userStatut, USER_PSEUDO as userPseudo, USER_MAIL as userMail,'
                . ' USER_TELEPHONE as userTelephone, USER_AVATAR as userAvatar, USER_DATE_CONNEXION as dateConnexion,'
                . ' USER_NBRE_COMMENTAIRES_BLOG as nbreCommentairesBlog, USER_NBRE_COMMENTAIRES_FORUM as nbreCommentairesForum,'        
                . ' USER_NOM as userNom, USER_PRENOM as userPrenom, USER_naissance as userNaissance from T_User'
                . ' order by USER_ID desc';
        
        // instanciation d'objets "Modele\User" dont les attributs publics et protégés prennent pour valeur les donn�es de la BDD
        $requete = $this->executerRequete($sql,NULL,'\Framework\Entites\User');
        
        //la requ�te retourne un tableau contenant toutes les lignes du jeu d'enregistrements , les colonnes sont li�s aux attributs de la
        //la classe
        $users = $requete->fetchAll();
        
        // spécification de la langue utilisée pour l'affichage de la date et heure
        // cela permet d'utliser la fonction strftime() au moment d'afficher l'heure
    	$this->setHeureDateLocale();
        
        foreach ($users as $user)
        {
        		$user->setDateConnexion(new \DateTime($user->dateConnexion()));
        		$user->setDateEnregistrement(new \DateTime($user->dateEnregistrement()));
        }
        
        //permettre � la requ�te d'�tre de nouveau ex�cut�e
        $requete->closeCursor();
        return $users;
    }
    
    /**
    * 
    * Méthode getUser
    * 
    * méthode renvoyant l'ensemble des informations sur l'utilisateur sélectionné
    *
    * @param int $idUser identifiant de l'utilisateur
    * @return array représentant l'utilisateur sélectionné
    * @throws Exception si l'identifiant de l'utilisateur est inconnu
    */
    public function getUser($idUser)
    {      
        $sql =  $sql = 'select USER_ID as id, USER_DATE_ENREG as dateEnregistrement,'
                . ' USER_STATUT as userStatut, USER_PSEUDO as userPseudo, USER_MAIL as userMail,'
                . ' USER_TELEPHONE as userTelephone, USER_AVATAR as userAvatar, USER_DATE_CONNEXION as dateConnexion,'
                . ' USER_NBRE_COMMENTAIRES_BLOG as nbreCommentairesBlog, USER_NBRE_COMMENTAIRES_FORUM as nbreCommentairesForum,'        
                . ' USER_NOM as userNom, USER_PRENOM as userPrenom, USER_naissance as userNaissance from T_User'
                . ' where USER_ID=?';
  		
  		// instanciation d'objet "Modele\User" dont les attributs publics et protégés prennent pour valeur les donn�es de la BDD
        $requete = $this->executerRequete($sql, array($idUser),'\Framework\Entites\User');
        
        
        //si un User correspond (row_count() retourne le nombre de lignes affectées par la dernière requête) , renvoyer ses informations 
        //(fetch() renvoie la première ligne d'une requête )
        
        if ($requete->rowcount()==1)
        {
            $user = $requete->fetch();
                                    
        	$user->setDateConnexion(new \DateTime($User->dateConnexion()));
        	$user->setDateEnregistrement(new \DateTime($User->dateEnregistrement()));
        	return $user;
        }
        else
        {
            throw new \Exception("Aucun Utilisateur ne correspond à l'identifiant '$idUser'");
        }
    }
    
    /**
     * 
     * Méthode ajouterUser
     *
     * Cette méthode insère un nouveau User en BDD après son enregistrement
     * 
     * rappel : la valeur user_statut est par défaut = 4 (visiteur) dans la BDD
     *     *       
     * @param array $donnees tableau comprenant l'ensemble des données propres à un utilisateur
     *
     */
    public function ajouterUser(array $donnees)
    {
        //requ�te avec insertion de l'utilisateur
        $sql = 'insert into T_USER (USER_DATE_ENREG, USER_STATUT, USER_PSEUDO,'
                . ' USER_MAIL, USER_TELEPHONE, USER_AVATAR , USER_DATE_CONNEXION,'
                . ' USER_NBRE_COMMENTAIRES_BLOG, USER_NBRE_COMMENTAIRES_FORUM,'        
                . ' USER_NOM, USER_PRENOM, USER_NAISSANCE)'
                . ' values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        
        // utilisation de la classe DateTime pour faire correspondre le format Php avec le format DateTime de MySql, time courant de la machine
        $odate = new \DateTime();
    
        // il faut formater les dates en cha�ne de caract�re
        $dateEnregistrement = $odate->format('Y-m-d H:i:s');
        
        // Il s'agit de la première connexion de l'utilisateur, les 2 dates sont égales
        $dateConnexion = $dateEnregistrement;
        
        $donnees['USER_DATE_CONNEXION']= $dateConnexion;
        $donnees['USER_DATE_ENREG']= $dateEnregistrement;
        
        // l'utilisateur a un statut par defaut correspondant à celui d'un visiteur avec des droits limités
       // $userStatut = \Framework\Configuration::get('visiteur');
       
        
        
      //  $nbreCommentairesBlog = 0;
       // $nbreCommentairesForum = 0;
       // il peut être préférable de passer un tableau
    
        $requete = $this->executerRequete($sql,$donnees,'\Framework\Entites\User');
        
        // msg flash destiné à l'utilisateur pour l'informer du succès de son enregistrement à faire par le controleur
    }
    
    /**
     * 
     * Méthode recherchePseudo
     *
     * cette méthode permet de rechercher si un pseudo est dans la BDD des USER
     * 
     * @param string $pseudo
     * @return \Framework\Entites\User $user objet utilisateur si succès de la requête
     * @return boolean FALSE sinon
     */
    public function recherchePseudo($pseudo)
    {
     /// TDDO voir si en paramètre il n'est pas préférable de mettre un objet login

        $sql = 'select USER_ID as id, USER_HASH as hash, USER_PSEUDO as pseudo from T_USER'
                .'where USER_PSEUDO=?';
                
        $requete = $this->executerRequete($sql,$pseudo,'\Framework\Entites\User');
        
        if ($requete->rowcount()==1)
        {
             $user = $requete->fetch();
             
             $user->setDateConnexion(new \DateTime($user->dateConnexion()));
             $user->setDateEnregistrement(new \DateTime($user->dateEnregistrement()));         
             return $user;             
        }
        else
        {
            //TODO il faut dire au controleur que la pseudo n'exsite pas en BDD
            return FALSE;
        }
       
    }
}

    
    