<?php
/**
 *
 * @author Frédéric Tarreau
 *
 * 7 nov. 2014 - ControleurForum.class.php
 *
 * la classe ControleurForum hérite de la classe abstraite Controleur du framework.
 * elle utilise également la methode genererVue pour générer la vue associée à l'action
 * Elle permet les actions suivantes :
 * - afficher la liste des billets (action par défaut)
 * - editer un billet
 * - modifier un billet
 * - supprimer un billet
 *
 */
namespace Applications\Frontend\Modules\Forum;
require_once './Framework/autoload.php';

class ControleurForum extends \Framework\Controleur
{
    /* @var manager de topic */
    private $_managerTopic;

    /**
    * le constructeur instancie les classes "mod�les" requises
    */
    public function __construct(\Framework\Application $app)
    {
        parent::__construct($app);
        $this->_managerTopic= \Framework\FactoryManager::createManager('Topic');
    }

    /**
    *
    * Méthode index
    *
    * cette méthode est l'action par défaut consistant à afficher la liste de tous les topics (themes) de la catégorie du forum
    * selectionnée
    *
    * @param array $donnees tableau de données éventuellement passé en paramètre, permettant d'afficher dans le formulaire
    * les champs valides saisis lors d'une requête précédente
    *
    */
    public function index(array $donnees = array())
    {
        // récupération des paramètres de la requête
        $idCat=$this->_requete->getParametre("id");

        // récupération de la liste des topics
        $topics = $this->_managerTopic->getTopics($idCat);

        // génération de la vue avec les données : liste des topics
        $this->genererVue(array('topics'=>$topics));
    }
}