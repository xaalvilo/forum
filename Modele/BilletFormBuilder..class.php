<?php namespace Modele; 
require_once './Framework/autoload.php';

/**
 * 
 * @author Fr�d�ric Tarreau
 *
 * 7 sept. 2014 
 * 
 * Classe fille de FormBuilder dont le r�le est de cr�er le formulaire associ� aux billets
 *
 */
 class BilletFormBuilder extends \Framework\FormBuilder
 {
 	/*
 	 * m�thode de construction du formulaire d'ajout de billet
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
 		 																		new \Framework\NotNullValidator('Merci de sp�cifier l\'auteur du billet'),
 		 																		new \Framework\MaxLengthValidator('le nombre maximal de caract�re est fix� � 15', 15)
 		 			       ))))
 		 			->add(new \Framework\StringField (array(
 		 													'label'=>'Titre',
 		 													'name'=>'titre',
 		 													'maxLength'=>15,
 		 													'id'=>'titre',
 		 													'size'=>20,
 		 													'required'=>true,
 		 													'placeholder'=> 'titre du billet',
 		 													'validators'=>array(
 		 																		new \Framework\NotNullValidator('Merci de donner un titre au billet'),
 		 																		new \Framework\MaxLengthValidator('le nombre maximal de caract�re est fix� � 15', 15)
 		 					))))
 		 			->add(new \Framework\TextField(array(
 		 							'label'=>'Texte','name'=>'texte','id'=>'texte',
 		 						    'cols'=>100,'rows'=>20,'required'=>true,
 		 							'placeholder'=>'texte du billet','validators'=>array(
 		 									new \Framework\NotNullValidator('Merci d\'ecrire un billet')
 		 					)
 		 					)
 		 					)
 		 					);
 	}
 }
 