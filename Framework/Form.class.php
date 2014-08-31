<?php

/** 
* cette classe a pour rôle de représenter un formulaire composé d'une liste de champs
*
*/

namespace Framework;

class Form
{
	/* objet instance d'une classe fille de Entité, auquel sera rattaché le formulaire  */
	protected $entity;
	
	/* liste des champs sous forme de tableau */
	protected $fields;
	
	public function __construct(Entity $entity)
	{
		$this->setEntity($entity);
	}
	
	/**
	* Méthode permettant d'ajouter des champs
	* 
	* @param Field champs à ajouter
	* @return Form nouveau formulaire
	*/
	public function add(Field $field)
	{
		// récupération du nom du champ
		$attr=$field->name();
		
		// assignation de la valeur correspondante au champ
		$field->setValue($this->entity->$attr());
		
		// ajout du champ passé en argument à la liste de champs
		$this->field[]=$field;
		return $this;
	}
	
	/**
	* Méthode permettant de générer l'affichage de tous les champs associés au formulaire
	*
	* @return string View, portion de vue correspondant au formulaire c.a.d HTML
	*/
	public function createView()
	{
		$view ='';
		
		// génération pas à pas de chaque champ du formulaire
		foreach($this->field as $field)
		{
			$view.=$field->buildWidget().'<br />';
		}	
		return $view;
	}
	
	/**
	* Méthode permettant d'acter que tous les champs sont valides
	*
	* @return Boolean vrai si le formulaire est valide
	*/
	public function isValid()
	{
		$valid=true;
		
		//vérification pas à pas que les champs sont valides
		foreach($this->field as $field)
		{
			if (!$field->isValid())
			{
				$valid=false;
			}
		}
		return $valid;
	}
	
	/**
	* setter de entity
	*/
	public function setEntity(Entity $entity)
	{
		$this->entity=$entity;
	}
	
	/**
	* getter de entity
	*/
	public function entity()
	{
		return $this->entity;
	}
}		
	