<?php
namespace Applications\Frontend;
require_once './Framework/autoload.php';

class Frontend extends \Framework\Application
{
	public function __construct()
	{
		parent::__construct();
		$this->_nom = 'Backend';
	}
	
	public function run()
	{
		//recupération du routeur instancié lors la construction de l'application
		$routeur = $this->_routeur;
		
		// routage de la requ�te entrante par le routeur
		$routeur->routerRequete($this);
	}
}