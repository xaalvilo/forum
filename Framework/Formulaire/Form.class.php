<?php

/**
 *
 * @author Frédéric Tarreau
 *
 * 27 févr. 2015 - Form.class.php
 *
 * cette classe a pour rôle de représenter un formulaire composé d'une liste de champs
 *
 */
namespace Framework\Formulaire;

class Form
{
	/* objet instance d'une classe fille de Entité, auquel sera rattaché le formulaire  */
	protected $entite;

	/* methode associée au formulaire */
	protected $methode;

	/* action associée au formulaire */
	protected $action;

	/* @var array liste des fieldset du formulaire */
	protected $_fieldSets;

	/* liste des boutons sous forme de tableau */
	protected $buttons;

	/*liste des couples nom/valeur des champs valides sous forme de tableau associatif */
	protected $_validField;

	/* @var mixed valeur optionnelle à passer dans le formulaire */
	protected $value;

	public function __construct(\Framework\Entite $entite,$donnees)
	{
		$this->setEntite($entite);
		$this->hydrate($donnees);
	}

	/**
	 * Méthode hydrate
	 *
	 * cette méthode permet d'hydrater le champ avec les valeurs passées en paramètre au constructeur
	 *
	 * @param array $options
	 */
	public function hydrate($options)
	{
	    foreach($options as $type=>$value)
	    {
	        $method='set'.ucfirst($type);
	        if (is_callable(array($this,$method)))
	            $this->$method($value);
	    }
	}

	/**
	*
	* Méthode addFieldSet
	*
	* Méthode permettant d'ajouter des fieldsets au formulaire
	*
	* @param FieldSet à ajouter
	* @return Form nouveau formulaire
	*/
	public function addFieldSet(FieldSet $fieldSet)
	{
	    foreach ($fieldSet->fields() as $field)
	    {
	        // récupération du nom du champ
	        $attr=$field->name();

	        // assignation de la valeur correspondante au champ
	        $field->setValue($this->entite->$attr());
	    }
	    // ajout du fieldset à la liste des fieldsets
		$this->_fieldSets[]=$fieldSet;
		return $this;
	}

	/**
	 *
	 * Méthode addButton
	 *
	 * Cette méthode permet d'ajouter un bouton au formulaire
	 *
	 * @param Button $button
	 * @return \Framework\Formulaire\Form
	 */
	public function addButton(Button $button)
	{
	    // ajout du bouton passé en argument à la liste des boutons
	    $this->buttons[]=$button;

	    return $this;
	}

	/**
	 *
	 * Méthode baliseForm
	 *
	 * Cette méthode permet de créer les balises HTML 5 d'ouverture et de cloture d'un formulaire
	 *
	 * Remarque : l'utilisation des classes bootstrap CSS ici
	 *
	 * @param string $methode méthode associée au formulaire
	 * @param string $action action associée au formulaire
	 */
	public function baliseForm()
	{
	   if (isset($this->methode,$this->action))
	   {
	      $balise='<form class="form-horizontal" method="'.$this->methode.'" action="'.$this->action.'"><div class="form-group">';
	   }
	   else
	   {
	      $balise='<form class="form-horizontal"><div class="form-group">';
	   }
	   return $balise;
	}

	/**
	* Méthode createView
	*
	* permet de générer l'affichage de tous les champs associés au formulaire
	*
	* @return string View, portion de vue correspondant au formulaire c.a.d HTML
	*/
	public function createView()
	{
	    $view = $this->baliseForm();

	    foreach ($this->_fieldSets as $fieldSet)
	    {
	        // un fieldset avec une entrée est considéré comme un champ simple
	        if(count($this->_fieldSets)>0)
	            $view.=$fieldSet->buildWidget();

	        // g�n�ration pas � pas de chaque champ du formulaire
	        foreach($fieldSet->fields() as $field)
	        {
	            $view.=$field->buildWidget();
	        }

	       if(count($this->_fieldSets)>0)
	            $view.='</fieldset>';
	    }

	    // insertion des éventuels boutons du formulaire
	    if (!empty($this->buttons))
	    {
	        foreach($this->buttons as $button)
	        {
	            $view.=$button->buildWidget();
	        }
	    }

		// insertion de la balise de cloture du formulaire
		$view.='</div></form>';
		return $view;
	}

	/**
	* Méthode isValid
	*
	* Cette méthode permet d'acter que tous les champs du formulaire sont valides
	*
	* @return Boolean Vrai si le formulaire est valide, Faux sinon
	*/
	public function isValid()
	{
		$valid=true;

		//vérification pas à pas que les champs sont valides
		foreach($this->_fieldSets as $fieldSet)
		{
		    foreach($fieldSet->fields() as $field)
		    {
		        if (!$field->isValid())
		            $valid=false;
		        else
		            $this->_validField[$field->name()]=$field->value();
		    }
		}
		return $valid;
	}

	/**
	* setter de entite
	*/
	public function setEntite(\Framework\Entite $entite)
	{
		$this->entite=$entite;
	}

	/**
	* getter de entite
	*/
	public function entite()
	{
		return $this->entite;
	}

	/**
	 * setter de methode
	 *
	 * @param string
	 */
	public function setMethode($methode)
	{
	    if(is_string($methode))
	    {
	         $this->methode=$methode;
	    }
	}

	/**
	 *
	 * getter de methode
	 *
	 * @return string
	 */
	public function method()
	{
	    return $this->method;
	}

	/**
	 * setter de action
	 *
	 * @param string
	 */
	public function setAction($action)
	{
	    if(is_string($action))
	    {
	       $this->action=$action;
	    }
	}

	/**
	 * getter de action
	 *
	 * @return string
	 */
	public function action()
	{
	    return $this->action;
	}

	/**
	 * setter de value
	 *
	 * @param mixed
	 */
	public function setValue($value)
	{
	    $this->value=$value;
	}

	/**
	 *
	 * getter de value
	 *
	 * @return mixed
	 */
	public function value()
	{
	    return $this->value;
	}



	/**
	 * setter de validField
	 */
	public function setValidField($validField)
	{
	    $this->_validField=$validField;
    }

	/**
	 * getter de validField
	 */
	public function validField()
	{
	    return $this->_validField;
	}
}
