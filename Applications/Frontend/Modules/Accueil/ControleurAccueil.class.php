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
    /* Manager de article */
    //private $_managerArticle;
 
    /** 
    * le constructeur instancie les classes "modèles" requises
    */
    public function __construct(\Framework\Application $app) 
    {
    	parent::__construct($app);
        //$this->_managerArticle= new \Framework\Modeles\ManagerArticle();
        $id = session_id();
    	echo $id;
        var_dump($_SESSION);
    }
     
    /**
    * 
    * Méthode index
    * 
    * cette méthode est l'action par défaut consistant à afficher la liste de tous les articles du blog
    * elle créée le formulaire d'ajout de commentaire par la méthode initForm
    * 
    * @param array $donnees tableau de données éventuellement passé en paramètre, permettant d'afficher dans le formulaire les champs valides saisis lors d'une
    * requête précédente 
    *  
    */
    public function index(array $donnees = array())
    {
        // récupération de la liste des articles
       // $articles = $this->_managerArticle->getArticles();  
       
        // tableau des valeurs à prendre en compte pour le formulaire
      //  $tableauValeur = array('methode'=>'post','action'=>'blog/editer');
        
        // si le tableau de données transmises n'est pas vide, le fusionner avec le tableau précédent, le tableau $donnees
        // écrasera éventuellement les valeurs du tableau $tableauValeur si les clés sont identiques (cazr est en second argument de la fonction
        // array_merge(..)
      //  if(!empty ($donnees))
      //  {
      //      $tableauValeur=array_merge($tableauValeur,$donnees);
      //  }
        
        // création du formulaire d'ajout de article
      //  $form=$this->initForm('article',$tableauValeur);
         
        // génération de la vue avec les données : liste des articles et formulaire d'ajout de commentaire
        $this->genererVue();
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
      
    }
}    