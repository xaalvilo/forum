<?php
/**
 * 
 * @author Frédéric Tarreau
 *
 * 31 déc. 2014 - Session.class.php
 * 
 * Cette classe représente une session avec les attributs tels que définit dans la BDD Session
 * 
 * Rappel : dès l'inclusion du fichier par l'auto_load, la session se créée
 * PHP essaie de lire l'identifiant fourni par l'utilisateur (cookie nommé par défaut PHPSESSID, s'il n'en existe pas ,
 * il en créé un aléatoirement, l'envoie au client et créé des entrées dans le tableau $_SESSION[]
 */
namespace Framework\Entites;
require_once './Framework/autoload.php';

class Session extends \Framework\Entite
{
    /* nom de la session, aussi le nom du cookie de session */
    protected $_name;
    
    /* session data */
    protected $_data;
    
    /* date limite de vie max de la session */
    protected $_maxLifeDatetime ;
    
    /* identifiant de session alphanumerique, à ne pas confondre avec l'id de la classe Entite */
    protected $_identifiant;
    
    /* parametres du cookie de session */
    protected $_paramCookieSession;
    
    public function __construct(array $donnees = array())
    {
        parent::__construct($donnees);
                
        // le cookie de session est valable pour tout le site Forum
        $path = \Framework\Configuration::get('racineWeb');
        $this->setParamCookieSession('',0,$path);
       
        session_start();
        $this->_name = session_name();
        $this->_identifiant = session_id();       
    }
    
    /**
     * 
     * Méthode __destruct
     *
     * cette méthode détruit l'objet Session et détruit les données de session (pas la superglobale)
     *
     */
    public function  __destruct()
    {
        if(session_status()=== PHP_SESSION_ACTIVE)
        {
            session_write_close();
        }
    }
    
    /**
     * 
     * Méthode set
     *
     * cette méthode permet d'assigner une entrée dans la superglobale $_SESSION[]
     * 
     * @param string $cle
     * @param mixed $valeur
     */
    public function set($cle,$valeur)
    {
        if(is_string($cle))
        { 
            $_SESSION[$cle]=$valeur;
        }
    }
    
    /**
     * 
     * Méthode get
     *
     * cette méthode permet de récupérer une entrée dans la superglobale $_SESSION[]
     * 
     * @param string $cle
     * @return mixed valeur d'une entrée $_SESSION[]
     */
    public function get($cle)
    {
        return $_SESSION[$cle];
    }
   
   /**
    * 
    * Méthode remove
    *
    * méthode permettant de supprimer une entrée dans la superglobale $_SESSION[]
    * 
    * @param string $cle
    */ 
   public function remove($cle)
   {
       if(isset ($_SESSION[$cle]))
        {
            unset($_SESSION[$cle]);
        }
   }
   
   /**
    * 
    * Méthode setParamCookieSession
    *
    * Setter de l'attribut paramCookieSession
    * 
    * @param int $expire Le temps apr�s lequel le cookie expire.
    * @param string $path Le chemin sur le serveur sur lequel le cookie sera disponible
    * @param string $domain Le domaine pour lequel le cookie est disponible.
    * @param bool $secure Indique si le cookie doit uniquement �tre transmis � travers une connexion s�curis�e HTTPS depuis le client (si TRUE)
    * @param bool $httponly Lorsque ce param�tre vaut TRUE, le cookie ne sera accessible que par le protocole HTTP. 
    * 
    */
   public function setParamCookieSession($value='',$expire=0,$path=NULL,$domain=NULL,$secure=FALSE,$httponly=TRUE)
   {
       session_set_cookie_params($expire, $path, $domain, $secure, $httponly);
              
       // récupération des valeurs du cookie de session php
       $this->_paramCookieSession = session_get_cookie_params();     
   }
   
   /**
    * 
    * Méthode paramCookieSession
    *
    * getter de l'attribut paramCookiesession
    * 
    * @return array tableau de parametres du cookie de session
    */
   public function paramCookieSession()
   {
       return $this->_paramCookieSession;
   }

   
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
        
        return $this->_name;
    }
    
    /**
     * 
     * Méthode setName
     *
     * setter de l'attribut name, utilise la fonction Php session_name() 
     * Attention : doit être appelé avant session_start()
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
        return $this->_identifiant;
    }
    
    /**
     * 
     * Méthode setIdentifiant
     *
     * setter de Identifiant, utilise la fonction Php session_id()
     * Attention : doit être appelée avant sesssion_start()
     * 
     * @param string $identifiant
     */
    public function setIdentifiant($identifiant)
    {
         $this->_identifiant = $identifiant;
    }
    
    /**
     * 
     * Méthode setMaxLifeDatetime
     *
     * setter de l'attribut maxLifeDatetime
     * 
     * @param int $maxLifetime délai d'expiration de la session en secondes
     */
    public function setMaxLifeDatetime($maxLifetime)
    {
        if($maxLifetime != get_cfg_var('session.gc_maxlifetime'))
        {
            // modification de la valeur de configuration juste le temps d'exécution du script
            ini_set('session.gc_maxlifetime', "$maxLifetime");
        }
        $odate = new \DateTime();
        $interval='PT'.$maxLifetime.'S';
        $odate->add(new \DateInterval($interval));
        
        $this->_maxLifeDatetime = $odate;
    }
  
    /**
     * 
     * Méthode maxLifeDatetime
     *
     * getter de l'attribut maxLifeDatetime
     *
     * @return \DateTime $_maxLifeDatetime
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
    
    /**
     * 
     * Méthode detruireVariableSession
     *
     * methode détruisant les variables de $_SESSION 
     *
     */
    public function detruireVariableSession()
    {  
        $_SESSION = array();                
    }
}

