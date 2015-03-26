<?php
namespace Framework\FormBuilder;
use Framework\Form;
require_once './Framework/autoload.php';
/**
  *
  * @author Fr�d�ric Tarreau
  *
  * Classe fille de FormBuilder dont le r�le est de cr�er le formulaire associ� aux commentaires
  *
  */
 class CommentaireFormBuilder extends \Framework\Formulaire\FormBuilder
 {
 	/**
 	* Méthode permettant de construire le formulaire d'ajout de commentaire
 	*
 	* @see \Framework\FormBuilder::build()
 	*
 	*/
 	public function build($type = NULL)
 	{
 	    $fieldSet = new \Framework\Formulaire\FieldSet(array('legend'=>'Commentaire'));

 	    // ajout du champ de nom auteur, attention, il faut bien reprendre le nom de l'attribut "auteur" de l'objet commentaire
 	  //TODO $fieldSet->addField(new \Framework\Formulaire\InputField(array(
 	          //                                              'type'=>'text',
 		 		//											'label'=>'Auteur  ',
 		 			//										'name'=>'auteur',
 		 								//					'maxLength'=>15,
 		 									//				'id'=>'auteur',
 		 										//			'size'=>20,
 		 										//			'required'=>true,
 		 										//			'placeholder'=> 'votre pseudo',
 		 										//			'validators'=>array(
 		 										//								new \Framework\Formulaire\NotNullValidator('Merci de sp�cifier l\'auteur du commentaire'),
 		 										//								new \Framework\Formulaire\MaxLengthValidator('le nombre maximal de caract�re est fixe a 15', 15),
 		 										//			                    new \Framework\Formulaire\StringValidator('Merci d\'entrer une chaine de caractere alphanumerique')
 		 			    //   ))))

 		 			// ajout du champ de texte, attention, il faut bien reprendre le nom de l'attribut "contenu" de l'objet commentaire
 		 		 // ajout du champ de nom auteur, attention, il faut bien reprendre le nom de l'attribut "auteur" de l'objet commentaire
 	   $fieldSet->addField(new \Framework\Formulaire\TextField(array(
 		 													'label'=>NULL,
 		 													'name'=>'contenu',
 		 													'id'=>'contenu',
 		 													'cols'=>75,
 		 													'rows'=>3,
 		 													'required'=>true,
 		 													'placeholder'=>'votre commentaire',
 		 													'validators'=>array(new \Framework\Formulaire\NotNullValidator('Merci d\'ecrire un commentaire'),
 		 													                    new \Framework\Formulaire\TextValidator('echec du nettoyage de chaine')
 		 					))));

 		 $this->form->addFieldSet($fieldSet);

 		 // prise en compte de la valeur cachée à transmettre
 		 $hiddenValue=$this->form->entite()->idParent();

 		 // ajout du bouton de validation du formulaire
 		 $this->form->addButton(new \Framework\Formulaire\Button('submit','Valider','id',$hiddenValue));
 	}
 }
