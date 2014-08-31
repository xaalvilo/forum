<?php

/**
 * cette classe reprŽsente un visiteur du site. Elle a pour r™le d'enregistrer des informations
* temporaires le concernant et de gŽrer ainsi la session de l'utilisateur
*/
Namespace Framework;

// ds l'inclusion du fichier par l'auto_load, la session se crŽŽe
session_start();

class User extends ApplicationComponent
{

	/**
	 * cette mŽthode permet d'assigner un attribut associŽ ˆ l'utilisateur
	 *
	 * @param &attribut attribut
	 * @param $valeur valeur de l'attribut
	 */
	public function setAttribute($attribut,$valeur)
	{
		$_SESSION[$attribut]=$valeur;
	}

	/**
	 * cette mŽthode permet d'obtenir la valeur de l'attribut associŽ ˆ l'utilisateur
	 */
	public function getAttribute($attribut)
	{
		return isset($_SESSION[$attribut])? $_SESSION[$attribut]: NULLÊ;
	}

	/**
	 * cette mŽthode permet de prŽciser que l'utilisateur est bien authentifiŽ
	 */
	public function setAuthenticated($authenticated=true)
	{
		if(!is_bool($authenticated))
		{
			throw new \Exception ('la valeur spŽcifiŽe ˆ UserÊ::authenticated doit tre un boolŽen');
		}
		$_SESSION['auth']=$authenticated;
	}
	/**
	 * cette mŽthode permet de vŽrifier que l'utilisateur est bien authentifiŽ
	 *
	 * @return Boolean
	 */
	public function isAuthenticated()
	{
		return isset($_SESSION['auth']) && $_SESSION['auth']=trueÊ;
	}

	/**
	 * cette mŽthode permet d'assigner un message ÇÊflashÊÈ informatif ˆ l'utilisateur qui s'affichera sur
	 * la page
	 *
	 * @param string $valeur correspondant au texte du message
	 */
	public function setFlash($valeur)
	{
		$_SESSION['flash'] = $valeurÊ;
	}

	/**
	 * cette mŽthode permet de rŽcupŽrer le message ÇÊflashÊÈ informatif  qui s'affichera sur
	 * la page de l'utilisateur
	 *
	 * @return string $flash correspondant au texte du message
	 */
	public function hasFlash()
	{
		return  isset($_SESSION['flash']);
	}

	/**
	 * cette mŽthode permet de savoir si un message ÇÊflashÊÈ informatif  est associŽ ˆ
	 * l'utilisateur
	 *
	 * @return boolean
	 */
	public function getFlash()
	{
		$flash = $_SESSION['flash'];
		unset ($_SESSION['flash']);
		return $flashÊ;
	}
}
