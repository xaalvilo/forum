<?php
namespace Framework\Modeles ;
require_once './Framework/autoload.php';
/**
 * 
 * @author Frédéric Tarreau
 *
 * 31 déc. 2014 - ManagerSession.class.php
 * 
 * classe h�rit�e de la classe abstraite Mod�le dont le r�le est la gestion des acc�s à la BDD des sessions  
 *
 */

class ManagerSession extends \Framework\Manager
{
    /**
    *
    * Méthode getSessions
    * 
    * méthode renvoyant la liste de l'ensemble des sessions actives de la BDD
    *
    * @return PDOStatement la liste des sessions
    */
    public function getSessions()
    {
        //requête avec classement des billets dans l'ordre décroissant 
        $sql = 'select SESSION_IDENTIFIANT as identifiant, SESSION_MAXLIFEDATETIME as maxLifeDatetime,'
                . ' SESSION_NAME as name, SESSION_DATA as data from T_SESSION'
                . ' order by SESSION_MAXLIFETIME desc';
        
        // instanciation d'objets "Entites\Session" dont les attributs publics et protégés prennent pour valeur les donn�es de la BDD
        $requeteSQL = $this->executerRequete($sql,NULL,'\Framework\Entites\Session');
        
        //la requ�te retourne un tableau contenant toutes les lignes du jeu d'Inscriptions , les colonnes sont li�s aux attributs de la
        //la classe
        $sessions = $requete->fetchAll();
        
        foreach ($sessions as $session)
        {
            // il faut transformer l'attribut Date en objet DateTime
            $session->setMaxLifeDatetime(new \DateTime($session->_maxLifeDatetime()));
        }
        
        //permettre � la requ�te d'�tre de nouveau ex�cut�e
        $requeteSQL->closeCursor();
        return $sessions;
    }    
      
    /**
    * 
    * Méthode getSession
    * 
    * méthode renvoyant l'objet session sélectionnée
    *
    * @param int $identifiant de la session
    * @return \Framework\Entites\Session
    * @throws Exception si l'identifiant de session est inconnu
    */
    public function getSession($identifiant)
    {      
        $sql = 'select SESSION_IDENTIFIANT as identifiant,SESSION_MAXLIFEDATETIME as maxLifeDatetime,'
                . ' SESSION_NAME as name, SESSION_DATA as data from T_SESSION'
                . ' where SESSION_IDENTIFIANT=?';
  		
  		// instanciation d'objet "Entites\Session" dont les attributs publics et protégés prennent pour valeur les donn�es de la BDD
        $requeteSQL =$this->executerRequete($sql, array($identifiant),'\Framework\Entites\Session');
        
        //si une session correspond (row_count() retourne le nombre de lignes affectées par la dernière requête) , renvoyer ses informations 
        //(fetch() renvoie la première ligne d'une requête )
        
        if ($requeteSQL->rowcount()==1)
        {
            $session = $requeteSQL->fetch();
            return $session;
        }
        else
        {
           throw new \Exception("Aucune session ne correspond à l'identifiant $identifiant");
        }
    }
    
    /**
     *
     * Méthode getSessionData
     *
     * méthode renvoyant les informations de l'attribut session_data de la session sélectionnée
     *
     * @param int $identifiant de la session
     * @return array la session sélectionnée
     * @throws Exception si l'identifiant de session est inconnu
     */
    public function getSessionData($identifiant)
    {
        $sql = 'select SESSION_DATA as data from T_SESSION where SESSION_IDENTIFIANT=?';
    
      		// instanciation d'objet "Entites\Session" dont les attributs publics et protégés prennent pour valeur les donn�es de la BDD
        $requeteSQL =$this->executerRequete($sql, array($identifiant),'\Framework\Entites\Session');
    
        //si une session correspond (row_count() retourne le nombre de lignes affectées par la dernière requête) , renvoyer ses informations
        //(fetch() renvoie la première ligne d'une requête )
    
        if ($requeteSQL->rowcount()==1)
        {
            // rappel : PDO::FETCH_ASSOC: retourne un tableau indexé par le nom de la colonne comme retourné 
            // dans le jeu de résultats. il faut retourner la valeur et non le tableau
            $session = $requeteSQL->fetch(\PDO::FETCH_ASSOC);
            return $session['data'];
        }
        else
        {
            return "";
            // throw new \Exception("Aucune session ne correspond à l'identifiant $identifiant");
        }
    }
    /**
     * 
     * Méthode rechercheIdentifiant
     *
     * méthode permettant de voir si une session existe en BDD
     * 
     * @param string $identifiant
     * @return array résultat sous forme de tableau associatif |boolean FALSE si échec 
     */
    public function rechercheIdentifiant($identifiant)
    {
        $sql = 'select SESSION_IDENTIFIANT as identifiant from T_SESSION'
                . ' where SESSION_IDENTIFIANT=?';
        
        $requeteSQL = $this->executerRequete($sql,array($identifiant),'\Framework\Entites\Session');
        
        if ($requeteSQL->rowcount()==1)
        {
            // modification du type de récupération des données de la BDD, ici sous forme de tableau
            $tableauResultat = $requeteSQL->fetch(\PDO::FETCH_ASSOC);
            return $tableauResultat;
        }
        else
        {
            //TODO il faut dire au gestionnaire de session que l'identifiant n'existe pas en BDD
            return array();
        }
    }
    
    /**
     * 
     * Méthode ajouterSession
     *
     * Cette méthode insère une session en BDD
     * 
     * @param string $identifiant
     * @param array $donnees valeurs diverses
     * @return boolean succès ou non de la requete SQL
     */
    public function ajouterSession($identifiant, $maxLifeDatetime, $donnees)
    {
        //requ�te avec insertion de la session
        $sql = 'insert into T_SESSION(SESSION_IDENTIFIANT, SESSION_NAME, SESSION_MAXLIFEDATETIME, SESSION_DATA)'
                . ' values(?, ?, ?, ?)';        
        
        // par défaut le nom de la session en BDD est le même que celui du fichier de configuration
        $name = ini_get('session.name');
        
        $requeteSQL = $this->executerRequete($sql,array($identifiant, $name, $maxLifeDatetime, $donnees),'\Framework\Entites\Session');
        
        if ($requeteSQL===FALSE)
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
    
     /**
     * 
     * Méthode supprimerSession
     *
     * Cette méthode supprime une session en BDD
     * 
     * @param string $idendifiant
     * @return boolean TRUE si la suppression de l'enregistrement s'est bien déroulée 
     */
    public function supprimerSession($identifiant)
    {
        //requete avec suppression de la session
        $sql = 'delete from T_SESSION where SESSION_IDENTIFIANT = ?';
        
        $requeteSQL = $this->executerRequete($sql, array($identifiant),'\Framework\Entites\Session');
        
        return ($requeteSQL->rowcount()==1);
    }
    
    /**
     * 
     * Méthode actualiserSession
     *      
     * cette méthode actualise les données d'une session en BDD
     * 
     * @param string $identifiant de la session
     * @param string $maxLifeDatetime de la session
     * @param string $donnees de la session
     * @param string $name nom de la session si different de celui par défaut
     */
    public function actualiserSession($identifiant, $maxLifeDatetime, $donnees = "", $name = NULL)
    {
            $donneesModifiees = array ('maxLifeDatetime'=>$maxLifeDatetime, 'data'=>$donnees, 'name'=>$name); 
           
            // création de la chaîne de caractère pour la requête SQL
            $modification ="";
            $i=0;
            foreach ($donneesModifiees as $attribut=>$valeur)
            {
                if(!empty($valeur))
                {    
                    if ($i>0)
                    {
                        $modification.=', ';
                    }
                    $modification.=' SESSION_'.strtoupper($attribut).'=?';
                    $parametres[$i] = $valeur;
                    $i++;
                }
            }
            // ajout de l'identifiant
            $parametres[]=$identifiant;
           
            // préparation de la requête SQL UPDATE
            $sql = 'update T_SESSION set'.$modification.' where SESSION_IDENTIFIANT=?';
        
            $requeteSQL = $this->executerRequete($sql, $parametres,'\Framework\Entites\Session');
        
            if ($requeteSQL===FALSE)
            {
                //TODO msg Flash non OK
                throw new \Exception("Données de l'utilisateur '$idUser' non mises à jour");
            }
            else
            {
                //TODO msg Flash OK
            }   
    }
    
    /**
     * 
     * Méthode getExpiredSessions
     *
     * Cette méthode sélectionne les sessions en BDD dont la durée de vie a dépassé la limite maxLifetime
     * 
     * @param \DateTime $odate
     * @return array Tableau liste des identifiants des sessions expirees | boolean FALSE si échec
     */
    public function getExpiredSessions($odate)
    {
        $date = $odate->format('Y-m-d H:i:s');
        
        $sql = 'select SESSION_IDENTIFIANT as identifiant from T_SESSION where SESSION_MAXLIFEDATETIME <?';
                        
        $requeteSQL = $this->executerRequete($sql,array($date),'\Framework\Entites\Session');
        
        if ($requeteSQL===FALSE)
        {
            //TODO il faut dire au gestionnaire de session que l'identifiant n'existe pas en BDD
            return FALSE;           
        }
        else
        {
            // modification du type de récupération des données de la BDD, ici sous forme de tableau
            $tableauResultat = $requeteSQL->fetchAll(\PDO::FETCH_COLUMN);
            return $tableauResultat;
        }
    }
}

    
    