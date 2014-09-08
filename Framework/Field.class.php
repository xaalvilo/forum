<?php
/**
* classe abstraite dont le rôle est de représenter un champ de formulaire
*
*/

namespace Framework;

abstract class Field
{
	// label HTML du champ
	protected $label;
	
	// Nom HTML du champ
	protected $name;
	
	// valeur par d�faut HTML du champ
	protected $value;
	
	// id du champ, permettant en HTML de li� le champ à son nom
	protected $id;
	
	// message d'erreur associ� au champ
	protected $errorMessage;
	
	//tableau des validateurs
	protected $validators = array();
	
	// indication pour remplir le champ
	protected $placeholder;
	
	// indication HTML de champ obligatoire
	protected $required;
	
	/**
	* Le constructeur  demande la liste des attributs avec leur valeur afin d'hydrater l'objet
	*
	* @param array options correspondant à la liste des attributs avec leur valeur
	*/
	public function __construct(array $options=array())
	{
		if(!empty($options))
		{
			$this->hydrate($options);
		}
	}
	
	/**
	* Méthode abstraite à implémenter par les classes filles permettant de construire le code HTML de chaque champ
	*/
	abstract public function buildWidget() ;
	
	/**
	* Méthode permettant d'hydrater le champ avec les valeurs passées en paramètre au constructeur
	*
	* @param array options
	*/
	public function hydrate($options)
	{
		foreach($options as $type->$value)
		{
			$method='set'.ucfirst($type);
			if (is_callable(array($this,$method)))
			{
				$this->method($value);
			}
		}
	}
	
	/**
	* Méthode permettant d'acter que la valeur d'un champ est valide
	*
	*@return boolean Vrai si le champ est valide
	*/
	public function isValid()
	{
		foreach ($this->validators as $validator)
		{
			if (!$validator->isValid($this->value))
			{
				$this->errorMessage = $validator->errorMessage();
				return FALSE;
			}
			return TRUE;
		}
	}
	
	/**
	* getter de label
	*/
	public function label()
	{
		return $this->label;
	}
	
	/**
	* getter de name
	*/
	public function name()
	{
		return $this->name;
	}
	
	/**
	* getter de value
	*/
	public function value()
	{
		return $this->value;
	}
	
	/**
	* getter de l'id
	*/
	public function id()
	{
		return $this->id;
	}
	
	/**
	 * getter de validators
	 */
	public function validators()
	{
		return $this->validators;
	}
	
	/**
	 * getter de placeholder
	 */
	public function placeholder()
	{
		return $this->placeholder;
	}
	
	/**  
	 * getter de required
	 */
	public function required()
	{
		return $this->required;
	}
	/**
	 * setter de validators
	 * 
	 * @param array $validators
	 */
	public function setValidators(array $validators)
	{
		foreach ($validators as $validator)
		{
			if ($validator instanceof Validator && !in_array($validator,
					$this->validators))
			{
				$this->validators[] = $validator;
			}
		}
	}
	
	/**
	* setter de label
	*/
	public function setLabel($label)
	{
		$this->label=$label;
	}
	/**
	* setter de name
	*/
	public function setName($name)
	{
		$this->name=$name;
	}
	
	/**
	* setter de value
	*/
	public function setValue($value)
	{
		$this->value=$value;
	}
	
	/**
	* setter de l'id
	*/
	public function setId($id)
	{
		$this->id=$id;
	}
	/**
	 * setter de placeholder
	 */
	public function setPlaceholder($placeholder)
	{
		$this->placeholder=$placeholder;
	}
	
	/**
	 * 
	 * Setter de required
	 * 
	 * @param unknown $required
	 */
	public function setRequired($required)
	{
		$this->required = $required;
	}
}