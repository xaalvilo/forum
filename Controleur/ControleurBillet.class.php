<?php
/**
 * 
 * @author Frédéric Tarreau
 *
 * 3 oct. 2014 - file_name
 * 
 *  La classe ControleurBillet h�rite de la classe abstraite Controleur du framework. Il s'agit du contrôleur des actions liées aux billets
 *  Elle utilise les services de la classe Requete pour accéder aux parametres de la requete. 
 *  elle utilise également la methode executerAction de sa superclasse afin d'actualiser les détails sur le billet, et genererVue pour 
 *  générer la vue associée à l'action
 *
 */

namespace Controleur;
use Modele\CommentaireFormBuilder;
use Modele\Commentaire;
require_once './Framework/autoload.php';

class ControleurBillet extends \Framework\Controleur
{
    /* manager de billet */
    private $_managerBillet;
   
    /* manager de commentaire */
    private $_managerCommentaire;
    
    /** 
    * le constructeur instancie les classes "mod�les" requises
    */
     public function __construct(\Framework\Application $app) 
     {
     	 parent::__construct($app);
         $this->_managerBillet= new \Modele\ManagerBillet();
         $this->_managerCommentaire= new \Modele\ManagerCommentaire();
     }
     
    /**
    * 
    * Méthode Index
    * 
    * cette m�thode est l'action par d�faut consistant � afficher la liste des commentaires associ�s � un billet
    * elle utilise les m�thodes getter des mod�les instanci�s pour r�cup�rer les donn�es n�cessaires aux vues
    * elle créée le formulaire d'ajout de commentaire par la méthode initForm
    * 
    * @param array $donnees tableau de données optionnel, permettant d'afficher dans le formulaire les champs valides saisis lors d'une
    * requête précédente
    * 
    */
    public function index(array $donnees = array())
    {
        $idBillet=$this->requete->getParametre("id") ;
        $billet=$this->_managerBillet->getBillet($idBillet); 
        $commentaires=$this->_managerCommentaire->getListeCommentaires($idBillet);  

        $tableauValeur = array('idBillet'=>$idBillet,'methode'=>'post','action'=>'billet/commenter');
        
        // si le tableau de données transmises n'est pas vide, le fusionner avec le tableau précédent, le tableau $donnees
        // écrasera éventuellement les valeurs du tableau $tableauValeur si les clés sont identiques (cazr est en second argument de la fonction
        // array_merge(..)
        if(!empty ($donnees))
        {
            $tableauValeur=array_merge($tableauValeur,$donnees);
        }
  
        // création du formulaire d'ajout de commentaire 
        $form=$this->initForm('Commentaire',$tableauValeur);
         
        // génération de la vue avec les données : billet, commentaire et formulaire d'ajout de commentaire
        $this->genererVue(array('billet'=>$billet,'commentaires'=>$commentaires,'formulaire'=>$form->createView()));
    }
    
    /**
     * 
     * Méthode Commenter
     * 
     * Cette m�thode est l'action "commenter" permettant d'ajouter un commentaire sur un billet
     * Elle ne doit être exécutée que si les données insérées dans le formulaire sont valides
     * 
     */
    public function commenter()
    {
        $idBillet = $this->requete->getParametre("id");
        $auteur = $this->requete->getParametre("auteur");
        $contenu = $this->requete->getParametre("contenu");
        
        // création du formulaire d'ajout de commentaire en l'hydratant avec les valeurs de la requête
        $form=$this->initForm('Commentaire',array('idBillet'=>$idBillet,'auteur'=>$auteur,'contenu'=>$contenu,'methode'=>'post','action'=>'billet/commenter'));
        
        // si la methode est bien POST et que le formulaire est valide, insertion des données en BDD
        if (($this->requete->getMethode() =='POST')) 
        {   
            $options=array();
            
            if ($form->isValid())
            {
                // appelle de la m�thode permettant d'enregistrer un commentaire en BDD 
                $this->_managerCommentaire->ajouterCommentaire($idBillet, $auteur, $contenu);
            }
            else 
            {
                // recuperation des nom/valeur des champs valides afin de générer ultérieurement l'affichage du formulaire
                // pour le cas d'un commentaire
                $options=$form->validField();
            }
        }
        
        //il s'agit sinon ou ensuite d'executer l'action par d�faut permettant d'afficher la liste des commentaires 
        $this->executerAction("index",$options);
    }
    
    /**
     * 
     * Méthode supprimer
     *
     * cette méthode correspond à l'action "supprimer" appelée par le contrôleur lorsque l'utilisateur demande la suppression d'un 
     * commentaire qu'il a rédigé précédemment
     * 
     * return_type
     *
     */
    public function supprimer()
    {
        
    }
    
}