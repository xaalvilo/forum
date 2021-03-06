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
    /**
    * le constructeur instancie les classes "modèles" requises
    */
    public function __construct(\Framework\Application $app)
    {
    	parent::__construct($app);
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
    	//TODO ICI
    	if (!$this->_app->userHandler()->isUserAUthenticated())
    		$this->setBandeau(array('connexion'=>'connexion', 'pseudo'=>''));
        $this->genererVue();
    }
}