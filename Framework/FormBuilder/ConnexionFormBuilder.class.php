<?php
namespace Framework\FormBuilder; 
use Framework\Form;
require_once './Framework/autoload.php';
 /**
  * 
  * @author Frédéric Tarreau
  *
  * 30 nov. 2014 - ConnexionFormBuilder.class.php
  * 
  * Classe fille de FormBuilder dont le r�le est de cr�er le formulaire de connexion
  *
  */
 class ConnexionFormBuilder extends \Framework\Formulaire\FormBuilder
 {
 	/**
 	* 
 	* Méthode build
 	* 
 	* cette méthode permet de construire le formulaire de connexion
 	* 
 	* @see \Framework\FormBuilder::build()
 	* 
 	*/
 	public function build()
 	{
 	    // récupération de la taille minimale et maximale d'un mot de passe en configuration
 	    $minLength = \Framework\Configuration::get('longMinMdp');
 	    $maxLength = \Framework\Configuration::get('longMaxMdp');
 	    
 	    // ajout du champ de pseudo, attention, il faut bien reprendre le nom de l'attribut "pseudo" de l'objet connexion
 	    $this->form->add(new \Framework\Formulaire\StringField(array(
 		 													'label'=>'Identifiant  ',
 		 													'name'=>'pseudo',
 		 													'maxLength'=>15,
 		 													'id'=>'pseudo',
 		 													'size'=>20,
 		 													'required'=>true,
 		 													'placeholder'=> 'votre pseudo',
 		 													'validators'=>array(
 		 																		new \Framework\Formulaire\NotNullValidator('Merci de sp�cifier votre pseudo'),
 		 																		new \Framework\Formulaire\MaxLengthValidator('le nombre maximal de caract�re est fixe a 15', 15),
 		 													                    new \Framework\Formulaire\StringValidator('Merci d\'entrer une chaine de caractere alphanumerique')
 		 			       ))))
 		 			// ajout du champ de password, attention, il faut bien reprendre le nom de l'attribut "mdp" de l'objet Connexion
 	                  ->add(new \Framework\Formulaire\PasswordField(array(
 	                                                         'label'=>'Password  ',
 	                                                         'name'=>'mdp',
 	                                                         'pattern'=>'.{'.$minLength.','.$maxLength.'}',
 	                                                         'id'=>'mdp',
 	                                                         'size'=>20,
 	                                                         'required'=>true,
 	                                                         'placeholder'=> 'votre mot de passe',
 	                                                         'validators'=>array(
 	                                                                             new \Framework\Formulaire\NotNullValidator('Merci de donner un mot de passe'),
 	                                                                             new \Framework\Formulaire\MinLengthValidator('le nombre minimal de caract�re est fix� à'.$minLength, $minLength),
 	                                                                             new \Framework\Formulaire\MaxLengthValidator('le nombre maximal de caract�re est fix� à'.$maxLength, $maxLength),
 	                                                                             new \Framework\Formulaire\PasswordValidator('le mot de passe doit comporter xxx')
 		 					)))); 		 			
 		
 		 // ajout du bouton de validation du formulaire, il n'y a pas de valeur cachée hiddenvalue
 		 $this->form->addButton(new \Framework\Formulaire\Button('submit','Connecter'));
 	}
 }
 