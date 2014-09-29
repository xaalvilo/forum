<?php
/**
 * 
 * @author Frédéric Tarreau
 *
 * 18 sept. 2014 - file_name
 * 
 * classe fille de Validator dont le rôle est de vérifier qu'une donnée entrée dans un champ de formulaire
 * correspond � une adresse email
 *
 */
namespace Framework;

class MailValidator extends Validator
{
	/**
	 * 
	 * @see \Framework\Validator::isValid()
	 * @return 
	 */
	public function isValid($value)
	{
		/* expression reguliere acceptant une adresse email */
		return preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#",$value);
	}		
}