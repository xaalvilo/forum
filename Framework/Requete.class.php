<?php
namespace Framework;

/**
 * 
 * @author Frédéric Tarreau
 *
 * 10 nov. 2014 - Requete.class.php
 * 
 * la classe Requête aura le rôle de modéliser une requête HTTP entrante
 *
 */

class Requete extends ApplicationComponent
{
    /* Tableau des parametres de la requête */
    private $_parametres;
    
    /**
    * 
    * Constructeur
    * 
    * cette méthode permet de construire l'objet requête
    *
    * @param Application $app instance de l'application
    * @param array $parametres Tableau Paramètres de la requête
    */
     public function __construct($app,$parametres)
     {
     	parent::__construct($app);
     	$this->_parametres = $parametres;
     }
     
    /**
    * 
    * Méthode existeParametre
    * 
    * cette méthode teste si le parametre existe bien dans la requête
    *
    * @param string $nom Nom du paramètre
    * @return Boolean - vrai si le paramètre existe dans la requête et sa valeur n'est pas vide
    */
    public function existeParametre($nom)
    {
        return (isset($this->_parametres[$nom]) && $this->_parametres[$nom] != "");
    }
     
    /**
    * 
    * Méthode getParametre
    * 
    * cette méthode renvoie la valeur du parametre demandé et lève une exception si le parametre est introuvable
    *
    * @param string $nom Nom du paramètre
    * @return string Valeur du paramètre
    * @throws Exception Si le paramètre n'existe pas dans la requête
    */
     public function getParametre($nom)
     {
         // vérification de l'existence du parametre, si ce n'est pas le cas, envoi d'une exception
        if ($this->existeParametre($nom))
        {
            return $this->_parametres[$nom];
        }
        else
        {
            throw new \Exception ("Parametre '$nom' absent de la requête");
        }             
    }
    
    /**
     * 
     * Méthode getMethode
     * 
     * cette methode permet de savoir quelle methode a ete utilisée dans la requete en utilisant la superglobale $_SERVER
     *
     * @return string Methode utilisée par la requête du client (GET ou POST)
     *
     */
    public function getMethode()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
    
    /**
    * 
    * Methode cookieExists
    * 
    * cette methode determine si un cookie existe
    * 
    * @param string $key nom du cookie
    * @return boolean TRUE si la valeur du cookie existe
    */
    public function cookieExists($key)
    {
    	return isset ($_COOKIE[$key]);
    }
    
    /**
    * 
    * Methode cookieData
    * 
    * cette m�thode renvoie le Cookie
    * 
    * @param string $key nom du cookie
    * @return mixed valeur du cookie
    */
    public function cookieData($key)
    {
    	// operateur ternaire 
    	return isset($_COOKIE[$key]) ? $_COOKIE[$key]:null;
    }
}
     