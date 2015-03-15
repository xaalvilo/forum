<?php
/**
 * @author Frédéric Tarreau
 *
 * 4 oct. 2014 - TextValidator.class.php
 *
 * classe fille de Validator dont le rôle est de vérifier qu'une donnée entrée dans un champ de formulaire
 * correspond à une chaine de caractère
 */
namespace Framework\Formulaire;

class TextValidator extends Validator
{
	/**
	 *
	 * Méthode isValid
	 *
	 * Cette vérifie à l'aide d'une expression regulière et de la fonction filter_var() de PHP, que la valeur transmise ne contient
	 * que des lettres ou des chiffres
	 *
	 * @see \Framework\Validator::isValid()
	 * @return boolean TRUE si valide, FALSE sinon
	 */
	public function isValid($value)
	{
	    //TODO TEST ICI
	    return true;
	}
}