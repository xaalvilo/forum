<?php 
namespace Modele; 
require_once './Framework/autoload.php';

/**
 * 
 * @author Fr�d�ric Tarreau
 *
 *  25 oct 2014 
 * 
 * Classe fille de FormBuilder dont le r�le est de cr�er le formulaire associ� aux articles du blog
 *
 */
 class ArticleFormBuilder extends \Framework\FormBuilder
 {
 	/*
 	 * m�thode de construction du formulaire d'ajout d'article de blog
 	 */
 	public function build()
 	{
 		 $this->form->add(new \Framework\StringField(array(
 		 													'label'=>'Titre',
 		 													'name'=>'titre',
 		 													'maxLength'=>15,
 		 													'id'=>'titre',
 		 													'size'=>100,
 		 													'required'=>true,
 		 													'placeholder'=> 'titre de l\'article',
 		 													'validators'=>array(
 		 																		new \Framework\NotNullValidator('Merci de donner un titre à cet article'),
 		 																		new \Framework\MaxLengthValidator('le nombre maximal de caract�re est fix� � 100', 100),
 		 													                    new \Framework\StringValidator('Merci d\'entrer une chaine de caractere alphanumerique')
 		 					))))
 		 			->add(new \Framework\TextField(array(
 		 							                     'label'=>'Article',
 		 			                                     'name'=>'contenu',
 		 			                                     'id'=>'contenu',
 		 			              						 'cols'=>100,'rows'=>20,
 		 			                                     'required'=>true,
 		 							                     'placeholder'=>'votre article',
 		 			                                     'validators'=>array(new \Framework\NotNullValidator('Merci d\'ecrire le texte de l\'article')
 		 					))))
 		 			->add(new \Framework\StringField(array (
 		 			                                        'label'=>'Image',
 		 			                                         'name'=>'image',
 		 			                                         'id'=>'image',
 		 			                                         'size'=>20,
 		 			                                         'required'=>False,
 		 			                                         'placeholder'=>'nom du fichier image',
 		 			                                         'validators'=>array(new \Framework\MaxLengthValidator('le nombre maximal de caract�re est fix� � 20', 20)
 		 			))));
 		 				 			
 		 	// ajout du bouton de validation du formulaire permettant de valider l'édition du nouvel article
 		 	$this->form->addButton(new \Framework\Button('submit','Editer'));
 	}
 }
 