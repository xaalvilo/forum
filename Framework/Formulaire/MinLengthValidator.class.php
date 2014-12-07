<?php
/**
 * 
 * @author Frédéric Tarreau
 *
 * 5 déc. 2014 - MinLengthValidator.class.php
 * 
 * classe fille de Validator dont le rôle est de vérifer qu'une donnée entrée dans un champ de formulaire  aune longueur minimale
 * requise dans le fichier de configuration
 *
 */

namespace Framework\Formulaire;

class MinLengthValidator extends Validator
{
	// longueur maximale du champ
	protected $_minLength;
	
	public function __construct($errorMessage,$minLength)
	{
		parent::__construct($errorMessage);
		
		$this->setMinLength($minLength);
	}
	
	/**
	 * 
	 * Méthode isValid
	 * 
	 * @see \Framework\Formulaire\Validator::isValid()
	 * 
	 */
	public function isValid($value)
	{
		// calculer la taille de la chaîne et vérifier qu'elle est supérieure ou égale à la taille de chaîne minimale
		return strlen($value) >= $this->_minLength;
	}
	
	/**
	 * 
	 * Méthode setMinLength
	 *
	 * il s'agit du setter de l'attribut minLength
	 * 
	 * @param int $minLength
	 * @throws \Exception
	 */
	public function setMinLength($minLength)
	{
		$minLength = (int) $minLength;
		if($minLength >0)
		{
			$this->_minLength=$minLength;
		}
		else
		{
			throw new \Exception('la longueur minimale doit être un entier positif');
		}
	}
	
	/**
	 * 
	 * Méthode minLength
	 * 
	 * il s'agit du getter de l'attribut minLength
	 *
	 * r@return int $_minLength
	 *
	 */
    public function minLength()
    {
        return $this->_minLength;
    }
}