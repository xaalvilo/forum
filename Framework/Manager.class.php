<?php
namespace Framework ;
require_once './Framework/autoload.php';

/** 
* Classe abstraite fournissant les services d'acc�s � une base de donn�es via des requetes SQL
* Elle utilise l'API PDO de PHP
*/

abstract class Manager
{
	use Affichage;
	
    /**
    * objet PDO d'acc�s � la BDD 
    * attribut de classe statique donc partag�e par toutes les instances des classes d�riv�es de Modele
    * ainsi l'op�ration de connexion � la BDD ne sera r�alis�e qu'une seule fois
    */
    private static $_bdd ;
    
    /** 
    * M�thode ex�cutant une requ�te SQL �ventuellement param�tr�e (valeur par d�faut nulle). la préparation des requ�tes permet
    * de se prémunir des injections SQL
    *
    * @param string $sql requete sql
    * @param array $params paramètres de la requete
    * @return PDOstatement r�sultat de la requete
    */
    protected function executerRequete($sql,$params = null,$entite)
    {
        if($params == null)
        {
            //execution directe de la requete s'il n'y a pas de paramètre 
            $resultat = self::getBdd()->query($sql);
        }
        else
        {
            //execution de la requete pr�par�e
            $resultat = self::getBdd()->prepare($sql);
            $resultat->execute($params);  
        }
        
        //d�finit le mode de r�cup�ration par d�faut des donn�es en BDD : ici sous forme d'objets de la classe $entit�
        $resultat->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE,$entite);         
        return $resultat;
    }    
                    
    /** 
    * M�thode statique renvoyant un objet de connexion � la BDD en initialisant la connexion au besoin
    *
    * @return PDO object PDO de connexion � la BDD
    */  
    private static function getBdd()
    {
        // creation de la connexion si elle n'existe pas 
        if(self::$_bdd == NULL )
        {
            // recupération des parametres de configuration 
            $dsn = Configuration::get("dsn");
            $login = Configuration::get("login");
            $mdp = Configuration::get("mdp");
            
            // creation de la connexion 
           self::$_bdd = new \PDO($dsn, $login, $mdp, array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));     
        }
        return self::$_bdd;
    }
}
            