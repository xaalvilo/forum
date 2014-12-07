<?php
/**
 * 
 * @author Frédéric Tarreau
 *
 * 5 déc. 2014 - Validator.class.php
 * 
 * classe abstraite dont le rôle est de valider une donnée entrée dans un champ de formulaire
 * les classes filles seront propres à chaque type de donnée à valider
 * 
 */
namespace Framework\Formulaire;

abstract class Validator
{
	// message d'erreur
	protected $errorMessage;
	
	public function __construct($errorMessage)
	{
		$this->setErrorMessage($errorMessage);
	}
	
	/**
	 * 
	 * Méthode isValid
	 *
	 * méthode abstraite de validation des données du champ
	 * 
	 * @param unknown $value
	 * 
	 */
	abstract public function isValid($value);
	
	/**
	 * 
	 * Méthode setErrorMessage
	 *
	 * il s'agit du setter de l'attribut errorMessage
	 * 
	 * @param unknown $errorMessage
	 */
	public function setErrorMessage($errorMessage)
	{
		if (is_string($errorMessage))
		{
			$this->errorMessage=$errorMessage;
		}
	}
	
	/**
	 * 
	 * Méthode errorMessage
	 *
	 * il s'agit du getter de l'attribut errorMessage
	 * 
	 * @return string $errormessage attribut de la classe
	 */
	public function errorMessage()
	{
		return $this->errorMessage;
	}
}