<?php

/**
 * cette classe repr�sente un visiteur du site. Elle a pour r�le d'enregistrer des informations
* temporaires le concernant et de g�rer ainsi la session de l'utilisateur
*/
Namespace Framework;

// d�s l'inclusion du fichier par l'auto_load, la session se cr��e
session_start();

class User extends ApplicationComponent
{

	/**
	 * cette m�thode permet d'assigner un attribut associ� � l'utilisateur
	 *
	 * @param &attribut attribut
	 * @param $valeur valeur de l'attribut
	 */
	public function setAttribute($attribut,$valeur)
	{
		$_SESSION[$attribut]=$valeur;
	}

	/**
	 * cette m�thode permet d'obtenir la valeur de l'attribut associ� � l'utilisateur
	 */
	public function getAttribute($attribut)
	{
		return isset($_SESSION[$attribut])? $_SESSION[$attribut]: NULL�;
	}

	/**
	 * cette m�thode permet de pr�ciser que l'utilisateur est bien authentifi�
	 */
	public function setAuthenticated($authenticated=true)
	{
		if(!is_bool($authenticated))
		{
			throw new \Exception ('la valeur sp�cifi�e � User�::authenticated doit �tre un bool�en');
		}
		$_SESSION['auth']=$authenticated;
	}
	/**
	 * cette m�thode permet de v�rifier que l'utilisateur est bien authentifi�
	 *
	 * @return Boolean
	 */
	public function isAuthenticated()
	{
		return isset($_SESSION['auth']) && $_SESSION['auth']=true�;
	}

	/**
	 * cette m�thode permet d'assigner un message ��flash�� informatif � l'utilisateur qui s'affichera sur
	 * la page
	 *
	 * @param string $valeur correspondant au texte du message
	 */
	public function setFlash($valeur)
	{
		$_SESSION['flash'] = $valeur�;
	}

	/**
	 * cette m�thode permet de r�cup�rer le message ��flash�� informatif  qui s'affichera sur
	 * la page de l'utilisateur
	 *
	 * @return string $flash correspondant au texte du message
	 */
	public function hasFlash()
	{
		return  isset($_SESSION['flash']);
	}

	/**
	 * cette m�thode permet de savoir si un message ��flash�� informatif  est associ� �
	 * l'utilisateur
	 *
	 * @return boolean
	 */
	public function getFlash()
	{
		$flash = $_SESSION['flash'];
		unset ($_SESSION['flash']);
		return $flash�;
	}
}
