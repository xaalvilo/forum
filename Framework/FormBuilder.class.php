<?php

namespace Framework;

/**
 *
 * @author Fr�d�ric Tarreau
 *        
 *         Classe abstraire dont le r�le est la construction d'un formulaire
 *        
 */
abstract class FormBuilder 
{
	
	/* forumlaire � cr�er */
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
