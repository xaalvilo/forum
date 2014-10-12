<?php
/**
* classe fille de Validator dont le rôle est de vérifier qu'une donnée entrée dans un champ de formulaire
* n'est pas nulle
*/

namespace Framework;

class NotNullValidator extends Validator
{
	public function isValid($value)
	{
	    return $value!='';
	}
}