<?php
namespace Framework\FormBuilder;
require_once './Framework/autoload.php';
/**
 *
 * @author Frédéric Tarreau
 *
 * 03 avril 2015
 *
 * Classe fille de FormBuilder dont le r�le est de cr�er le formulaire associ� à un mail
 *
 */
 class MailFormBuilder extends \Framework\Formulaire\FormBuilder
 {
 	/**
 	 * Méthode build
 	 *
 	 * Méthode permettant de construire le formulaire d'envoi de Mail
 	 *
 	 * @see \Framework\FormBuilder::build()
 	 *
 	 */
 	public function build($type = NULL)
 	{
 	     $fieldSet = new \Framework\Formulaire\FieldSet(array('legend'=>'Votre mail'));

 		 $fieldSet->addField(new \Framework\Formulaire\InputField (array(
 		 			                                        'type'=>'email',
 		 													'label'=>'destinataire  ',
 		 													'name'=>'destinataire',
 		 													'maxLength'=>15,
 		 													'id'=>'destinataire',
 		 													'size'=>20,
 		 													'required'=>true,
 		 													'placeholder'=> 'email@du.destinataire',
 		 													'validators'=>array(
 		 																		new \Framework\Formulaire\NotNullValidator('Merci d\'ecrire l\'adresse mail du destinataire'),
 		 																		new \Framework\Formulaire\MailValidator('le format de l\'adresse mail n\'est pas valide')
 		 													))))
 		         ->addField(new \Framework\Formulaire\InputField (array(
 		                                                     'type'=>'text',
 		                                                     'label'=>'Objet  ',
 		                                                     'name'=>'objet',
 		                                                     'maxLength'=>15,
 		                                                     'id'=>'objet',
 		                                                     'size'=>20,
 		                                                     'required'=>true,
 		                                                     'placeholder'=> 'objet de votre email',
 		                                                     'validators'=>array(
 		                                                                         new \Framework\Formulaire\NotNullValidator('Merci de donner un objet à ce mail'),
 		                                                                         new \Framework\Formulaire\MaxLengthValidator('le nombre maximal de caract�re est fix� � 15', 15)
 		                                                     ))))
 		 		->addField(new \Framework\Formulaire\TextField(array(
 		 							                         'label'=>'Message',
 		 			                                         'name'=>'contenu',
 		 			                                         'id'=>'contenu',
 		 			              						     'cols'=>100,'rows'=>3,
 		 			                                         'required'=>true,
 		 							                         'placeholder'=>'votre message',
 		 			                                         'validators'=>array(new \Framework\Formulaire\NotNullValidator('Merci d\'ecrire le texte de votre message')
 		 			                                         ))));

 		 	$this->form->addFieldSet($fieldSet);

 		 	// prise en compte de la valeur cachée à transmettre
 		 	//$hiddenValue=$this->form->entite()->idTopic();

 		 	// ajout du bouton de validation du formulaire permettant de valider l'édition du le nouveau billet
 		 	$this->form->addButton(new \Framework\Formulaire\Button('submit','Envoyer'));
 	}
 }
