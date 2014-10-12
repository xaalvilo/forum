<?php
namespace Controleur;
require_once './Framework/autoload.php';

/**
*  la classe ControleurForum hérite de la classe abstraite Controleur du framework. 
*  elle utilise également la methode genererVue pour générer la vue associée à l'action
*/

class ControleurForum extends \Framework\Controleur
{
    /* Manager de billet */
    private $_managerBillet;
 
    /** 
    * le constructeur instancie les classes "mod�les" requises
    */
    public function __construct(\Framework\Application $app) 
    {
    	parent::__construct($app);
        $this->_managerBillet= new \Modele\ManagerBillet();
    }
     
    /**
    * 
    * Méthode index
    * 
    * cette m�thode est l'action par d�faut consistant � afficher la liste de tous les billets (articles) du forum
    * 
    * @param array $donnees tableau de données éventuellement passé en paramètre
    * 
    */
    public function index(array $donnees = array())
    {
        $billets = $this->_managerBillet->getBillets();  
        $this->genererVue(array('billets'=>$billets));
        
    }
    
    /**
     * 
     * Méthode editer
     * 
     * cette méthode correspond à l'action "editer" permettant d'ajouter un billet au forum
     *
     * return_type
     *
     */
    public function editer()
    {
        $titre = $this->requete->getParametre("titre");
        $auteur = $this->requete->getParametre("auteur");
        $contenu = $this->requete->getParametre("contenu");
        
        // prise en compte de la date courante
        $date = new \DateTime();
        
        // création du formulaire d'ajout d'un billet en l'hydratant avec les valeurs de la requête
        $form=$this->initForm('Billet',array('titre'=>$titre,
                                             'auteur'=>$auteur,
                                             'contenu'=>$contenu,
                                             'date'=>$date,
                                             'methode'=>'post',
                                             'action'=>'forum/editer'));
        
        // si la methode est bien POST et que le formulaire est valide, insertion des données en BDD
        if (($this->requete->getMethode() =='POST'))
        {
            $options=array();
        
            if ($form->isValid())
            {
                // appelle de la m�thode permettant d'enregistrer un billet en BDD
                $this->_managerBillet->ajouterBillet($titre, $auteur, $contenu);
            }
            else
            {
                // recuperation des nom/valeur des champs valides afin de générer ultérieurement l'affichage du formulaire
                $options=$form->validField();
            }
         }
        
         //il s'agit sinon ou ensuite d'executer l'action par d�faut permettant d'afficher la liste des billets
         $this->executerAction("index",$options);
    }
}    