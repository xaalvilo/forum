<?php
namespace Applications\Frontend\Modules\Accueil;
require_once './Framework/autoload.php';
/**
 * 
 * @author Frédéric Tarreau
 *
 * 25 oct. 2014 - ControleurAccueil.class.php
 * 
 * la classe ControleurAccueil hérite de la classe abstraite Controleur du framework. 
 * elle utilise également la methode genererVue pour générer la vue associée à l'action
 * 
 */

class ControleurAccueil extends \Framework\Controleur
{
    /* Manager de article */
    //private $_managerArticle;
 
    /** 
    * le constructeur instancie les classes "modèles" requises
    */
    public function __construct(\Framework\Application $app) 
    {
    	parent::__construct($app);
        //$this->_managerArticle= new \Framework\Modeles\ManagerArticle();
        $id = session_id();
    	echo $id;
        var_dump($_SESSION);
    }
     
    /**
    * 
    * Méthode index
    * 
    * cette méthode est l'action par défaut affichant la page d'accueil
    * 
    * @param array $donnees tableau de données éventuellement passé en paramètre, permettant d'afficher dans le formulaire les champs valides saisis lors d'une
    * requête précédente 
    *  
    */
    public function index(array $donnees = array())
    {
        $this->genererVue();
    }
    
    /**
     *
     * Méthode bandeau
     *
     * cette méthode est l'action consistant à afficher un bandeau personnalisé
     *
     * @param array $donnees tableau de données éventuellement passé en paramètre, permettant d'afficher dans le formulaire les champs valides saisis lors d'une
     * requête précédente
     *
     */
    public function bandeau(array $donnees = array())
    {
        $this->genererVue();
    }
    
    /**
     * 
     * Méthode editer
     * 
     * cette méthode correspond à l'action "editer" permettant d'ajouter un article du blog
     * Elle ne doit être exécutée que si les données insérées dans le formulaire sont valides
     *
     * return_type
     *
     */
    public function editer()
    {
      
    }
}    