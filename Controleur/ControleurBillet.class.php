<?php
namespace Controleur;
use Modele\CommentaireFormBuilder;
use Modele\Commentaire;
require_once './Framework/autoload.php';

/**
  *  la classe ControleurBillet h�rite de la classe abstraite Controleur du framework. Il s'agit du contrôleur des actions liées aux billets
  *  Elle utilise les services de la classe Requete pour accéder aux parametres de la requete. 
  *  elle utilise également la methode executerAction de sa superclasse afin d'actualiser les détails sur le billet, et genererVue pour générer la vue associée à l'action
  */

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
    * cette m�thode est l'action par d�faut consistant � afficher la liste des commentaires associ�s � un billet
    * elle utilise les m�thodes getter des mod�les instanci�s pour r�cup�rer les donn�es n�cessaires aux vues
    */
    public function index()
    {
        $idBillet=$this->requete->getParametre("id") ;
        $billet=$this->_managerBillet->getBillet($idBillet); 
        $commentaires=$this->_managerCommentaire->getListeCommentaires($idBillet);  

        // il faut cr�er le formulaire "vierge" en commençant par un objet commentaire à hydrater avec des valeurs par défaut
        $date = new \DateTime();
        $commentaire = new \Modele\Commentaire(array('idBillet'=>$idBillet,'date'=>$date));
        
        // création du constructeur de formulaire avec l'objet commentaire instancié
        $formBuilder = new CommentaireFormBuilder($commentaire,'post','billet/commenter');

        // création du formulaire d'ajout de commentaire
        $formBuilder->build();
        $form = $formBuilder->form();
         
        // génération de la vue avec les données : billet, commentaire et formulaire d'ajout de commentaire
        $this->genererVue(array('billet'=>$billet,'commentaires'=>$commentaires,'formulaire'=>$form->createView()));
    }
        
    /**
    * cette m�thode est l'action "commenter" permettant de g�n�rer / ajouter un commentaire sur un billet
    */
    public function commenter()
    {
        $idBillet = $this->requete->getParametre("id");
        $auteur = $this->requete->getParametre("auteur");
        $contenu = $this->requete->getParametre("contenu");
            
        // appelle de la m�thode permettant d'ajouter un commentaire */
        $this->_managerCommentaire->ajouterCommentaire($idBillet, $auteur, $contenu);
    
        //il s'agit ensuite d'executer l'action par d�faut permettant d'afficher la liste des commentaires */
        $this->executerAction("index");
    }
}