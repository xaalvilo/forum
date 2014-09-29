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
    * cette m�thode est l'action par d�faut consistant � afficher la liste de tous les billets (articles) du blog
    */
    public function index()
    {
        $billets = $this->_managerBillet->getBillets();  
        $this->genererVue(array('billets'=>$billets));
    }
}