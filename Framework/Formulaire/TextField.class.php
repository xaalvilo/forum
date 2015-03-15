<?php
/**
* classe héritée de Field représentant un champ de formulaire sous forme de texte
*
*/

namespace Framework\Formulaire;

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
			$widget.=$this->errorMessage.'<br />';

		//début du code HTML du champ avec le label, le nom et l'id du champ
		$widget.='<div class="row">
		          <div class="form-group">';

		if(!empty($this->label))
		    $widget.='<label for='.$this->id.' class="col-xs-2 control-label">'.$this->label.'</label>';

		$widget.='<div class="col-xs-10">
		          <textarea name="'.$this->name.'" class="form-control" id="'.$this->id.'"';

		//prise en compte de la chaîne de caractère d'indication pour l'utilisateur, si elle existe
		if(!empty($this->placeholder))
			$widget.=' placeholder="'.htmlspecialchars($this->placeholder).'"';

		//s'il y a un nombre de colonnes, l'intégrer
		if(!empty($this->cols))
			$widget.=' cols="'.$this->cols.'"';

		//s'il y a un nombre de lignes, l'intégrer
		if(!empty($this->rows))
			$widget.=' rows="'.$this->rows.'"';

		if($this->required==true)
			$widget.=' required>';
		else
			$widget.='>';

		//s'il y a une valeur par défaut au champ,l'intégrer après l'avoir échappée. Rappel la valeur par défaut
		//d'un texte multiligne en html5 s'insère entre <textarea> et </textarea>, il n'y a pas de "value"
		if(!empty($this->value))
		   $widget.= htmlspecialchars($this->value);

		 $widget.='</textarea></div></div></div>';
		 return $widget;
	}

	/**
	* setter de rows
	*/
	public function setRows($rows)
	{
		$rows = (int)$rows;
		if($rows>0)
			$this->rows=$rows;
	}

	/**
	* setter de cols
	*/
	public function setCols($cols)
	{
		$cols = (int)$cols;
		if($cols>0)
			$this->cols=$cols;
	}
}