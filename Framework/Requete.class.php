<?php
namespace Framework;

/**
*  la classe Requête aura le rôle de modéliser une requête HTTP entrante
*/

class Requete extends ApplicationComponent
{
    /* Tableau des parametres de la requête */
    private $_parametres;
    
    /**
    * cette méthode permet de construire l'objet requête
    *
    * @param array $parametres Tableau Paramètres de la requête
    */
     public function __construct($app,$parametres)
     {
     	parent::__construct($app);
     	$this->_parametres = $parametres;
     }
     
    /**
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
    * cette méthode renvoie la valeur du parametre demandé et lève une exception si le parametre est introuvable
    *
    * @param string $nom Nom du paramètre
    * @return string Valeur du paramètre
    * @throws Exception Si le paramètre n'existe pas dans la requête
    */
     public function getParametre($nom)
     {
         /* vérification de l'existence du parametre */
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
    * cette methode d�termine si un cookie existe
    * 
    * @param string $key nom du cookie
    * @return boolean TRUE si la valeur du cookie existe
    */
    public function cookieExists($key)
    {
    	return isset ($_COOKIE[$key]);
    }
    
    /**
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
     