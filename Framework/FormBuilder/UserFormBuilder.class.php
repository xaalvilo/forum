<?php
namespace Framework\FormBuilder;
use Framework\Form;
require_once './Framework/autoload.php';
/**
  *
  * @author Fr�d�ric Tarreau
  *
  * Classe fille de FormBuilder dont le r�le est de cr�er le formulaire associ� à l'utilisateur (inscription)
  *
  */
 class UserFormBuilder extends \Framework\Formulaire\FormBuilder
 {
 	/**
 	* Méthode permettant de construire le formulaire d'ajout d'un utilisateur
 	*
 	* @see \Framework\FormBuilder::build($type)
 	*
 	*/
 	public function build($type=NULL)
 	{
      switch ($type)
 	    {
 	        case 1 :
  	                 $longMaxPseudo = \Framework\Configuration::get("longMaxPseudo");
 	                 $longMaxNom = \Framework\Configuration::get("longMaxNom");
 	                 $longMinMdp = \Framework\Configuration::get("longMinMdp");
 	                 $longMaxMdp = \Framework\Configuration::get("longMaxMdp");

 	                 $fieldSet1 = new \Framework\Formulaire\FieldSet(array('legend'=>'Votre identité'));
 	                 $fieldSet2 = new \Framework\Formulaire\FieldSet(array('legend'=>'Vos coordonnées'));
 	                 $fieldSet3 = new \Framework\Formulaire\FieldSet(array('legend'=>'Vos identifiants'));

 	                  // ajout du champ du nom , attention, il faut bien reprendre le nom de l'attribut "nom" de l'objet User, idem pour les autres champs
 	                 $fieldSet1->addField(new \Framework\Formulaire\InputField(array(
 	                                                        'type'=>'text',
 		 													'label'=>'Nom  ',
 		 													'name'=>'nom',
 		 													'maxLength'=>$longMaxNom,
 		 													'id'=>'nom',
 		 													'size'=>$longMaxNom,
 		 													'required'=>true,
 		 													'placeholder'=> 'votre nom',
 		 													'validators'=>array(
 		 																		new \Framework\Formulaire\NotNullValidator('Merci de sp�cifier le nom de l\'utilisateur'),
 		 																		new \Framework\Formulaire\MaxLengthValidator('le nombre maximal de caract�re est fixe a' .$longMaxNom, $longMaxNom),
 		 													                    new \Framework\Formulaire\StringValidator('Merci d\'entrer une chaine de caractere alphanumerique')
 		 			                     ))))
 		 			             ->addField(new \Framework\Formulaire\InputField(array(
 		 			                                        'type'=>'text',
 		 													'label'=>'Prénom  ',
 		 													'name'=>'prenom',
 		 													'maxLength'=>15,
 		 													'id'=>'prenom',
 		 													'size'=>20,
 		 													'required'=>true,
 		 													'placeholder'=> 'votre prenom',
 		 													'validators'=>array(
 		 																		new \Framework\Formulaire\NotNullValidator('Merci de sp�cifier le prenom de l\'utilisateur'),
 		 																		new \Framework\Formulaire\MaxLengthValidator('le nombre maximal de caract�re est fixe a' .$longMaxNom, $longMaxNom),
 		 													                    new \Framework\Formulaire\StringValidator('Merci d\'entrer une chaine de caractere alphanumerique')
 		 			                     ))))
 		 			             ->addField(new \Framework\Formulaire\InputField(array(
 		 			                                        'type'=>'text',
 		 													'label'=>'Pays  ',
 		 													'name'=>'pays',
 		 													'id'=>'pays',
 		 													'size'=>30,
 		 													'required'=>false,
 		 													'placeholder'=> 'votre pays',
 		 													'validators'=>array(new \Framework\Formulaire\StringValidator('Merci d\'entrer une chaine de caractere alphanumerique')
 		 			                     ))))
 		 			              ->addField(new \Framework\Formulaire\InputField(array(
 		 			                             'type'=>'date',
 		 			                             'label'=>'Naissance  ',
 		 			                             'name'=>'naissance',
 		 			                             'maxLength'=>11,
 		 			                             'id'=>'naissance',
 		 			                             'size'=>12,
 		 			                             'required'=>false,
 		 			                             'placeholder'=> '19XX ou 20YY',
 		 			                             'validators'=>array(new \Framework\Formulaire\DateNaissanceValidator('Merci d\'entrer une année de la forme 19XX ou 20YY')
 		 			                       ))));

 		 			             $fieldSet2->addField(new \Framework\Formulaire\InputField(array(
 		 			                                        'type'=>'email',
 		 													'label'=>'Mail  ',
 		 													'name'=>'mail',
 		 													'maxLength'=>25,
 		 													'id'=>'mail',
 		 													'size'=>30,
 		 													'required'=>true,
 		 													'placeholder'=> 'votre email',
 		 													'validators'=>array(
 		 																		new \Framework\Formulaire\NotNullValidator('Merci de sp�cifier l\'adresse email de l\'utilisateur'),
 		 																		new \Framework\Formulaire\MailValidator('Merci d\'entrer le bon format d\'un email')
 		 			                     ))))
 		 			             ->addField(new \Framework\Formulaire\InputField(array(
 		 			                                        'type'=>'tel',
 		 													'label'=>'Téléphone  ',
 		 													'name'=>'telephone',
 		 													'maxLength'=>10,
 		 													'id'=>'telephone',
 		 													'size'=>16,
 		 													'required'=>false,
 		 													'placeholder'=> 'votre telephone',
 		 													'validators'=>array(new \Framework\Formulaire\TphValidator('Merci d\'entrer un numero de telephone à 10 chiffres')
 		 			                     ))));

 		 			             $fieldSet3->addField(new \Framework\Formulaire\InputField(array(
 		 			                                        'type'=>'text',
 		 													'label'=>'Pseudo  ',
 		 													'name'=>'pseudo',
 		 													'maxLength'=>$longMaxPseudo,
 		 													'id'=>'prenom',
 		 													'size'=>$longMaxPseudo ,
 		 													'required'=>true,
 		 													'placeholder'=> 'votre pseudo',
 		 													'validators'=>array(
 		 																		new \Framework\Formulaire\NotNullValidator('Merci de sp�cifier le pseudo de l\'utilisateur'),
 		 																		new \Framework\Formulaire\MaxLengthValidator('le nombre maximal de caract�re est fixe a' .$longMaxPseudo, $longMaxPseudo),
 		 													                    new \Framework\Formulaire\StringValidator('Merci d\'entrer une chaine de caractere alphanumerique')
 		 			                     ))))
 		 			               ->addField(new \Framework\Formulaire\InputField(array(
 		 			                                        'type'=>'text',
 		 													'label'=>'Avatar  ',
 		 													'name'=>'avatar',
 		 													'maxLength'=>15,
 		 													'id'=>'avatar',
 		 													'size'=>20,
 		 													'required'=>false,
 		 													'placeholder'=> 'votre avatar',
 		 													'validators'=>array(
 		 																		new \Framework\Formulaire\MaxLengthValidator('le nombre maximal de caract�re est fixe a 15', 15),

 		 			                     ))))
 		 			             ->addField(new \Framework\Formulaire\InputField(array(
 		 			                                        'type'=>'password',
 		 													'label'=>'Mot de passe  ',
 		 													'name'=>'mdp',
 		 													'pattern' => '{'.$longMinMdp.','.$longMaxMdp.'}',
 		 													'id'=>'mdp',
 		 													'size'=>18 ,
 		 													'required'=>true,
 		 													'placeholder'=> 'votre mot de passe',
 		 													'validators'=>array(new \Framework\Formulaire\PasswordValidator('Merci d\'entrer une chaine de' .$longMinMdp .'à' .$longMaxMdp .'caracteres alphanumeriques')
 		 			                     ))));

 		 			     $this->form->addFieldSet($fieldSet1)->addFieldSet($fieldSet2)->addFieldSet($fieldSet3);

 		                 // ajout du bouton de validation du formulaire
 		                 $this->form->addButton(new \Framework\Formulaire\Button('submit','Valider'));
 		      break;

 	        case 2 :
 	                   $longMaxPseudo = \Framework\Configuration::get("longMaxPseudo");
 	                   $fieldSet = new \Framework\Formulaire\FieldSet(array('legend'=>'Vos identifiants'));
 	                   $fieldSet->addField(new \Framework\Formulaire\InputField(array(
 		 			                                        'type'=>'text',
 		 													'label'=>'Pseudo  ',
 		 													'name'=>'pseudo',
 		 													'maxLength'=>$longMaxPseudo,
 		 													'id'=>'prenom',
 		 													'size'=>$longMaxPseudo ,
 		 													'required'=>true,
 		 													'placeholder'=> 'votre pseudo',
 		 													'validators'=>array(
 		 																		new \Framework\Formulaire\NotNullValidator('Merci de sp�cifier le pseudo de l\'utilisateur'),
 		 																		new \Framework\Formulaire\MaxLengthValidator('le nombre maximal de caract�re est fixe a' .$longMaxPseudo, $longMaxPseudo),
 		 													                    new \Framework\Formulaire\StringValidator('Merci d\'entrer une chaine de caractere alphanumerique')
 		 			                     ))))
 		 			             ->addField(new \Framework\Formulaire\InputField(array(
 		 			                                         'type'=>'email',
 		 			                                         'label'=>'Mail  ',
 		 			                                         'name'=>'mail',
 		 			                                         'maxLength'=>25,
 		 			                                         'id'=>'mail',
 		 			                                         'size'=>30,
 		 			                                         'required'=>true,
 		 			                                         'placeholder'=> 'votre email',
 		 			                                         'validators'=>array(
 		 			                                                             new \Framework\Formulaire\NotNullValidator('Merci de sp�cifier l\'adresse email de l\'utilisateur'),
 		 			                                                             new \Framework\Formulaire\MailValidator('Merci d\'entrer le bon format d\'un email')
 		 			                     ))));

 		 			       $this->form->addFieldSet($fieldSet);

 		 			       // ajout du bouton de validation du formulaire
 		 			       $this->form->addButton(new \Framework\Formulaire\Button('submit','Valider'));
 		 	   break;

 		     default: throw new \Exception("Type de formulaire d'inscription non reconnu");
 	    }
 	}
 }
