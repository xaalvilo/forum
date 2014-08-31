<?php
/**
 *  cette classe abstraite se charge de stocker l'instance de l'application ex�cut�e. Elle permet ainsi d'obternir l'application 
 *  � laquelle l'objet appartient
 * 
 */
namespace Framework ;
require_once './Framework/autoload.php';

abstract class ApplicationComponent
{
	/*
	 * instance de l'application ex�cut�e
	 */
	protected $app;
	
	public function __construct(Application $app)
	{
		$this->app = $app;
	}
	
	public function app()
	{
		return $this->app;
	}
}