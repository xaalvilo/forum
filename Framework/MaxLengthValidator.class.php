<?php
/**
* classe fille de Validator dont le rôle est de vérifer qu'une donnée entrée dans un champ de formulaire
* n'est pas nulle
*/

namespace Framework;

class MaxLengthValidator extends Validator
{
	// longueur maximale du champ
	protected $maxLength;
	
	public function __construct($errorMessage,$maxLength)
	{
		parent::__construct($errorMessage);
		
		$this->setMaxLength($maxLength);
	}
	
	public function isValid($value)
	{
		// calculer la taille de la chaîne et vérifier qu'elle est inférieure à la taille de chaîne maximale
		return strlen($value) <= $this->maxLength;
	}
	
	/**
	* setter de maxLength
	*/
	public function setMaxLength($maxLength)
	{
		$maxLength = (int) $maxLength;
		if($maxLength >0)
		{
			$this->maxLength=$maxLength;
		}
		else
		{
			throw new \Exception('la longueur maximale doit être un entier positif');
		}
	}
}