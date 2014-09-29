<?php
/**
 * @author Frédéric Tarreau
 *
 * 28 sept. 2014 - file_name
 * 
 * Classe dont le rôle est de représenter un bouton de validation d'un formulaire. Elle prend en compte les champs cachés des données
 * "hidden" à envoyer sans saisie de l'utilisateur. *
 */
namespace Framework;

class Button
{
	
	
	// Nom de l'action associée
	protected $action;
	
	// type de bouton : submit, reset, image, button
	protected $type;
	
	//nom du champ caché "hidden"
	protected $hiddenName;
	
	// valeur associée au champ, hidden
	protected $hiddenValue;
	
	/**
	* Le constructeur demande la liste des attributs avec leur valeur 
	* 
	*/
	public function __construct($type,$action,$hiddenName,$hiddenValue)
	{
	   $this->setType($type);
	   $this->setAction($action);
		
	   if((!empty($hiddenName))&&(!empty($hiddenValue)))
	   {
		  $this->setHiddenName($hiddenName);
	      $this->setHiddenValue($hiddenValue);		 
	   }
	}
	
	/**
	 * 
	 * Méthode permettant de construire le bouton en HTML5
	 *
	 * return_type
	 *
	 */
	public function buildWidget()
	{
	  $widget='';
	      
      // s'il faut transférer des données cachés, créer le champ de type "hidden"
      if(isset($this->hiddenName,$this->hiddenValue))
	  {
	      $widget.='<input type="hidden" name="'.$this->hiddenName.'" value="'.$this->hiddenValue.'"/>';
	  }
	  
	  $widget.='<input type="'.$this->type.'" value="'.$this->action.'"/>';
	  return $widget;
	}
	
	/**
	* Getter de "action"
	*/
	public function action()
	{
	    return $this->action;
	}
		
	/**
	 * getter de hiddenName
	 */
	public function hiddenName()
	{
	    return $this->hiddenName;
	}
	
	/**
	* getter de hiddenValue
	*/
	public function hiddenValue()
	{
		return $this->hiddenValue;
	}
	
	/**
	* getter de type
	*/
	public function type()
	{
		return $this->type;
	}
			
	/**
	* setter de "type"
	*/
	public function setType($type)
	{
		if(is_string($type))
		{
	       $this->type=$type;
		}
	}
	
	/**
	 * setter de hiddenName
	 */
	public function setHiddenName($hiddenName)
	{
	    if(is_string($hiddenName))
	    {
	        $this->hiddenName=$hiddenName;
	    }
	}
	
	/**
	* setter de hiddenValue
	*/
	public function setHiddenValue($hiddenValue)
	{
	    $this->hiddenValue=$hiddenValue;
	}
		
	/**
	* setter de "action"
	*/
	public function setAction($action)
	{
		if(is_string($action))
		{
	       $this->action=$action;
		}
	}	
}