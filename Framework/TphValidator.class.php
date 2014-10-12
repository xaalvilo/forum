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
		return preg_match("#^0[1-68]([-. ]?[0-9]{2}){4}$#",$value);
	}
}