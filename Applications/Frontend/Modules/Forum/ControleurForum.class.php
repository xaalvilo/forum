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

    /* @var manager de commentaires */
    private $_managerCommentaire;

    /* @var manager de billets*/
    private $_managerBillet;

    /**
    * le constructeur instancie les classes "mod�les" requises
    */
    public function __construct(\Framework\Application $app)
    {
        parent::__construct($app);
        $this->_managerTopic= \Framework\FactoryManager::createManager('Topic');
        $this->_managerCommentaire = \Framework\factoryManager::createManager('Commentaire');
        $this->_managerBillet = \Framework\factoryManager::createManager('Billet');
    }

    /**
    *
    * Méthode index
    *
    * cette méthode est l'action par défaut consistant à afficher:
    * - la liste de tous les topics (themes) de la catégorie du forum selectionnée par la transmission d'un id
    * - la liste de tous les billets créés ou commentés depuis la dernière connexion de l'utilisateur
    *
    * @param array $donnees tableau de données éventuellement passé en paramètre, permettant d'afficher dans le formulaire
    * les champs valides saisis lors d'une requête précédente
    *
    */
    public function index(array $donnees = array())
    {
        $nbVisiteurs = $this->_app->sessionHandler()->count();
        // récupération des paramètres de la requête s'il y en a
        if($this->_requete->existeParametre('id')) {

            $isNewBillets=FALSE;
            $idCat=$this->_requete->getParametre('id');

            // récupération de la liste des topics
            $topics = $this->_managerTopic->getTopics($idCat);

            // génération de la vue avec les données : liste des topics
            $this->genererVue(array('topics'=>$topics,'isNewBillets'=>$isNewBillets,'nbVisiteurs'=>$nbVisiteurs));
        }
        // il n'y a aucun paramètre
        else {
            $isNewBillets=TRUE;

            // il s'agit d'afficher tous les nouveaux messages depuis la précédente connexion de l'utilisateur
            $idUser=$this->_app->userHandler()->user()->id();
            $billets=$this->_managerBillet->getNewBillets($idUser);

            //génération de la vue avec les données : liste des billets concernés
            $this->genererVue(array('billets'=>$billets,'isNewBillets'=>$isNewBillets,'nbVisiteurs'=>$nbVisiteurs));
        }

    }
}