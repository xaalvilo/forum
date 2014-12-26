<?php

/**
 * 
 * @author Fr�d�ric Tarreau
 *
 * 23 déc. 2014 - DateNaissanceValidator.class.php
 *
 * classe fille de Validator dont le r�le est de v�rifier qu'une donn�e entr�e dans un champ de formulaire
 * correspond à une date de la forme JJ/MM/ANNEE
 */
namespace Framework\Formulaire;

class DateNaissanceValidator extends Validator
{
	public function isValid($value)
	{
		return TRUE;
	}
}