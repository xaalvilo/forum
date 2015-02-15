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
                . ' USER_STATUT as _statut, USER_PSEUDO as _pseudo, USER_MAIL as _mail,'
                . ' USER_TELEPHONE as _telephone, USER_AVATAR as _avatar,'
                . ' USER_NBRECOMMENTAIRESBLOG as _nbreCommentairesBlog, USER_NBRECOMMENTAIRESFORUM as _nbreCommentairesForum, USER_NBREBILLETSFORUM as _nbreBilletsForum,'
                . ' USER_NOM as _nom, USER_PRENOM as _prenom, USER_NAISSANCE as _naissance, USER_IP as _ip, USER_HASH as _hash,'
                . ' USER_PAYS as _pays, USER_DATEINSCRIPTION as _dateInscription, USER_DATECONNEXION as _dateConnexion from T_User'
                . ' order by USER_ID desc';
        
        // instanciation d'objets "Modele\User" dont les attributs publics et protégés prennent pour valeur les donn�es de la BDD
        $resultat = $this->executerRequete($sql,NULL,'\Framework\Entites\User');
        
        //la requ�te retourne un tableau contenant toutes les lignes du jeu d'Inscriptions , les colonnes sont li�s aux attributs de la
        //la classe
        $users = $resultat->fetchAll();
        
        // spécification de la langue utilisée pour l'affichage de la date et heure
        // cela permet d'utliser la fonction strftime() au moment d'afficher l'heure
    	$this->setHeureDateLocale();
        
        foreach ($users as $user)
        {
            // il faut transformer l'attribut Date en objet DateTime
        	$user->setDateConnexion(new \DateTime($user->dateConnexion()));
        	$user->setDateInscription(new \DateTime($user->dateInscription()));
        }
        
        //permettre � la requ�te d'�tre de nouveau ex�cut�e
        $resultat->closeCursor();
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
                . ' USER_STATUT as _statut, USER_PSEUDO as _pseudo, USER_MAIL as _mail,'
                . ' USER_TELEPHONE as _telephone, USER_AVATAR as _avatar,'
                . ' USER_NBRECOMMENTAIRESBLOG as _nbreCommentairesBlog, USER_NBRECOMMENTAIRESFORUM as _nbreCommentairesForum, USER_NBREBILLETSFORUM as _nbreBilletsForum,'
                . ' USER_NOM as _nom, USER_PRENOM as _prenom, USER_NAISSANCE as _naissance, USER_IP as _ip, USER_HASH as _hash,'
                . ' USER_PAYS as _pays, USER_DATEINSCRIPTION as _dateInscription, USER_DATECONNEXION as _dateConnexion  from T_User' 
                . ' where USER_ID=?';
        	 
  		// instanciation d'objet "Modele\User" dont les attributs publics et protégés prennent pour valeur les donn�es de la BDD
        $resultat = $this->executerRequete($sql, array($idUser),'\Framework\Entites\User');
                
        //si un User correspond (row_count() retourne le nombre de lignes affectées par la dernière requête) , renvoyer ses informations 
        //(fetch() renvoie la première ligne d'une requête )
        if ($resultat->rowcount()==1)
        {
            // récupération sous forme de tableau
            $user = $resultat->fetch(\PDO::FETCH_ASSOC);
            
            // liberer la connexion
            $resultat->closeCursor();
            
            // il faut transformer l'attribut Date en objet DateTime
            $user['_dateConnexion'] = new \DateTime($user['_dateConnexion']);
            $user['_dateInscription'] = new \DateTime($user['_dateInscription']);
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
                . ' USER_NBRECOMMENTAIRESFORUM, USER_NBREBILLETSFORUM, USER_NOM, USER_PRENOM, USER_NAISSANCE,'
                . 'USER_IP, USER_HASH, USER_PAYS, USER_DATEINSCRIPTION, USER_DATECONNEXION)'
                . ' values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        
        // utilisation de la classe DateTime pour faire correspondre le format Php avec le format DateTime de MySql, time courant de la machine
        $odate = new \DateTime();
            
        // il faut formater les dates en cha�ne de caract�re , les dates sont identiques
        $param[] = $odate->format('Y-m-d H:i:s');
        $param[]=  $odate->format('Y-m-d H:i:s');      
                
        $resultat = $this->executerRequete($sql,$param,'\Framework\Entites\User');
       
       	return $resultat;
    }
    
    /**
     * 
     * Méthode recherchePseudo
     *
     * cette méthode permet de rechercher si un pseudo est dans la BDD des USER
     *      * 
     * @param string $pseudo
     * @return array $tableauResultat objet tableau associatif avec les résultats de la requête
     * @return boolean FALSE sinon
     */
    public function recherchePseudo($pseudo)
    {
        $sql = 'select USER_ID as id, USER_HASH as _hash from T_USER'
                . ' where USER_PSEUDO=?';
                
        $resultat = $this->executerRequete($sql,array($pseudo),'\Framework\Entites\User');
        
        if ($resultat->rowcount()==1)
        {           
            // modification du type de récupération des données de la BDD, ici sous forme de tableau
             $tableauResultat = $resultat->fetch(\PDO::FETCH_ASSOC);
             return $tableauResultat;             
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
     * @throws \Exception en cas d'erreur de requête
     */
    public function actualiserUser($idUser, array $donnees)
    { 
        if(array_key_exists('_dateConnexion', $donnees))   
        {     
            $donnees['_dateConnexion']= $donnees['_dateConnexion']->format('Y-m-d H:i:s');
        }
        
        if(array_key_exists('_dateInscription', $donnees))
        {
            $donnees['_dateInscription']= $donnees['_dateInscription']->format('Y-m-d H:i:s');
        }
        
        // création de la chaîne de caractère pour la requête SQL
        // retirer au préalable l'identifiant qui n'est jamais actualisé
        unset ($donnees['id']);      
        $nbreModifications=count($donnees);  
        $modification ='';
        $i=0;
        
        foreach ($donnees as $attribut=>$valeur)
        {
            $i++;
            $modification.='USER'.strtoupper($attribut).'=?';
            if ($i<$nbreModifications)
            {
                $modification.=', ';               
            }
        }
      
         // préparation de la requête SQL UPDATE
        $sql = 'update T_USER set '.$modification.' where USER_ID=?';
      
         // ajout de l'identifiant pour l'exécution de la requête
         $donnees['id']= $idUser;
         
         // transformation du tableau en tableau indexé
         $donnees = array_values($donnees);
         
         $resultat = $this->executerRequete($sql,$donnees,'\Framework\Entites\User');
            
         if ($resultat===FALSE)
         {
             //TODO msg Flash non OK
             throw new \Exception("Données de l'utilisateur '$idUser' non mises à jour");
         }             
    }
    
    /**
     * 
     * Méthode userExists
     *
     * cette méthode regarde si un utilisateur qui cherche à s'inscrire n'exsite pas déjà en 
     * BDD
     * 
     * @return bool TRUE s'il existe déjà, FALSE sinon
     *
     */
    public function userExists()
    {
        //
        return FALSE;
    }
}

    
    