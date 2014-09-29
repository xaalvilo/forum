<?php
/**
 * Classe abstraite repr�sente une Application
 * 
 * @author tarreau
 *
 */
namespace Framework;
require_once './Framework/autoload.php';

abstract class Application
{
	protected $httpRequete;
	protected $httpReponse;
	protected $nom;
	
	public function __construct()
	{
		//$this->httpRequete = new Requete($parametres);
		$this->httpReponse = new Reponse ($this) ;
		$this->nom = '';		
	}
	
	abstract public function run();
	
	public function httpRequete()
	{
		return $this->httpRequete;
	}
	
	public function httpReponse()
	{
		return $this->httpReponse;
	}
	
	public function nom()
	{
		return $this->nom;
	}
}