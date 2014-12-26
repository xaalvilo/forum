<?php
namespace Framework\Modeles ;
use Framework\Configuration;
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
    * 
    */
    public function getUsers()
    {
        //requête avec classement des Users dans l'ordre décroissant 
        $sql = 'select USER_ID as id,'
                . ' USER_STATUT as statut, USER_PSEUDO as pseudo, USER_MAIL as mail,'
                . ' USER_TELEPHONE as telephone, USER_AVATAR as avatar,'
                . ' USER_NBRECOMMENTAIRESBLOG as nbreCommentairesBlog, USER_NBRECOMMENTAIRESFORUM as nbreCommentairesForum,'        
                . ' USER_NOM as nom, USER_PRENOM as prenom, USER_NAISSANCE as naissance, USER_IP as ip, USER_HASH as hash,'
                . ' USER_PAYS as pays,USER_DATEINSCRIPTION as dateInscription,USER_DATECONNEXION as dateConnexion from T_User'
                . ' order by USER_ID desc';
        
        // instanciation d'objets "Modele\User" dont les attributs publics et protégés prennent pour valeur les donn�es de la BDD
        $requete = $this->executerRequete($sql,NULL,'\Framework\Entites\User');
        
        //la requ�te retourne un tableau contenant toutes les lignes du jeu d'Inscriptions , les colonnes sont li�s aux attributs de la
        //la classe
        $users = $requete->fetchAll();
        
        // spécification de la langue utilisée pour l'affichage de la date et heure
        // cela permet d'utliser la fonction strftime() au moment d'afficher l'heure
    	$this->setHeureDateLocale();
        
        foreach ($users as $user)
        {
        		$user->setDateConnexion(new \DateTime($user->dateConnexion()));
        		$user->setDateInscription(new \DateTime($user->dateInscription()));
        		//$user->setNaissance(new \DateTime($user->Naissance()));
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
        $sql = 'select USER_ID as id,'
                . ' USER_STATUT as statut, USER_PSEUDO as pseudo, USER_MAIL as mail,'
                . ' USER_TELEPHONE as telephone, USER_AVATAR as avatar,'
                . ' USER_NBRECOMMENTAIRESBLOG as nbreCommentairesBlog, USER_NBRECOMMENTAIRESFORUM as nbreCommentairesForum,'        
                . ' USER_NOM as nom, USER_PRENOM as prenom, USER_NAISSANCE as naissance, USER_IP as ip, USER_HASH as hash,'
                . ' USER_PAYS as pays, USER_DATEINSCRIPTION as dateInscription, USER_DATECONNEXION as dateConnexion  from T_User' 
                . ' where USER_ID=?';
        		
  		// instanciation d'objet "Modele\User" dont les attributs publics et protégés prennent pour valeur les donn�es de la BDD
        $requete = $this->executerRequete($sql, array($idUser),'\Framework\Entites\User');
                
        //si un User correspond (row_count() retourne le nombre de lignes affectées par la dernière requête) , renvoyer ses informations 
        //(fetch() renvoie la première ligne d'une requête )
        if ($requete->rowcount()==1)
        {
            $user = $requete->fetch();
                                    
        	$user->setDateConnexion(new \DateTime($User->dateConnexion()));
        	$user->setDateInscription(new \DateTime($User->dateInscription()));
        	//$user->setNaissance(new \DateTime($user->Naissance()));
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
     * Cette méthode insère un nouveau User en BDD après son Inscription
     * 
     * rappel : la valeur user_statut est par défaut = 4 (visiteur) dans la BDD
     *     *       
     * @param array $donnees tableau comprenant l'ensemble des données propres à un utilisateur
     *
     */
    public function ajouterUser(array $param)
    {
        //requ�te avec insertion de l'utilisateur
        $sql = 'insert into T_USER (USER_STATUT, USER_PSEUDO,'
                . ' USER_MAIL, USER_TELEPHONE, USER_AVATAR, USER_NBRECOMMENTAIRESBLOG,'
                . ' USER_NBRECOMMENTAIRESFORUM, USER_NOM, USER_PRENOM, USER_NAISSANCE,'
                . 'USER_IP, USER_HASH, USER_PAYS,USER_DATEINSCRIPTION, USER_DATECONNEXION)'
                . ' values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        
        // utilisation de la classe DateTime pour faire correspondre le format Php avec le format DateTime de MySql, time courant de la machine
        $odate = new \DateTime();
            
        // il faut formater les dates en cha�ne de caract�re , les dates sont identiques
        $param[] = $odate->format('Y-m-d H:i:s');
        $param[]=  $odate->format('Y-m-d H:i:s');      
       // $param['naissance']= $odat
           
        var_dump($param);
        $requete = $this->executerRequete($sql,$param,'\Framework\Entites\User');
        
        // msg flash destiné à l'utilisateur pour l'informer du succès de son Inscription à faire par le controleur
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
             $user->setDateInscription(new \DateTime($user->dateInscription()));         
             return $user;             
        }
        else
        {
            //TODO il faut dire au controleur que la pseudo n'existe pas en BDD
            return FALSE;
        }       
    }
        
    /**
     * 
     * Méthode actualiserUser
     *
     * Cette méthode permet d'actualiser les données d'un utilisateur dans la BDD
     * 
     * @param int $idUser
     * @param array $donnees tableau des donnees utilisateur à actualiser
     */
    public function actualiserUser($idUser, array $donnees)
    {
        $user = $this->getUser($idUser);
        
        // actualisation des attributs de l'utilisateur avec les nouvelles données 
        $user->hydrate($donnees);
        
        $nbreModifications=count($donnees);        
        
        // création de la chaîne de caractère pour la requête SQL
        $modification ='';
        $i=0;
        
        foreach ($donnees as $attribut=>$valeur)
        {
            $i++;
            $modification.='USER_'.strtoupper($attribut).'=\''.$valeur.'\'';
            if ($i<$nbreModifications)
            {
                $modification.=',';
            }
        }
      
        // préparation de la requête SQL UPDATE
        $sql = 'update T_USER set'.$modification.'where USER_ID=?';
        
         $requete = $this->executerRequete($sql,$idUser,'\Framework\Entites\User');
         
         // une requête SQL UPDATE renvoie le nombre d'entrées modifiées
         if ($requete==$nbreModifications)
         {
             //TODO msg Flash OK
         }             
         else
         {
             //TODO msg Flash non OK
             throw new \Exception("Données de l'utilisateur '$idUser' non mises à jour");
         }
    }
}

    
    