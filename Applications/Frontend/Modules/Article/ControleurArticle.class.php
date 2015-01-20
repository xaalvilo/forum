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
        $idArticle=$this->_requete->getParametre("id") ;
        
        // extraction de l'article de la BDD
        $article=$this->_managerArticle->getArticle($idArticle); 
        
        //extraction des commentaires associés dans la BDD
        $commentaires=$this->_managerCommentaire->getListeCommentaires($table,$idArticle);  

        $tableauValeur = array('idReference'=>$idArticle,'methode'=>'post','action'=>'article/commenter');
        
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
        $this->genererVue(array('article'=>$article,'commentaires'=>$commentaires,'formulaire'=>$form->createView()));
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
     * Méthode Commenter
     * 
     * Cette m�thode est l'action "commenter" permettant d'ajouter un commentaire sur un article
     * Elle ne doit être exécutée que si les données insérées dans le formulaire sont valides
     * 
     */
    public function commenter()
    {
        // spécification de la table concernée dans la BDD
        $table = \Framework\Modeles\ManagerCommentaire::TABLE_COMMENTAIRES_ARTICLE;
        
        // récupération des paramètres de la requête
        $idArticle = $this->requete->getParametre("id");
        $auteur = $this->_requete->getParametre("auteur");
        $contenu = $this->_requete->getParametre("contenu");
        
        // création du formulaire d'ajout de commentaire en l'hydratant avec les valeurs de la requête
        $form=$this->initForm('Commentaire',array('idReference'=>$idArticle,'auteur'=>$auteur,'contenu'=>$contenu,'methode'=>'post','action'=>'article/commenter'));
        
        $options=array();
        
        // si la methode est bien POST et que le formulaire est valide, insertion des données en BDD
        if (($this->_requete->getMethode() =='POST')) 
        {   
            if ($form->isValid())
            {
                // appelle de la m�thode permettant d'enregistrer un commentaire en BDD 
                $this->_managerCommentaire->ajouterCommentaire($table,$idArticle, $auteur, $contenu);
            }
            else 
            {
                // recuperation des nom/valeur des champs valides afin de générer ultérieurement l'affichage du formulaire
                // pour le cas d'un commentaire
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
     * commentaire qu'il a rédigé précédemment
     * 
     * return_type
     *
     */
    public function supprimer()
    {
        
    }
    
}