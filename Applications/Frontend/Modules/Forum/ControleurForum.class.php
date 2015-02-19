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
    /* @var Manager de billet */
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

         //il faut préremplir le champ avec le pseudo fourni
        $donnees['auteur']=$this->_app->userHandler()->user()->pseudo();
        $pseudo=$donnees['auteur'];

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
        $this->genererVue(array('pseudo'=>$pseudo,'billets'=>$billets,'formulaire'=>$form->createView()));
    }

    /**
     *
     * Méthode editer
     *
     * cette méthode correspond à l'action "editer" permettant d'ajouter un billet au forum
     * Elle ne doit être exécutée que si les données insérées dans le formulaire sont valides
     *
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
                // billet nouveau
                if (empty($_SESSION['modifBillet']))
                {
                    // enregistrer billet en BDD
                    $this->_managerBillet->ajouterBillet($titre,$auteur,$contenu);

                    // actualiser utilisateur en BDD
                    $idUser = $this->_app->userHandler()->user()->id();
                    $nbreBilletsForum = $this->_app->userHandler()->user()->nbreBilletsForum();
                    $nbreBilletsForum++;
                    $this->_app->userHandler()->managerUser()->actualiserUser($idUser,array('_nbreBilletsForum'=>$nbreBilletsForum));
                }
                // actualisation billet
                else
                {
                    $dateModif = new \DateTime();

                    $this->_managerBillet->actualiserBillet($_SESSION['modifBillet'],array('titre'=>$titre,'contenu'=>$contenu,'dateModif'=>$dateModif));
                    $this->_app->userHandler()->removeAttribute('modifBillet');
                }
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

    /**
     *
     * Méthode supprimer
     *
     * cette méthode correspond à l'action "supprimer" appelée par le contrôleur lorsque l'utilisateur demande la suppression d'un
     * commentaire qu'il a rédigé précédemment, elle renvoie ensuite vers la page par défaut
     *
     */
    public function supprimer()
    {
        // récupération des paramètres de la requête
        $idBillet=$this->_requete->getParametre("id");

        // suppression billet BDD
        $resultat = $this->_managerBillet->supprimerBillet($idBillet);

        if($resultat)
            $this->_app->userHandler()->setFlash('Billet supprimé');
        else
            $this->_app->userHandler()->setFlash('échec de la tentative de suppression du Billet');

        //executer l'action par d�faut permettant d'afficher la liste des billets
        $this->executerAction("index",array());
    }

    /**
     *
     * Méthode modifier
     *
     * cette méthode correspond à l'action "modifier" appelée par le contrôleur lorsque l'utilisateur demande la modification d'un
     * commentaire qu'il a rédigé précédemment.
     * Elle permet de pré remplir le formulaire de commentaire dans la page par défaut (index) avec les bonnes données
     * Elle utilise la variable superglobale S_SESSION
     *
     */
    public function modifier()
    {
        // récupération des paramètres de la requête
        $idBillet=$this->_requete->getParametre("id");

        // récupération du billet à modifier
        $billet = $this->_managerBillet->getBillet($idBillet);

        // création d'un tableau avec les attributs souhaités de l'objet $billet
        $tableauBillet['titre']=$billet->offsetget('titre');
        $tableauBillet['contenu']=$billet->offsetget('contenu');

        // il faut tracer cette modification jusqu'à l'actualisation du commentaire
        $this->_app->userHandler()->setAttribute("modifBillet",$idBillet);

        // il s'agit d'executer l'action par d�faut permettant d'afficher la liste des billets
        // en affichant le formulaire pré rempli avec le billet à modifier
        $this->executerAction("index", $tableauBillet);
    }
}