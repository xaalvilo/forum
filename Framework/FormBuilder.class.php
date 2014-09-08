<?php

namespace Framework;

/**
 *
 * @author Frédéric Tarreau
 *        
 *         Classe abstraire dont le rôle est la construction d'un formulaire
 *        
 */
abstract class FormBuilder 
{
	
	/* forumlaire à créer */
	protected $form;
	
	public function __construct(Entite $entity)
	{
		$this->setForm(new Form($entity));
	}
	
	abstract public function build();
	
	public function setForm($form)
	{
		$this->form = $form;
	}
	
	public function form() 
	{
		return $this->form;
	}
}
