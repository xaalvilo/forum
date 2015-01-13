<?php
/**
 * 
 * @author Frédéric Tarreau
 *
 * 3 oct. 2014 - Application.class.php
 * 
 * Classe abstraite représentant une application. Elle a pour rôle de s'exécuter et d'instancier la requête et 
 * la réponse au client. Elle se caractérise par le nom de l'application
 *
 */
namespace Framework;
require_once './Framework/autoload.php';

abstract class Application
{
	protected $_httpRequete;
	protected $_httpReponse;
	protected $_userHandler;
	protected $_sessionHandler;
	protected $_routeur;
	protected $_nom;
	
	/**
	 * 
	 * Méthode __construct
	 *
	 * ce constructeur va instancier les objets suivants :
	 * - routeur ;
	 * - httpReponse
	 * - MysSessionHandler
	 * - session
	 * - user
	 * - userHandler
	 *
	 */
	public function __construct()
	{
		$this->_routeur = new Routeur($this);
		$this->_httpReponse = new Reponse($this);
		$this->_sessionHandler = new MySessionHandler($this);
		session_set_save_handler($this->_sessionHandler,true);
		$session = new \Framework\Entites\Session(); 
		$user = new \Framework\Entites\User();
		$this->_userHandler = new UserHandler($this,$session,$user);
		$this->_nom ='';
	}
	
	/**
	 * 
	 * Méthode abstraite run
	 *
	 * return_type
	 *
	 */
	abstract public function run();
	
	/**
	 * 
	 * Méthode httpRequete
	 * 
	 * 
	 */
	public function httpRequete()
	{
		return $this->_httpRequete;
	}
	
	/**
	 *
	 * Méthode routeur
	 *
	 *
	 */
	public function routeur()
	{
		return $this->_routeur;
	}
	
	/**
	 *
	 * Méthode httpReponse
	 *
	 *
	 */
	public function httpReponse()
	{
		return $this->_httpReponse;
	}
	
	/**
	 * 
	 * Méthode
	 *
	 * \Framework\UserHandler
	 * 
	 * @return \Framework\UserHandler
	 */
	public function userHandler()
	{
	    return $this->_userHandler;
	}
	
	/**
	 * 
	 * Méthode nom
	 * 
	 * 
	 */
	 public function nom()
	 {
		return $this->_nom;
	 }
}