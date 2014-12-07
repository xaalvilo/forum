<?php
/**
 * 
 * @author Frédéric Tarreau
 *
 * 05 déc. 2014 - PasswordValidator.class.php
 * 
 * classe fille de Validator dont le rôle est de vérifier qu'une donnée entrée dans un champ de password
 * correspond au type de password souhaité
 *
 */
namespace Framework\Formulaire;

class PasswordValidator extends Validator
{
	/**
	 * 
	 * Méthode isValid
	 * 
	 * @see \Framework\Validator::isValid()
	 * @return boolean TRUE si valide, FALSE sinon
	 */
	public function isValid($value)
	{
		/* expression reguliere acceptant un password de la forme XXXXXXXXX */
		return TRUE;
	}		
}