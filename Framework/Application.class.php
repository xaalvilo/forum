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
	protected $_routeur;
	protected $_nom;
	
	public function __construct()
	{
		// Instanciation de l'objet reponse, l'objet requete est instancié par le Routeur = controleur frontal
		$this->_routeur = new Routeur($this);
		$this->_httpReponse = new Reponse($this);
		$this->_nom = '';		
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
	 * Méthode nom
	 * 
	 * 
	 */
	 public function nom()
	 {
		return $this->_nom;
	 }
}