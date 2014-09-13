<?php
namespace Framework;
/**
 * 
 * @author Frédéric Tarreau
 *
 * 11 sept. 2014 - file_name
 *
 * classe fille de Validator dont le rôle est de vérifier qu'une donnée entrée dans un champ de formulaire
 * correspond à un numéro de téléphone à 10 chiffres en France
 */


class TphValidator extends Validator
{
	public function isValid($value)
	{
		/* expression reguliere acceptant un numero de téléphone à 10 chiffres en France */
		return preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#",$value);
	}
}