<?php
/**
 *
 * @author Frédéric Tarreau
 *
 * 3 oct. 2014 - ControleurBillet.class.php
 *
 *  La classe ControleurBillet h�rite de la classe abstraite Controleur du framework.
 *
 *  Il s'agit du contrôleur des actions liées aux billets
 *  Elle utilise les services de la classe Requete pour accéder aux parametres de la requete.
 *  elle utilise également la methode executerAction de sa superclasse afin d'actualiser les détails sur le billet, et genererVue pour
 *  générer la vue associée à l'action
 *
 *  Elle permet les actions suivantes :
 *  - afficher un billet et ses commentaires
 *  - répondre à un billet avec une citation
 *  - supprimer un commentaire
 *  - modifier un commentaire
 *
 */

namespace  Applications\Frontend\Modules\Billet;
use Modele\CommentaireFormBuilder;
use Modele\Commentaire;
require_once './Framework/autoload.php';

class ControleurBillet extends \Framework\Controleur
{
    /* @var \Framework\Manager manager de billet */
    private $_managerBillet;

    /* @var \Framework\Manager manager de commentaire */
    private $_managerCommentaire;

    /**
    * le constructeur instancie les classes "mod�les" requises
    */
     public function __construct(\Framework\Application $app)
     {
     	 parent::__construct($app);
     	 $this->_managerBillet= \Framework\FactoryManager::createManager('Billet');
         $this->_managerCommentaire= \Framework\FactoryManager::createManager('Commentaire');
     }

    /**
    *
    * Méthode Index
    *
    * cette m�thode est l'action par d�faut consistant � afficher la liste des commentaires associ�s � un billet
    * elle utilise les m�thodes getter des mod�les instanci�s pour r�cup�rer les donn�es n�cessaires aux vues
    * elle créée le formulaire d'ajout de commentaire par la méthode initForm
    *
    * @param array $donnees tableau de données optionnel, permettant d'afficher dans le formulaire les données de champs valides saisis lors d'une
    * requête précédente
    *
    */
    public function index(array $donnees=array())
    {
        // spécification de la table concernée dans la BDD
        $table = \Framework\Modeles\ManagerCommentaire::TABLE_COMMENTAIRES_BILLET;

        // récupération des paramètres de la requête
        $idBillet=$this->_requete->getParametre("id");

        // extraction du billet concerné dans la BDD
        $billet=$this->_managerBillet->getBillet($idBillet);

        // extraction des commentaires associés dans la BDD
        $commentaires=$this->_managerCommentaire->getListeCommentaires($table, $idBillet);

        $tableauValeur=array('idReference'=>$idBillet,'methode'=>'post','action'=>'billet/valider');

        // il faut préremplir le champ avec le pseudo fourni
        $donnees['auteur']=$this->_app->userHandler()->user()->pseudo();
        $pseudo = $donnees['auteur'];

        // si le tableau de données transmises n'est pas vide, le fusionner avec le tableau précédent, le tableau $donnees
        // écrasera éventuellement les valeurs du tableau $tableauValeur si les clés sont identiques (car est en second argument de la fonction
        // array_merge(..)
        if(!empty ($donnees))
            $tableauValeur=array_merge($tableauValeur,$donnees);

        // création du formulaire d'ajout de commentaire
        $form=$this->initForm('Commentaire',$tableauValeur);

        // génération de la vue avec les données : billet, commentaire et formulaire d'ajout de commentaire
        $this->genererVue(array('pseudo'=>$pseudo,'billet'=>$billet,'commentaires'=>$commentaires,'formulaire'=>$form->createView() ));
    }

    /**
     *
     * Méthode valider
     *
     * Cette m�thode est l'action "valider" permettant d'ajouter un commentaire sur un billet
     * Elle ne doit être exécutée que si les données insérées dans le formulaire sont valides
     *
     */
    public function valider()
    {
        // spécification de la table concernée dans la BDD
        $table = \Framework\Modeles\ManagerCommentaire::TABLE_COMMENTAIRES_BILLET;

        // récupération des paramètres de la requête
        $idBillet = $this->_requete->getParametre("id");
        //$auteur = $this->_requete->getParametre("auteur");
        $auteur = $this->_app->userHandler()->user()->pseudo();
        $contenu = $this->_requete->getParametre("contenu");

        // création du formulaire d'ajout de commentaire en l'hydratant avec les valeurs de la requête
        $form=$this->initForm('Commentaire',array('idReference'=>$idBillet,'auteur'=>$auteur,'contenu'=>$contenu,'methode'=>'post','action'=>'billet/valider'));

        $options = array();

        // si la methode est bien POST et que le formulaire est valide, insertion des données en BDD
        if (($this->_requete->getMethode()=='POST'))
        {
            if ($form->isValid())
            {
                // si le commentaire est nouveau
                if (empty($_SESSION['modifCommentaire']))
                {
                	// appelle de la m�thode permettant d'enregistrer un commentaire en BDD
                	$this->_managerCommentaire->ajouterCommentaire($table, $idBillet, $auteur, $contenu);

                	// actualisation du nbre de commentaires du billet //
                	$this->_managerBillet->actualiserNbComents($idBillet,1);

                	// actualiser l'utilisateur en BDD
                	$idUser = $this->_app->userHandler()->user()->id();
                	$nbreCommentairesForum = $this->_app->userHandler()->user()->nbreCommentairesForum();
                	$nbreCommentairesForum++;
                	$this->_app->userHandler()->managerUser()->actualiserUser($idUser,array('_nbreCommentairesForum'=>$nbreCommentairesForum));
                }
                // il s'agit d'une actualisation de commentaire
                else
                {
                    $dateModif = new \DateTime();
                	$this->_managerCommentaire->actualiserCommentaire($table, $_SESSION['modifCommentaire'], array('contenu'=>$contenu,'dateModif'=>$dateModif));
                	$this->_app->userHandler()->removeAttribute('modifCommentaire');
                }
            }
            else
            {
                 // recuperation des nom/valeur des champs valides afin de générer ultérieurement l'affichage du formulaire
                $options=$form->validField();
            }
        }
        //il s'agit sinon ou ensuite d'executer l'action par d�faut permettant d'afficher la liste des commentaires
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
    	// spécification de la table concernée dans la BDD
    	$table = \Framework\Modeles\ManagerCommentaire::TABLE_COMMENTAIRES_BILLET;

    	// récupération des paramètres de la requête
    	$idCommentaire=$this->_requete->getParametre("id");

    	// mise en tampon de l'idBillet associée au commentaire
    	$tableauBillet = $this->_managerCommentaire->getIdParent($table, $idCommentaire);

    	$idBillet = $tableauBillet["idParent"];

    	// suppression du commentaire dans la BDD
 		$resultat = $this->_managerCommentaire->supprimerCommentaire($table, $idCommentaire);

 		if($resultat)
    	{
    		$this->_app->userHandler()->setFlash('commentaire supprimé');

    	    // actualisation du nbre de commentaires du billet //
 		    $this->_managerBillet->actualiserNbComents($idBillet,-1);
    	}
    	else
    		$this->_app->userHandler()->setFlash('échec de la tentative de suppression de commentaire');

    	//il s'agit sinon ou ensuite d'executer l'action par d�faut permettant d'afficher le billet et la liste des commentaires
    	// il faut changer l'id du commentaire par l'id du billet pour afficher correctement l'index
    	$this->_requete->setParametre("id",$idBillet);
    	$this->executerAction("index",array());
    }

    /**
     *
     * Méthode modifier
     *
     * cette méthode correspond à l'action "modifier" appelée par le contrôleur lorsque l'utilisateur demande la modification d'un
     * commentaire qu'il a rédigé précédemment. Elle est également appelée lorsqu'un utilisateur souhaite faire une citation
     * Elle permet de pré remplir le formulaire de commentaire dans la page par défaut (index) avec les bonnes données
     * Elle utilise la variable superglobale S_SESSION
     *
     * @param boolean $citation, vrai s'il s'agit d'inclure une citation
     *
     */
    public function modifier($citation=NULL)
    {
    	// spécification de la table concernée dans la BDD
    	$table = \Framework\Modeles\ManagerCommentaire::TABLE_COMMENTAIRES_BILLET;

    	// récupération des paramètres de la requête
    	$idCommentaire=$this->_requete->getParametre("id");

    	// récupération du commentaire à modifier
    	$tableauCommentaire = $this->_managerCommentaire->getCommentaire($table,$idCommentaire);

    	// mise en tampon de l'idBillet associée au commentaire
    	$idBillet=$tableauCommentaire["idParent"];

    	// il s'agit d'une citation, on inclut le message dans la fenêtre d'édition d'un commentaire
    	if($citation)
    	    $tableauCommentaire['contenu']='<blockquote>'.$tableauCommentaire['auteur'].' a écrit :"'.$tableauCommentaire['contenu'].'"</blockquote>';
    	// il faut tracer cette modification jusqu'à l'actualisation du commentaire
    	else
    	    $this->_app->userHandler()->setAttribute("modifCommentaire",$idCommentaire);

    	// il s'agit d'executer l'action par d�faut permettant d'afficher le billet et la liste des commentaires
    	// en affichant le formulaire pré rempli avec le commentaire à modifier
    	// il faut changer l'id du commentaire par l'id du billet pour afficher correctement l'index
    	$this->_requete->setParametre("id",$idBillet);
    	$this->executerAction("index",$tableauCommentaire);
    }

    /**
     *
     * Méthode citer
     *
     * Elle permet d'inclure un autre commentaire dans un commentaire, ceci revient à exécuter l'action
     * "modifier"
     *
     */
    public function citer()
    {
       $citation=TRUE;
       $this->modifier($citation);
    }
}