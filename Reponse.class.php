<?php
namespace Framework;
require_once './Framework/autoload.php';

class Reponse extends ApplicationComponent
{
	protected $vue;
	
	/*
	 * permet de spécifier l'en-tête HTTP string lors de l'envoi des fichiers HTML
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
	* setcookie() définit un cookie qui sera envoyé avec le reste des en-têtes. Comme pour les autres en-têtes, 
	* les cookies doivent être envoyés avant toute autre sortie (c'est une restriction du protocole HTTP, pas de PHP).
	* Cela impose d'appeler cette fonction avant toute balise <html> ou <head>. 
	* @param string $nom  Le nom du cookie.
	* @param string $valeur La valeur du cookie. Cette valeur est stockée sur l'ordinateur du client  
	* @param number $expire Le temps après lequel le cookie expire.
	* @param string $path Le chemin sur le serveur sur lequel le cookie sera disponible
	* @param string $domain Le domaine pour lequel le cookie est disponible.
	* @param string $secure Indique si le cookie doit uniquement être transmis à travers une connexion sécurisée HTTPS depuis le client (si TRUE)
	* @param string $httpOnly Lorsque ce paramètre vaut TRUE, le cookie ne sera accessible que par le protocole HTTP. 
	* Cela signifie que le cookie ne sera pas accessible via des langages de scripts, comme Javascript
	*/
	public function setCookie($nom,$valeur='',$expire = 0,$path = null, $domain = null,$secure = FALSE,$httpOnly = TRUE)
	{
		setcookie($nom,$valeur,$expire,$path,$domain,$secure,$httpOnly);
	}
}