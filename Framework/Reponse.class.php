<?php
/**
 * 
 * @author Frédéric Tarreau
 *
 * 3 oct. 2014 - Reponse.class.php
 * 
 * Cette classe héritée de ApplicationComponent représente la réponse HTTP envoyée au client. Elle a pour rôle d'assigner une vue
 * à la réponse, de rediriger l'utilisateur en cas d'erreur,  d'ajouter un header spéciifique
 *
 */
namespace Framework;
require_once './Framework/autoload.php';

class Reponse extends ApplicationComponent
{
	/* objet page retournée à l'utilisateur avec l'objet réponse */
    protected $_page;
    
    /* nom du cookie */
    protected $_nomCookie;    
	
	/**
	 * 
	 * Méthode redirect
	 * 
	 * Cette méthode permet de rediriger l'utilisateur et de sp�cifier l'en-t�te HTTP string
	 * lors de l'envoi des fichiers HTML
	 * 
	 * @param string $location
	 * 
	 */
	public function redirect($location)
	{
		header('Location:'.$location);
		exit;
	}
	
	/**
	 * 
	 * Méthode redirect404
	 *
	 * Cette méthode permet de rediriger l'utilisateur vers une erreur 404
	 * 
	 * return_type
	 *
	 */
	public function redirect404()
	{
		// cette erreur arrive avant qu'un objet Page ne soit instancié par le controleur (dans la méthode genererVue()
		// il faut donc le faire ... moins que cela ne génére uen exception dans le try/catch du controleur frontal
	    $this->_page = new Page($this->_app,'erreur');
        $this->_page->generer(array('msgErreur'=>$exception->getMessage()));
		//$this->page->setContentFile(__DIR__.'/../Errors/404.html');
		//$this->addHeader('HTTP/1.0 404 Not Found');
		//$this->send();			
	}
	
	/**
	 * 
	 * Méthode send
	 * 
	 * cette méthode appelée par le controleur permet d'envoyer la page de réponse 
	 * 
	 */
	public function send($vue)
	{
		echo $vue;
		
	}
	
	/**
	 * 
	 * Méthode setPage
	 * 
	 * Setter de l'attribut $_vue
	 *
	 * return_type
	 * 
	 * @param Page $page
	 * 
	 */
	public function setPage(Page $page)
	{
		$this->_page = $page;		
	}
	
	
	/**
	 * 
	 * Méthode addHeader
	 * 
	 * Cette méthode permet d'ajouter un header spécifique
	 * 
	 * @ param string $header
	 * 
	 */
	 public function addHeader($header)
	 {
	     redirect($header);	    
	 }
}