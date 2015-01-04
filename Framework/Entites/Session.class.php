<?php
/**
 * 
 * @author Frédéric Tarreau
 *
 * 31 déc. 2014 - Session.class.php
 * 
 * Cette classe représente une session avec les attributs tels que définit dans la BDD Session
 *
 */
namespace Framework\Entites;
require_once './Framework/autoload.php';

class Session extends \Framework\Entite
{
    /* nom de la session */
    protected $_name;
    
    /* session data */
    protected $_data;
    
    /* date limite de vie max de la session */
    protected $_maxLifeDatetime ;
    
    /* identifiant de session alphanumerique, à ne pas confondre avec l'id de la classe Entite */
    protected $_identifiant;
    
    /**
     * 
     * Méthode name
     *
     * getter de l'attribut name, utilise la fonction Php session_name()
     * 
     * @return string Nom de la session
     */
    public function name()
    {
        $this->_name = session_name();
        return $this->_name;
    }
    
    /**
     * 
     * Méthode setName
     *
     * setter de l'attribut name, utilise la fonction Php session_name()
     * 
     * @param string $name
     */
    public function setName($name)
    {
        $this->_name = session_name($name);
    }
    
    /**
     * 
     * Méthode Identifiant
     *
     * getter de Identifiant, utilise la fonction Php session_id()
     * 
     * @return string Identifiant de session
     */
    public function identifiant()
    {
        $this->_identifiant = session_id();
       return $this->_identifiant;
    }
    
    /**
     * 
     * Méthode setIdentifiant
     *
     * setter de Identifiant, utilise la fonction Php session_id()
     * 
     * @param string $identifiant
     */
    public function setIdentifiant($identifiant=NULL)
    {
         $this->_identifiant = session_id($identifiant);
    }
     
    /**
     * 
     * Méthode setMaxLifeDatetime
     *
     * setter de l'attribut maxLifeDatetime
     * 
     * @param \DateTime $maxLifeDatetime
     */
    public function setMaxLifeDatetime (\DateTime $maxLifeDatetime)
    {
        $this->_maxLifetime = $maxLifetime;
    }
    
    /**
     * 
     * Méthode maxLifeDatetime
     *
     * getter de l'attribut maxLifeDatetime
     *
     * @return string $_maxLifeDatetime
     */
    public function maxLifeDatetime()
    {
        return $this->_maxLifeDatetime;
    }
    
    /**
     * 
     * Méthode Data
     * 
     * getter de l'attribut Data
     *
     * @return array $_data
     *
     */
    public function data()
    {
        return $this->_data;
    }
    
    /**
     * 
     * Méthode setData
     *
     * setter de l'attribut Data
     * 
     * @param array $donnees
     */
    public function setData($donnees)
    {
        $this->_data=$donnees;
    }    
}

