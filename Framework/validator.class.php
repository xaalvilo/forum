<?php
/**
* classe abstraite dont le rôle est de valider une donnée entrée dans un champ de formulaire
* les classes filles seront propres à chaque type de donnée à valider
*/

namespace Framework;

abstract class Validator
{
	// message d'erreur
	protected $errorMessage;
	
	public function __construct($errorMessage)
	{
		$this->setErrorMessage($errorMessage);
	}
	
	
	/*
	* Méthode abstraite de validation d'une donnée dans un champ
	*/
	abstract public function isValid($value);
	
	/*
	* setter de errorMessage
	*/
	public function setErrorMessage($errorMessage)
	{
		if (is_string($errorMessage))
		{
			$this->errorMessage=$errorMessage;
		}
	}
	
	/*
	* getter de errorMessage
	*/
	public function errorMessage()
	{
		return $this->errorMessage;
	}
}