<?php
/**
 * 
 * @author Frédéric Tarreau
 *
 * 18 sept. 2014 - file_name
 * 
 * Classe abstraire dont le r�le est la construction d'un formulaire
 *        
 */
namespace Framework\Formulaire;

abstract class FormBuilder 
{
	/* formulaire � cr�er */
	protected $form;
	
	/** 
	 * Méthode constructeur
	 *
	 * @param Entite $entity
	 */
	public function __construct(\Framework\Entite $entite,$method,$action)
	{
		$this->setForm(new Form($entite,$method,$action));
	}
	
	/**
	 * 
	 * Méthode abstraite build
	 *
	 * permet de construire le formulaire , ses champs et ses boutons
	 *
	 */
	abstract public function build();
	
	/**
	 * 
	 * Setter
	 *
	 * return_type
	 * 
	 * @param unknown $form
	 * @return Form
	 */
	public function setForm($form)
	{
		$this->form = $form;
	}
	
	/**
	 * 
	 * Getter
	 * 
	 * @return Form  
	 */
	public function form() 
	{
		return $this->form;
	}
	
}
