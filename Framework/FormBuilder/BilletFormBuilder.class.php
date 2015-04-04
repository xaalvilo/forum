<?php
namespace Framework\FormBuilder;
require_once './Framework/autoload.php';
/**
 *
 * @author Frédéric Tarreau
 *
 * 7 sept. 2014
 *
 * Classe fille de FormBuilder dont le r�le est de cr�er le formulaire associ� aux billets
 *
 */
 class BilletFormBuilder extends \Framework\Formulaire\FormBuilder
 {
 	/**
 	 * Méthode build
 	 *
 	 * Méthode permettant de construire le formulaire d'ajout de billet
 	 *
 	 * @see \Framework\FormBuilder::build()
 	 *
 	 */
 	public function build($type = NULL)
 	{
 	     $fieldSet = new \Framework\Formulaire\FieldSet(array('legend'=>'Votre billet'));

 		 $fieldSet->addField(new \Framework\Formulaire\InputField (array(
 		 			                                        'type'=>'text',
 		 													'label'=>'Titre  ',
 		 													'name'=>'titre',
 		 													'maxLength'=>15,
 		 													'id'=>'titre',
 		 													'size'=>20,
 		 													'required'=>true,
 		 													'placeholder'=> 'titre du billet',
 		 													'validators'=>array(
 		 																		new \Framework\Formulaire\NotNullValidator('Merci de donner un titre au billet'),
 		 																		new \Framework\Formulaire\MaxLengthValidator('le nombre maximal de caract�re est fix� � 15', 15)
 		                  ))))
 		 			->addField(new \Framework\Formulaire\TextField(array(
 		 							                     'label'=>'Billet',
 		 			                                     'name'=>'contenu',
 		 			                                     'id'=>'contenu',
 		 			              						 'cols'=>100,'rows'=>3,
 		 			                                     'required'=>true,
 		 							                     'placeholder'=>'votre billet',
 		 			                                     'validators'=>array(new \Framework\Formulaire\NotNullValidator('Merci d\'ecrire un billet')
 		 				))));

 		 	$this->form->addFieldSet($fieldSet);

 		 	// prise en compte de la valeur cachée à transmettre
 		 	$hiddenValue=$this->form->entite()->idTopic();

 		 	// ajout du bouton de validation du formulaire permettant de valider l'édition du le nouveau billet
 		 	$this->form->addButton(new \Framework\Formulaire\Button('submit','Editer','id',$hiddenValue));
 	}
 }
