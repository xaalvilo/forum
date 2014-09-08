<?php
/**
 * classe fille de Validator dont le rôle est de vérifier qu'une donnée entrée dans un champ de formulaire
 * correspond � une adresse email
 */

namespace Framework;

class MailValidator extends Validator
{
	public function isValid($value)
	{
		/* expression reguliere acceptant une adresse email */
		return preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#",$value);
	}
}