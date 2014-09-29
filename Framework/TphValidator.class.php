<?php
namespace Framework;
/**
 * 
 * @author Fr�d�ric Tarreau
 *
 * 11 sept. 2014 - file_name
 *
 * classe fille de Validator dont le r�le est de v�rifier qu'une donn�e entr�e dans un champ de formulaire
 * correspond � un num�ro de t�l�phone � 10 chiffres en France
 */


class TphValidator extends Validator
{
	public function isValid($value)
	{
		/* expression reguliere acceptant un numero de t�l�phone � 10 chiffres en France */
		return preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#",$value);
	}
}