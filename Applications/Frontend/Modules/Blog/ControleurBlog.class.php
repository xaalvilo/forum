<?php
/**
 * 
 * @author Frédéric Tarreau
 *
 * 25 oct. 2014 - ControleurBlog.class.php
 * 
 * la classe ControleurBlog hérite de la classe abstraite Controleur du framework. 
 * elle utilise également la methode genererVue pour générer la vue associée à l'action
 * 
 */
namespace Applications\Frontend\Modules\Blog;
require_once './Framework/autoload.php';

class ControleurBlog extends \Framework\Controleur
{
    /* Manager de article */
    private $_managerArticle;
 
    /** 
    * le constructeur instancie les classes "modèles" requises
    */
    public function __construct(\Framework\Application $app) 
    {
    	parent::__construct($app);
        $this->_managerArticle= new \Framework\Modeles\ManagerArticle();
    }
     
    /**
    * 
    * Méthode index
    * 
    * cette méthode est l'action par défaut consistant à afficher l'article le plus récent du blog
    * elle créée le formulaire d'ajout de commentaire par la méthode initForm
    * 
    * @param array $donnees tableau de données éventuellement passé en paramètre, permettant d'afficher dans le formulaire les champs valides saisis lors d'une
    * requête précédente 
    *  
    */
    public function index(array $donnees = array())
    {
        //récupération du dernier article écrit
        $dernierArticle = $this->_managerArticle->getDernierArticle();
       
        // récupération de la liste des articles
        $articles = $this->_managerArticle->getArticles();
        
        // tableau des valeurs à prendre en compte pour le formulaire
        $tableauValeur = array('methode'=>'post','action'=>'blog/editer');
        
        // si le tableau de données transmises n'est pas vide, le fusionner avec le tableau précédent, le tableau $donnees
        // écrasera éventuellement les valeurs du tableau $tableauValeur si les clés sont identiques (car est en second argument de la fonction
        // array_merge(..)
        if(!empty ($donnees))
        {
            $tableauValeur=array_merge($tableauValeur,$donnees);
        }
        
        // création du formulaire d'ajout d'un article
        $form=$this->initForm('article',$tableauValeur);
         
        // génération de la vue avec les données : liste des articles et formulaire d'ajout d'article
        $this->genererVue(array('dernierArticle'=>$dernierArticle,'articles'=>$articles,'formulaire'=>$form->createView()));
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
        $titre = $this->_requete->getParametre("titre");
        $contenu = $this->_requete->getParametre("contenu");
        $image = $this->_requete->getParametre("image");
        
        // prise en compte de la date courante
        $date = new \DateTime();
        
        // création du formulaire d'ajout d'un article en l'hydratant avec les valeurs de la requête
        $form=$this->initForm('article',array('titre'=>$titre,
                                             'contenu'=>$contenu,
                                             'date'=>$date,
                                             'image'=>$image,
                                             'methode'=>'post',
                                             'action'=>'blog/editer'));
        
        // si la methode est bien POST et que le formulaire est valide, insertion des données en BDD
        if (($this->_requete->getMethode() =='POST'))
        {
            $options=array();
        
            if ($form->isValid())
            {
                // appelle de la m�thode permettant d'enregistrer un article en BDD
                $this->_managerArticle->ajouterArticle($titre,$contenu,$image);
            }
            else
            {
                // recuperation des nom/valeur des champs valides afin de générer ultérieurement l'affichage du formulaire
                $options=$form->validField();
            }
         }
        
         //il s'agit sinon ou ensuite d'executer l'action par d�faut permettant d'afficher la liste des articles
         $this->executerAction("index",$options);
    }
}    