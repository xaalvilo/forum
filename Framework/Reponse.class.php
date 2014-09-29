<?php
namespace Framework;
require_once './Framework/autoload.php';

class Reponse extends ApplicationComponent
{
	protected $vue;
	
	/*
	 * permet de sp�cifier l'en-t�te HTTP string lors de l'envoi des fichiers HTML
	 */
	public function redirect($location)
	{
		header('Location: '.$location);
	}
	
	public function redirect404()
	{
		
	}
	
	public function send()
	{
		
	}
	
	public function setVue(Vue $vue)
	{
		
	}
	
	/**
	* setcookie() d�finit un cookie qui sera envoy� avec le reste des en-t�tes. Comme pour les autres en-t�tes, 
	* les cookies doivent �tre envoy�s avant toute autre sortie (c'est une restriction du protocole HTTP, pas de PHP).
	* Cela impose d'appeler cette fonction avant toute balise <html> ou <head>. 
	* @param string $nom  Le nom du cookie.
	* @param string $valeur La valeur du cookie. Cette valeur est stock�e sur l'ordinateur du client  
	* @param number $expire Le temps apr�s lequel le cookie expire.
	* @param string $path Le chemin sur le serveur sur lequel le cookie sera disponible
	* @param string $domain Le domaine pour lequel le cookie est disponible.
	* @param string $secure Indique si le cookie doit uniquement �tre transmis � travers une connexion s�curis�e HTTPS depuis le client (si TRUE)
	* @param string $httpOnly Lorsque ce param�tre vaut TRUE, le cookie ne sera accessible que par le protocole HTTP. 
	* Cela signifie que le cookie ne sera pas accessible via des langages de scripts, comme Javascript
	*/
	public function setCookie($nom,$valeur='',$expire = 0,$path = null, $domain = null,$secure = FALSE,$httpOnly = TRUE)
	{
		setcookie($nom,$valeur,$expire,$path,$domain,$secure,$httpOnly);
	}
}