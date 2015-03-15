<?php
/**
* classe héritée de Field représentant un champ de formulaire sous forme de chaîne de caractère
*
*/

namespace Framework\Formulaire;

class InputField extends Field
{
	/*longueur maximale du champ*/
	protected $maxLength;

	/* taille du champ */
	protected $size;

	/* type du champ input */
	protected $_type;

	/* pattern du champ */
	protected $_pattern;

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

		//début du code HTML du champ avec le label, le type et le nom
		$widget.='<div class="row">
		          <div class="form-group">
		          <label for="'.$this->id.'" class="col-xs-2 control-label">'.$this->label.'</label>
		          <div class="col-xs-10">
		          <input type="'.$this->_type.'" class="form-control" name="'.$this->name.'" id="'.$this->id.'"';

		// s'il y a une valeur, échapper les caractères HTML
		if(!empty($this->value))
			$widget.=' value="'.htmlspecialchars($this->value).'"';

		//prise en compte de la chaîne de caractère d'indication pour l'utilisateur, si elle existe
		if(!empty($this->placeholder))
			$widget.=' placeholder="'.htmlspecialchars($this->placeholder).'"';

		//prise en compte de la taille du champ, si elle existe
		if(!empty($this->size))
			$widget.='size="'.htmlspecialchars($this->size).'"';

		//prise en compte de la longueur maximale, si elle existe
		if(!empty($this->maxlength))
			$widget.='maxlength="'.htmlspecialchars($this->maxLength).'"';

		//prise en compte du pattern si il existe
		if(!empty($this->_pattern))
		    $widget.='pattern="'.$this->_pattern.'"';

		if($this->required==true)
			$widget.=' required />';
		else
			$widget.=' />';

		$widget.='</div></div></div>';
		return $widget;
	}

	/**
	* setter de maxLength
	*/
	public function setMaxLength($maxLength)
	{
		$maxLength = (int) $maxLength;
		if($maxLength >0)
			$this->maxLength=$maxLength;
		else
			throw new \Exception('la longueur maximale doit être un entier positif');
	}

	/**
	* setter de size
	*/
	public function setSize($size)
	{
		$size = (int) $size;
		if($size >0)
			$this->size=$size;
		else
			throw new \Exception('la longueur du champ doit être un entier positif');
	}

    /**
     *
     * Méthode setType
     *
     * Il s'agit du setter de l'attribut type. Il doit vérifier que le type correspond à une des types
     * de l'élément <input> de HTML5
     *
     * @param string $type
     */
	public function setType($type)
	{
	    $valeurAutoriseeHTML5 = array ('text', 'password', 'hidden', 'radio', 'checkbox', 'reset', 'submit', 'image', 'file', 'tel',
	                                   'url', 'email','search','date','time', 'datetime', 'datetime-local', 'month,week',
	                                   'number','range','color');

	    if (in_array($type,$valeurAutoriseeHTML5,TRUE))
	       $this->_type=$type;
	    else
	          throw new \Exception('le type n\'existe pas dans HTML5');
	}

	/**
	 *
	 * Méthode type
	 *
	 * il s'agit du getter de type
	 *
	 * @return string $_type
	 *
	 */
	public function type()
	{
	    return $this->_type;
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
	public function setPattern($pattern)
	{
	    if(is_string($pattern))
	        $this->_pattern=$pattern;
	    else
	        throw new \Exception('le pattern n\'est pas valide');
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
}