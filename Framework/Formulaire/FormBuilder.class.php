<?php
/**
 *
 * @author Frédéric Tarreau
 *
 * 18 sept. 2014 - FormBuilder.class.php
 *
 * Classe abstraire dont le r�le est la construction d'un formulaire
 *
 */
namespace Framework\Formulaire;

abstract class FormBuilder
{
    /* constante type de formulaire */
    CONST LONG=1;
    CONST COURT=2;

	/* @var formulaire � cr�er */
	protected $form;

	/**
	 * Constructeur
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
	 * @param int $type précisant un type de formulaire à construire (ex : long, court...)
	 *
	 */
	abstract public function build($type = NULL);

	/**
	 *
	 * Setter
	 *
	 * return_type
	 *
	 * @param unknown $form
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
