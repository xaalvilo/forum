<?php
/**
* classe héritée de Field représentant un champ de formulaire sous forme de texte
*
*/

namespace Framework;

class  TextField extends Field
{
	// nombre de colonnes du champ Text
	protected $cols;
	
	// nombre de lignes du champ Text
	protected $rows;
	
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
		
		//début du code HTML du champ avec le label, le nom et l'id du champ
		$widget.='<label for='.$this->id.'>'.$this->label.'</label><textarea name="'.$this->name.' "id="'.$this->id.'"';
		
		
		//prise en compte de la chaîne de caractère d'indication pour l'utilisateur, si elle existe
		if(!empty($this->placeholder))
		{
			$widget.='placeholder="'.htmlspecialchars($this->placeholder).'"';
		}
		
		//s'il y a un nombre de colonnes, l'intégrer
		if(!empty($this->cols))
		{
			$widget.='cols="'.$this->cols.'"';
		}
		
		//s'il y a un nombre de lignes, l'intégrer
		if(!empty($this->rows))
		{
			$widget.='rows="'.$this->rows.'"';
		}
		
		//s'il y a une valeur par défaut au champ,l'intégrer après l'avoir échappée
		if(!empty($this->value))
		{
			$widget.='value="'.htmlspecialchars($this->value.'"');
		}
		
		if($this->required==true)
		{
			return $widget.='required </textarea>';
		}
		else
		{
			return $widget.='</textarea>';
		}
	}
	/**
	* setter de rows
	*/
	public function setRows($rows)
	{
		$rows = (int)$rows;
		if($rows>0)
		{
			$this->rows=$rows;
		}
	}
	/**
	* setter de cols
	*/
	public function setCols($cols)
	{
		$cols = (int)$cols;
		if($cols>0)
		{
			$this->cols=$cols;
		}
	}
}