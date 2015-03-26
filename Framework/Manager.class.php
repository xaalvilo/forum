<?php
namespace Framework ;
require_once './Framework/autoload.php';

/**
 *
 * @author frederic
 *
 * Classe abstraite fournissant les services d'acc�s � une base de donn�es via des requetes SQL
 * Elle utilise l'API PDO de PHP
 *
 */

abstract class Manager
{
	use Affichage;

    /**
    * objet PDO d'acc�s � la BDD
    * attribut de classe statique donc partag�e par toutes les instances des classes d�riv�es de Modele
    * ainsi l'op�ration de connexion � la BDD ne sera r�alis�e qu'une seule fois
    */
    protected static $_bdd ;

    /**
    * M�thode ex�cutant une requ�te SQL �ventuellement param�tr�e (valeur par d�faut nulle). la préparation des requ�tes permet
    * de se prémunir des injections SQL
    * le gestionnaire d'erreur PDO avec exception est retenu sauf pour les requêtes d'insertion permettant d'analyser le code erreur et d'informer l'utilisateur
    *
    * @param string $sql requete sql
    * @param array $params paramètres de la requete sql
    * @param \Framework\Entite $entite
    * @return PDOstatement r�sultat de la requete sql
    * @return int identifiant
    * @return array errorInfo 	avec Code erreur SQLSTATE (un identifiant de cinq caractères alphanumériques défini dans le standard ANSI SQL),
    * 								 Code erreur spécifique au driver.
    * 								 Message d'erreur spécifique au driver.
    */
    protected function executerRequete($sql,$params=null,$entite=null)
    {
        if($params==null){
            //execution directe de la requete s'il n'y a pas de paramètre
            $resultat = self::getBdd()->query($sql);

            // si erreur a l'execution, envoyer le code erreur sql ..ne marchera pas si error mode avec exceptions
           	if(!$resultat)
            	return $resultat->errorInfo();
        }
        else {
            //execution de la requete pr�par�e
            $resultat = self::getBdd()->prepare($sql);

         	// si erreur a l'execution d'une insertion, envoyer le code erreur sql -utile pour vérification d'unicité d'un login par exemple
            if (substr_count($sql,'insert') > 0)
            	self::getBdd()->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_SILENT);

            if(!$resultat->execute($params))
		    	return $resultat->errorInfo();

           // s'il s'agit d'une requete d'insertion, renvoyer l'identifiant
            if (substr_count($sql,'insert') > 0)
            	return self::getBdd()->lastInsertId();
        }

        //d�finit le mode de r�cup�ration par d�faut des donn�es en BDD : ici sous forme d'objets de la classe $entité ou tableau
        if(!empty($entite))
            $resultat->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE,$entite);
        else
            $resultat->setFetchMode(\PDO::FETCH_ASSOC);

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
        if(self::$_bdd == NULL)
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
