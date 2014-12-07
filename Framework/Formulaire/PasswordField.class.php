<?php
namespace Framework\Formulaire;
/**
 * 
 * @author Frédéric Tarreau
 *
 * 5 déc. 2014 - PasswordField.class.php
 * 
 * cette classe héritée de la classe abstraite Field représente un champ de saisie de password
 *
 */
class PasswordField extends Field
{
	// taille du champ
	protected $_size;
	
	// pattern du champ définissant la taille mini et maxi de la chaîne saisie
	protected $_pattern;	
	
	/**
	* Méthode buildWidget
	* 
	* Elle permettet de générer le code HTML pour un champ de chaîne de caractère
	* 
	* @return string $widget suite de caractère correspondant au code HTML
	*
	*/
	public function buildWidget()
	{
		$widget='';
		
		// affichage du message d'erreur lié au champ
		if (!empty($this->errorMessage))
		{
			$widget.=$this->errorMessage.'<br />';
		}
		
		//début du code HTML du champ avec le label, le type "password" et le nom
		$widget.='<label for='.$this->id.'>'.$this->label.'</label><input type="password " name="'.$this->name.'" id="'.$this->id.'"';
		
		// s'il y a une valeur, échapper les caractères HTML
		if(!empty($this->value))
		{
			$widget.=' value="'.htmlspecialchars($this->value).'"';
		}
		
		//prise en compte de la chaîne de caractère d'indication pour l'utilisateur, si elle existe
		if(!empty($this->placeholder))
		{
			$widget.=' placeholder="'.htmlspecialchars($this->placeholder).'"';
		}
		
		//prise en compte de la taille du champ, si elle existe
		if(!empty($this->_size))
		{
			$widget.='size="'.htmlspecialchars($this->_size).'"';
		}
		//prise en compte de la longueur maximale, si elle existe
		if(!empty($this->_pattern))
		{
			$widget.='pattern="'.$this->_pattern;
		}
		
		if($this->required==true)
		{
			return $widget.=' required />';
		}
		else
		{
			return $widget.=' />';
		}
	}
	
	/**
	 * 
	 * Méthode setPattern
	 *
	 * il s'agit du setter de l'attribut pattern
	 * 
	 * @param string $pattern
	 * 
	 */
	public function setMaxLength($pattern)
	{
		if(is_string($pattern))
		{
			$this->_pattern=$pattern;
		}
		else
		{
			throw new \Exception('le pattern est une chaîne de caractère spécifique de la forme .{5,10}');
		}
	}
	
	/**
	 * 
	 * Méthode pattern
	 *
	 * il s'agit du getter de l'attribut pattern
	 * 
	 * @return string $_pattern , attribut de la classe
	 */
	public function pattern()
	{
	    return $this->_pattern;
	}
	
	/**
	 * 
	 * Méthode setSize
	 *
	 * il s'agit du setter de l'attribut size
	 * 
	 * @param int $size
	 * @throws \Exception
	 */
	public function setSize($size)
	{
		$size = (int) $size;
		if($size >0)
		{
			$this->_size=$size;
		}
		else
		{
			throw new \Exception('la longueur du champ doit être un entier positif');
		}
	}
	
	/**
	 * 
	 * Méthode size
	 *
	 * il s'agit du getter de l'attribut size
	 * 
	 * @return int $_size, attribut de la classe
	 */
	public function size()
	{
	    return $this->_size;
	}

}