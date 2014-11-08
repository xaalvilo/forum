<?php
/**
* classe héritée de Field représentant un champ de formulaire sous forme de chaîne de caractère
*
*/

namespace Framework\Formulaire;

class StringField extends Field
{
	// longueur maximale du champ
	protected $maxLength;
	
	// taille du champ
	protected $size;
	
	/**
	* Méthode permettant de générer le code HTML pour un champ de chaîne de caractère
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
		
		//début du code HTML du champ avec le label, le type et le nom
		$widget.='<label for='.$this->id.'>'.$this->label.'</label><input type="text" name="'.$this->name.'" id="'.$this->id.'"';
		
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
		if(!empty($this->size))
		{
			$widget.='size="'.htmlspecialchars($this->size).'"';
		}
		//prise en compte de la longueur maximale, si elle existe
		if(!empty($this->maxlength))
		{
			$widget.='maxlength="'.htmlspecialchars($this->maxLength).'"';
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
	* setter de maxLength
	*/
	public function setMaxLength($maxLength)
	{
		$maxLength = (int) $maxLength;
		if($maxLength >0)
		{
			$this->maxLength=$maxLength;
		}
		else
		{
			throw new \Exception('la longueur maximale doit être un entier positif');
		}
	}
	
	/**
	* setter de size
	*/
	public function setSize($size)
	{
		$size = (int) $size;
		if($size >0)
		{
			$this->size=$size;
		}
		else
		{
			throw new \Exception('la longueur du champ doit être un entier positif');
		}
	}

}