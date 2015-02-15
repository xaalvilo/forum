<?php
/**
 * 
 * @author Frédéric Tarreau
 *
 * 28 oct. 2014 - ControleurArticle.class.php
 * 
 *  La classe ControleurArticle h�rite de la classe abstraite Controleur du framework. Il s'agit du contrôleur des actions liées aux Articlets
 *  Elle utilise les services de la classe Requete pour accéder aux parametres de la requete. 
 *  elle utilise également la methode executerAction de sa superclasse afin d'actualiser les détails sur l'Article, et genererVue pour 
 *  générer la vue associée à l'action
 *
 */

namespace  Applications\Frontend\Modules\Article;
use Modele\CommentaireFormBuilder;
use Modele\Commentaire;
require_once './Framework/autoload.php';

class ControleurArticle extends \Framework\Controleur
{
    /* manager de article */
    private $_managerArticle;
   
    /* manager de commentaire */
    private $_managerCommentaire;
    
    /** 
    * le constructeur instancie les classes "mod�les" requises
    */
     public function __construct(\Framework\Application $app) 
     {
     	 parent::__construct($app);
         $this->_managerArticle= new \Framework\Modeles\ManagerArticle();
         $this->_managerCommentaire= new \Framework\Modeles\ManagerCommentaire();
     }
     
    /**
    * 
    * Méthode Index
    * 
    * cette m�thode est l'action par d�faut consistant � afficher la liste des commentaires associ�s � un article
    * elle utilise les m�thodes getter des mod�les instanci�s pour r�cup�rer les donn�es n�cessaires aux vues
    * elle créée le formulaire d'ajout de commentaire par la méthode initForm
    * 
    * @param array $donnees tableau de données optionnel, permettant d'afficher dans le formulaire les données de champs valides saisis lors d'une
    * requête précédente
    * 
    */
    public function index(array $donnees = array())
    {
        // spécification de la table concernée dans la BDD
        $table = \Framework\Modeles\ManagerCommentaire::TABLE_COMMENTAIRES_ARTICLE;
        
        //récupération des paramètres de la requête
        $idArticle=$this->_requete->getParametre("id");
        
        // extraction de l'article de la BDD
        $article=$this->_managerArticle->getArticle($idArticle); 
        
        //extraction des commentaires associés dans la BDD
        $commentaires=$this->_managerCommentaire->getListeCommentaires($table,$idArticle);  

        $tableauValeur = array('idReference'=>$idArticle,'methode'=>'post','action'=>'article/commenter');
        
        //il faut préremplir le champ avec le pseudo fourni
     	$donnees['auteur']=$this->_app->userHandler()->user()->pseudo();
     	$pseudo = $donnees['auteur'];
       
        // si le tableau de données transmises n'est pas vide, le fusionner avec le tableau précédent, le tableau $donnees
        // écrasera éventuellement les valeurs du tableau $tableauValeur si les clés sont identiques (car est en second argument de la fonction
        // array_merge(..)
        if(!empty ($donnees))
        {
            $tableauValeur=array_merge($tableauValeur,$donnees);
        }
  
        // création du formulaire d'ajout de commentaire 
        $form=$this->initForm('Commentaire',$tableauValeur);
         
        // génération de la vue avec les données : article, commentaire et formulaire d'ajout de commentaire
        $this->genererVue(array('pseudo'=>$pseudo,'article'=>$article,'commentaires'=>$commentaires,'formulaire'=>$form->createView()));
    }
    
    /**
     * 
     * Méthode Commenter
     * 
     * Cette m�thode est l'action "commenter" permettant d'ajouter un commentaire sur un article
     * Elle ne doit être exécutée que si les données insérées dans le formulaire sont valides
     * 
     */
    public function commenter()
    {
        $options=array();
        
        // l'utilisateur est autorisé 
    	if($this->_app->userHandler()->isAutorised())
        {
        	// spécification de la table concernée dans la BDD
        	$table = \Framework\Modeles\ManagerCommentaire::TABLE_COMMENTAIRES_ARTICLE;
        
        	// récupération des paramètres de la requête
        	$idArticle = $this->_requete->getParametre("id");
        	$auteur = $this->_requete->getParametre("auteur");
        	$contenu = $this->_requete->getParametre("contenu");
        
        	// création du formulaire d'ajout de commentaire en l'hydratant avec les valeurs de la requête
        	$form=$this->initForm('Commentaire',array('idReference'=>$idArticle,'auteur'=>$auteur,'contenu'=>$contenu,'methode'=>'post','action'=>'article/commenter'));
 
        	// si la methode est bien POST et que le formulaire est valide, insertion des données en BDD
        	if (($this->_requete->getMethode() =='POST')) 
        	{   
            	if ($form->isValid())
            	{
            		// si le commentaire est nouveau
            		if (empty($_SESSION['modifCommentaire']))
            		{
                		// appelle de la m�thode permettant d'enregistrer un commentaire en BDD 
                		$this->_managerCommentaire->ajouterCommentaire($table,$idArticle, $auteur, $contenu);
                
                		// actualiser l'utilisateur en BDD
                		$idUser = $this->_app->userHandler()->user()->id();
                		$nbreCommentairesBlog = $this->_app->userHandler()->user()->nbreCommentairesBlog();
                		$nbreCommentairesBlog++;
                		$this->_app->userHandler()->managerUser()->actualiserUser($idUser,array('_nbreCommentairesBlog'=>$nbreCommentairesBlog));
                	}
                	// il s'agit d'une actualisation de commentaire
                	else
                	{
                		$this->_managerCommentaire->actualiserCommentaire($table, $_SESSION['modifCommentaire'], $contenu);
                		$this->_app->userHandler()->removeAttribute('modifCommentaire');
                	}
            	}
            	else 
            	{
                	// recuperation des nom/valeur des champs valides afin de générer ultérieurement l'affichage du formulaire
                	// pour le cas d'un commentaire
                	$options=$form->validField();
            	}
        	}
        }
        // l'utilisateur n'est pas autorisé
        else 
        {
        	//TODO ICI
        	$this->_app->userHandler()->setFlash("vous n'êtes pas autorisé à commenter sur ce blog, merci de vous inscrire");
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
    	$table = \Framework\Modeles\ManagerCommentaire::TABLE_COMMENTAIRES_ARTICLE;
    	
    	// récupération des paramètres de la requête
    	$idCommentaire=$this->_requete->getParametre("id");
    	
    	// mise en tampon de l'idBillet associée au commentaire
    	$tableauArticle = $this->_managerCommentaire->getIdParent($table, $idCommentaire);
    	$idArticle= $tableauArticle["idParent"];
    	
    	// suppression du commentaire dans la BDD
 		$resultat = $this->_managerCommentaire->supprimerCommentaire($table, $idCommentaire);
    	
    	if($resultat)
    		$this->_app->userHandler()->setFlash('commentaire supprimé');
    	else    	
    		$this->_app->userHandler()->setFlash('échec de la tentative de suppression');
    	
    	//il s'agit sinon ou ensuite d'executer l'action par d�faut permettant d'afficher l'Article et la liste des commentaires
    	// il faut changer l'id du commentaire par l'id de l'article pour afficher correctement l'index
    	$this->_requete->setParametre("id",$idArticle);
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
    	// spécification de la table concernée dans la BDD
    	$table = \Framework\Modeles\ManagerCommentaire:: TABLE_COMMENTAIRES_ARTICLE;
    	 
    	// récupération des paramètres de la requête
    	$idCommentaire=$this->_requete->getParametre("id");
    	
    	//récupératuion du commentaire à modifier 
    	$tableauCommentaire = $this->_managerCommentaire->getCommentaire($table, $idCommentaire);
    	
    	// mise en tampon de l'idBillet associée au commentaire
    	$idArticle = $tableauCommentaire["idParent"];
    	
    	// il faut tracer cette modification jusqu'à l'actualisation du commentaire
    	$this->_app->userHandler()->setAttribute('modifCommentaire',$idCommentaire);
    	
    	//il s'agit d'executer l'action par d�faut permettant d'afficher l'article et la liste des commentaires
    	// en affichant le formulaire pré rempli avec le commentaire à modifier
    	// il faut changer l'id du commentaire par l'id du article pour afficher correctement l'index
    	$this->_requete->setParametre("id", $idArticle);
    	$this->executerAction("index", $tableauCommentaire);
    }
    
}