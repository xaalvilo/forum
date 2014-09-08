<?php
namespace Modele; 
require_once './Framework/autoload.php';

/**
  * 
  * @author Frédéric Tarreau
  * 
  * Classe fille de FormBuilder dont le rôle est de créer le formulaire associé aux commantaires
  *
  */
 class CommentaireFormBuilder extends \Framework\FormBuilder
 {
 	/**
 	 * Méthode permettant de construire le formulaire d'ajout de commentaire
 	 * 
 	 * @see \Framework\FormBuilder::build()
 	 */
 	public function build()
 	{
 		 $this->form->add(new \Framework\StringField(array(
 		 													'label'=>'Auteur',
 		 													'name'=>'auteur',
 		 													'maxLength'=>15,
 		 													'id'=>'auteur',
 		 													'size'=>20,
 		 													'required'=>true,
 		 													'placeholder'=> 'nom de l\'auteur',
 		 													'validators'=>array(
 		 																		new \Framework\NotNullValidator('Merci de spécifier l\'auteur du commentaire'),
 		 																		new \Framework\MaxLengthValidator('le nombre maximal de caractère est fixé à 15', 15)
 		 			       ))))
 		 			->add(new \Framework\TextField(array(
 		 													'label'=>'Texte',
 		 													'name'=>'texte',
 		 													'id'=>'texte',
 		 													'cols'=>100,
 		 													'rows'=>20,
 		 													'required'=>true,
 		 													'placeholder'=>'texte du commentaire',
 		 													'validators'=>array(new \Framework\NotNullValidator('Merci d\'écrire un commentaire')
 		 					))));
 	}
 }
 