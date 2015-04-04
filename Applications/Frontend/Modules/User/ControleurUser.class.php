<?php
namespace Applications\Frontend\Modules\User;
require_once './Framework/autoload.php';
/**
 *
 * @author Frédéric Tarreau
 *
 * 29 mars 2015 - ControleurUser.class.php
 *
 * la classe ControleurUser hérite de la classe abstraite Controleur du framework.
 * elle utilise également la methode genererVue pour générer la vue associée à l'action
 *
 */

class ControleurUser extends \Framework\Controleur
{
    /* @var manager de user */
    protected $_managerUser;

    /**
    * le constructeur instancie les classes "modèles" requises
    */
    public function __construct(\Framework\Application $app)
    {
    	parent::__construct($app);
        $this->_managerUser = \Framework\FactoryManager::createManager('User');
    }

    /**
    *
    * Méthode index
    *
    * cette méthode est l'action par défaut affichant la page de gestion des utilisateurs
    *
    * @param array $donnees tableau de données éventuellement passé en paramètre, permettant d'afficher dans le formulaire les champs valides saisis lors d'une
    * requête précédente
    *
    */
    public function index(array $donnees = array())
    {
    	$idUser=$this->_requete->getParametre('id');
        $user=$this->_managerUser->getUser($idUser);

        // tableau des valeurs à prendre en compte pour le formulaire
        $tableauValeur = array('methode'=>'post','action'=>'user/envoyer','value'=>$idUser,
                                'destinataire'=>$user['_mail']);

        // si le tableau de données transmises n'est pas vide, le fusionner avec le tableau précédent, le tableau $donnees
        // écrasera éventuellement les valeurs du tableau $tableauValeur si les clés sont identiques (car est en second argument de la fonction
        // array_merge(..)
        if(!empty ($donnees))
            $tableauValeur=array_merge($tableauValeur,$donnees);

    	// génération de la vue avec les données : billet, commentaire et formulaire d'ajout de commentaire
    	$this->genererVue(array('user'=>$user,'formulaire'=>$form->createView()));
    }
}