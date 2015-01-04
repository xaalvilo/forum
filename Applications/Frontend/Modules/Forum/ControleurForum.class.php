<?php
/**
 * 
 * @author Frédéric Tarreau
 *
 * 7 nov. 2014 - ControleurForum.class.php
 * 
 * la classe ControleurForum hérite de la classe abstraite Controleur du framework. 
*  elle utilise également la methode genererVue pour générer la vue associée à l'action
 *
 */

namespace Applications\Frontend\Modules\Forum;
require_once './Framework/autoload.php';

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
        $this->_managerBillet= new \Framework\Modeles\ManagerBillet();
    }
     
    /**
    * 
    * Méthode index
    * 
    * cette m�thode est l'action par d�faut consistant � afficher la liste de tous les billets (articles) du forum
    * elle créée le formulaire d'ajout de commentaire par la méthode initForm
    * 
    * @param array $donnees tableau de données éventuellement passé en paramètre, permettant d'afficher dans le formulaire les champs valides saisis lors d'une
    * requête précédente 
    *  
    */
    public function index(array $donnees = array())
    {
        // récupération de la liste des billets
        $billets = $this->_managerBillet->getBillets();  
       
        // tableau des valeurs à prendre en compte pour le formulaire
        $tableauValeur = array('methode'=>'post','action'=>'forum/editer');
        
        // si le tableau de données transmises n'est pas vide, le fusionner avec le tableau précédent, le tableau $donnees
        // écrasera éventuellement les valeurs du tableau $tableauValeur si les clés sont identiques (cazr est en second argument de la fonction
        // array_merge(..)
        if(!empty ($donnees))
        {
            $tableauValeur=array_merge($tableauValeur,$donnees);
        }
        
        // création du formulaire d'ajout de Billet
        $form=$this->initForm('Billet',$tableauValeur);
         
        // génération de la vue avec les données : liste des billets et formulaire d'ajout de billet
        $this->genererVue(array('billets'=>$billets,'formulaire'=>$form->createView()));
    }
    
    /**
     * 
     * Méthode editer
     * 
     * cette méthode correspond à l'action "editer" permettant d'ajouter un billet au forum
     * Elle ne doit être exécutée que si les données insérées dans le formulaire sont valides
     *
     * return_type
     *
     */
    public function editer()
    {
        $titre = $this->_requete->getParametre("titre");
        $auteur = $this->_requete->getParametre("auteur");
        $contenu = $this->_requete->getParametre("contenu");
        
        // prise en compte de la date courante
        $date = new \DateTime();
        
        // création du formulaire d'ajout d'un billet en l'hydratant avec les valeurs de la requête
        $form=$this->initForm('Billet',array('titre'=>$titre,
                                             'auteur'=>$auteur,
                                             'contenu'=>$contenu,
                                             'date'=>$date,
                                             'methode'=>'post',
                                             'action'=>'forum/editer'));
         $options=array();
         
        // si la methode est bien POST et que le formulaire est valide, insertion des données en BDD
        if (($this->_requete->getMethode() =='POST'))
        {    
            if ($form->isValid())
            {
                // appelle de la m�thode permettant d'enregistrer un billet en BDD
                $this->_managerBillet->ajouterBillet($titre,$auteur,$contenu);
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