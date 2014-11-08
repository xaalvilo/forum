<?php

/** 
* cette classe a pour rôle de représenter un formulaire composé d'une liste de champs
*
*/

namespace Framework\Formulaire;

class Form
{
	/* objet instance d'une classe fille de Entité, auquel sera rattaché le formulaire  */
	protected $entite;
	
	/* methode associée au formulaire */
	protected $method;
	
	/* action associée au formulaire */
	protected $action;
	
	/* liste des champs sous forme de tableau */
	protected $fields;
	
	/* liste des boutons sous forme de tableau */
	protected $buttons;
	
	/*liste des couples nom/valeur des champs valides sous forme de tableau associatif */
	protected $_validField;
	
	public function __construct(\Framework\Entite $entite,$method,$action)
	{
		$this->setEntite($entite);	
		
		if((!empty($method))&&(!empty($action)))
		{
		  $this->setMethod($method);
		  $this->setAction($action);
		}
	}
	
	/**
	* 
	* Méthode add
	* 
	* Méthode permettant d'ajouter des champs au formulaire
	* 
	* @param Field champs à ajouter
	* @return Form nouveau formulaire
	*/
	public function add(Field $field)
	{
		// récupération du nom du champ
		$attr=$field->name();
		
		// assignation de la valeur correspondante au champ
		$field->setValue($this->entite->$attr());
		
		// ajout du champ passé en argument à la liste de champs
		$this->fields[]=$field;
		
		return $this;
	}
	
	/**
	 * 
	 * Méthode addButton
	 * 
	 * Cette méthode permet d'ajouter un bouton au formulaire
	 *
	 * \Framework\Form
	 * 
	 * @param Button $button
	 * @return \Framework\Form
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
	 * return_type string
	 * 
	 * @param string $method méthode associée au formulaire
	 * @param string $action action associée au formulaire
	 */
	public function baliseForm()
	{
	   if (isset($this->method,$this->action))
	   {
	      $balise='<form method="'.$this->method.'" action="'.$this->action.'"><p>';
	   }
	   else
	   {
	      $balise ='<form><p>';
	   }
	   return $balise;
	}
	
	/**
	* Méthode permettant de générer l'affichage de tous les champs associés au formulaire
	*
	* @return string View, portion de vue correspondant au formulaire c.a.d HTML
	*/
	public function createView()
	{
	    $view = $this->baliseForm();
		
		// g�n�ration pas � pas de chaque champ du formulaire
		foreach($this->fields as $field)
		{
			$view.=$field->buildWidget().'<br />';
		}	
		
		// insertion des éventuels boutons du formulaire
		if (!empty($this->buttons))
		{		   
		    foreach($this->buttons as $button)
		    {
		        $view.=$button->buildWidget().'<br />';
		    }
		}
		
		// insertion de la balise de cloture du formulaire
		$view.='</p></form>';
				
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
		foreach($this->fields as $field)
		{
			if (!$field->isValid())
			{
				$valid=false;
			}
			else 
			{
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
	 * setter de method
	 */
	public function setMethod($method)
	{
	    if(is_string($method))
	    {
	         $this->method=$method;
	    }	   
	}
	
	/**
	 * 
	 * getter de method
	 *
	 * return_type
	 *
	 */
	public function method()
	{
	    return $this->method;
	}
	
	/**
	 * setter de action
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
	 */
	public function action()
	{
	    return $this->action;
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
	