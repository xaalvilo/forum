<?php
namespace Modele; 
require_once './Framework/autoload.php';

/**
  * 
  * @author Fr�d�ric Tarreau
  * 
  * Classe fille de FormBuilder dont le r�le est de cr�er le formulaire associ� aux commantaires
  *
  */
 class CommentaireFormBuilder extends \Framework\FormBuilder
 {
 	/**
 	 * M�thode permettant de construire le formulaire d'ajout de commentaire
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
 		 																		new \Framework\NotNullValidator('Merci de sp�cifier l\'auteur du commentaire'),
 		 																		new \Framework\MaxLengthValidator('le nombre maximal de caract�re est fix� � 15', 15)
 		 			       ))))
 		 			->add(new \Framework\TextField(array(
 		 													'label'=>'Texte',
 		 													'name'=>'texte',
 		 													'id'=>'texte',
 		 													'cols'=>100,
 		 													'rows'=>20,
 		 													'required'=>true,
 		 													'placeholder'=>'texte du commentaire',
 		 													'validators'=>array(new \Framework\NotNullValidator('Merci d\'�crire un commentaire')
 		 					))));
 	}
 }
 