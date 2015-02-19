<?php
namespace Framework\FormBuilder;
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
 class ArticleFormBuilder extends \Framework\Formulaire\FormBuilder
 {
 	/*
 	 * m�thode de construction du formulaire d'ajout d'article de blog
 	 */
 	public function build($type = NULL)
 	{
 		 $this->form->add(new \Framework\Formulaire\InputField(array(
 		                                                    'type'=>'text',
 		 													'label'=>'Titre   ',
 		 													'name'=>'titre',
 		 													'maxLength'=>100,
 		 													'id'=>'titre',
 		 													'size'=>100,
 		 													'required'=>true,
 		 													'placeholder'=> 'titre de l\'article',
 		 													'validators'=>array(
 		 																		new \Framework\Formulaire\NotNullValidator('Merci de donner un titre à cet article'),
 		 																		new \Framework\Formulaire\MaxLengthValidator('le nombre maximal de caract�re est fix� � 100', 100),
 		 			        ))))
 		 			  ->add(new \Framework\Formulaire\InputField(array(
 		 			                                         'type'=>'text',
 		 			                                         'label'=>'Libelle   ',
 		 			                                         'name'=>'libelle',
 		 			                                         'maxLength'=>20,
 		 			                                         'id'=>'libelle',
 		 			                                         'size'=>20,
 		 			                                         'required'=>true,
 		 			                                         'placeholder'=> 'libellé de l\'article',
 		 			                                         'validators'=>array(
 		 			                                                         new \Framework\Formulaire\NotNullValidator('Merci de donner un libellé à cet article'),
 		 			                                                         new \Framework\Formulaire\MaxLengthValidator('le nombre maximal de caract�re est fix� � 20', 20),
 		 			                ))))
 		 			->add(new \Framework\Formulaire\TextField(array(
 		 							                     'label'=>'Article',
 		 			                                     'name'=>'contenu',
 		 			                                     'id'=>'contenu',
 		 			              						 'cols'=>100,'rows'=>20,
 		 			                                     'required'=>true,
 		 							                     'placeholder'=>'votre article',
 		 			                                     'validators'=>array(new \Framework\Formulaire\NotNullValidator('Merci d\'ecrire le texte de l\'article')
 		 					))))
 		 			->add(new \Framework\Formulaire\InputField(array (
 		 			                                         'type'=>'text',
 		 			                                        'label'=>'Image  ',
 		 			                                         'name'=>'image',
 		 			                                         'id'=>'image',
 		 			                                         'size'=>20,
 		 			                                         'required'=>False,
 		 			                                         'placeholder'=>'nom du fichier image',
 		 			                                         'validators'=>array(new \Framework\Formulaire\MaxLengthValidator('le nombre maximal de caract�re est fix� � 20', 20)
 		 			))));

 		 	// ajout du bouton de validation du formulaire permettant de valider l'édition du nouvel article
 		 	$this->form->addButton(new \Framework\Formulaire\Button('submit','Editer'));
 	}
 }
