<?php
namespace Modele; 
use Framework\Form;
require_once './Framework/autoload.php';
/**
  * 
  * @author Fr�d�ric Tarreau
  * 
  * Classe fille de FormBuilder dont le r�le est de cr�er le formulaire associ� aux commentaires
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
 	    // ajout du champ de nom auteur, attention, il faut bien reprendre le nom de l'attribut "auteur" de l'objet commentaire
 	    $this->form->add(new \Framework\StringField(array(
 		 													'label'=>'Auteur',
 		 													'name'=>'auteur',
 		 													'maxLength'=>15,
 		 													'id'=>'auteur',
 		 													'size'=>20,
 		 													'required'=>true,
 		 													'placeholder'=> 'votre pseudo',
 		 													'validators'=>array(
 		 																		new \Framework\NotNullValidator('Merci de sp�cifier l\'auteur du commentaire'),
 		 																		new \Framework\MaxLengthValidator('le nombre maximal de caract�re est fixe a 15', 15),
 		 													                    new \Framework\StringValidator('Merci d\'entrer une chaine de caractere alphanumerique')
 		 			       ))))
 		 			// ajout du champ de texte, attention, il faut bien reprendre le nom de l'attribut "contenu" de l'objet commentaire
 		 			->add(new \Framework\TextField(array(
 		 													'label'=>'Commentaire',
 		 													'name'=>'contenu',
 		 													'id'=>'contenu',
 		 													'cols'=>75,
 		 													'rows'=>3,
 		 													'required'=>true,
 		 													'placeholder'=>'votre commentaire',
 		 													'validators'=>array(new \Framework\NotNullValidator('Merci d\'ecrire un commentaire')
 		 					))));
 		 			
 		 // prise en compte de la valeur cachée à transmettre
 		 $hiddenValue=$this->form->entite()->idBillet();
 		 
 		 // ajout du bouton de validation du formulaire
 		 $this->form->addButton(new \Framework\Button('submit','Commenter','id',$hiddenValue));
 	}
 }
 