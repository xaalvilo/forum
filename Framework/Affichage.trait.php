<?php 
namespace Framework;

trait Affichage
{	
	/**
	 * Méthode setHeureDateLocale
	 *
	 * Cette méthode utilise la fonction setlocale() qui sera associée à strftime() dans le fichier HTML de la vue spécifique (index.php)
	 * elle est appelée par exemple par tous les managers après l'extraction d'une date d'une BDD
	 *
	 */
	public function setHeureDateLocale()
	{
		$langueDate = \Framework\Configuration::get("langueDateWindows","fra_fra");
		if (!setlocale(LC_TIME, $langueDate))
		{
			$langueDate = \Framework\Configuration::get("langueDateMac","fra_fra");
			setlocale(LC_TIME, $langueDate);
		}
	}
}