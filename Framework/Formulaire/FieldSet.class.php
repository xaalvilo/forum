<?php
/**
 *
 * @author Frédéric Tarreau
 *
 * 27 févr. 2015 - FieldSet.class.php
 *
 * classe abstraite dont le rôle est de représenter un Fieldset regroupant des champs de formulaire
 */
namespace Framework\Formulaire;

class FieldSet
{
	/* @var string legende du fieldset HTML5 */
    protected $_legend;

    /* @var array liste des champs du fieldset */
    protected $_fields;

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
	 * Méthode addField
	 *
	 * Méthode permettant d'ajouter des champs au fieldset
	 *
	 * @param Field à ajouter
	 * @return FieldSet
	 */
	public function addField(Field $field)
	{
	    $this->_fields[]=$field;
	    return $this;
	}

	/**
	 *
	 * Méthode buildWidget
	 *
	 * Permet de générer les balises HTML correspondant à un fieldset
	 *
	 *@return string chaîne de code HTML
	 */
	public function buildWidget()
	{
	    $widget='<fieldset>';

	    // une legende est spécifiée
	    if(!empty($this->_legend))
	        $widget.='<legend>'.$this->_legend.'</legend>';
	    return $widget;
	}

	/**
	 *
	 * Méthode fields
	 *
	 * getter de l'attribut protégé fields
	 *
	 * @return array fields liste de champs de formulaire
	 *
	 */
	public function fields()
	{
	    return $this->_fields;
	}

	/**
	 *
	 * Méthode legend
	 *
	 * getter de l'attribut protégé legend
	 *
	 * @return string
	 */
	public function legend()
	{
		return $this->_legend;
	}

	/**
	 *
	 * Méthode setLegend
	 *
	 * @param string $legend
	 */
	public function setLegend($legend)
	{
		$this->_legend=$legend;
	}
}