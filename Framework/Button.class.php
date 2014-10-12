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
	protected $_action;
	
	// type de bouton : submit, reset, image, button
	protected $_type;
	
	//nom du champ caché "hidden"
	protected $_hiddenName;
	
	// valeur associée au champ, hidden
	protected $_hiddenValue;
	
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
      if(isset($this->_hiddenName,$this->_hiddenValue))
	  {
	      $widget.='<input type="hidden" name="'.$this->_hiddenName.'" value="'.$this->_hiddenValue.'"/>';
	  }
	  
	  $widget.='<input type="'.$this->_type.'" value="'.$this->_action.'"/>';
	  return $widget;
	}
	
	/**
	* Getter de "action"
	*/
	public function action()
	{
	    return $this->_action;
	}
		
	/**
	 * getter de hiddenName
	 */
	public function hiddenName()
	{
	    return $this->_hiddenName;
	}
	
	/**
	* getter de hiddenValue
	*/
	public function hiddenValue()
	{
		return $this->_hiddenValue;
	}
	
	/**
	* getter de type
	*/
	public function type()
	{
		return $this->_type;
	}
			
	/**
	* setter de "type"
	*/
	public function setType($type)
	{
		if(is_string($type))
		{
	       $this->_type=$type;
		}
	}
	
	/**
	 * setter de hiddenName
	 */
	public function setHiddenName($hiddenName)
	{
	    if(is_string($hiddenName))
	    {
	        $this->_hiddenName=$hiddenName;
	    }
	}
	
	/**
	* setter de hiddenValue
	*/
	public function setHiddenValue($hiddenValue)
	{
	    $this->_hiddenValue=$hiddenValue;
	}
		
	/**
	* setter de "action"
	*/
	public function setAction($action)
	{
		if(is_string($action))
		{
	       $this->_action=$action;
		}
	}	
}