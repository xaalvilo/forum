<?php
namespace Application;
require_once './Framework/autoload.php';

class Frontend extends \Framework\Application
{
	public function __construct()
	{
		parent::__construct();
		$this->_nom = 'Frontend';
	}
	
	public function run()
	{
		//instanciation d'un Routeur - controleur frontal
		$routeur = new \Framework\Routeur();
		
		// routage de la requ�te entrante par le routeur
		$routeur->routerRequete($this);
	}
}