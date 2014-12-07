<?php
/**
 * 
 * @author Frédéric Tarreau
 *
 * 3 oct. 2014 - ControleurUser.class.php
 * 
 *  La classe ControleurUser h�rite de la classe abstraite Controleur du framework.
 *  
 *  Il s'agit du contrôleur des actions liées aux utilisateurs
 *  Elle utilise les services de la classe Requete pour accéder aux parametres de la requete. 
 *  elle utilise également la methode executerAction de sa superclasse afin d'actualiser les détails sur les utilisateurs, et genererVue pour 
 *  générer la vue associée à l'action
 *
 */

namespace  Applications\Frontend\Modules\User;
use Modele\CommentaireFormBuilder;
use Modele\Commentaire;
require_once './Framework/autoload.php';

class ControleurUser extends \Framework\Controleur
{
    /* manager de User */
    private $_managerUser;
       
    /** 
    * le constructeur instancie les classes "mod�les" requises
    */
     public function __construct(\Framework\Application $app) 
     {
     	 parent::__construct($app);
         $this->_managerUser= new \Framework\Modeles\ManagerUser();        
     }
     
    /**
    * 
    * Méthode Index
    * 
    * cette méthode est l'action par défaut consistant � afficher le formulaire d'enregistrement d'un nouvel utilisateur  
    * elle utilise les m�thodes getter des mod�les instanciés pour récup�rer les donn�es n�cessaires aux vues
    * elle créée le formulaire d'enregistrement par la méthode initForm
    * 
    * @param array $donnees tableau de données optionnel, permettant d'afficher dans le formulaire les données de champs valides saisis lors d'une
    * requête précédente
    * 
    */
    public function index(array $donnees = array())
    {
        // récupération des paramètres de la requête
        $idUser=$this->_requete->getParametre("id");
        
        // extraction du User concerné dans la BDD
        $User=$this->_managerUser->getUser($idUser); 
        
        $tableauValeur = array('methode'=>'post','action'=>'user/enregistrer');
        
        // si le tableau de données transmises n'est pas vide, le fusionner avec le tableau précédent, le tableau $donnees
        // écrasera éventuellement les valeurs du tableau $tableauValeur si les clés sont identiques (car est en second argument de la fonction
        // array_merge(..)
        if(!empty ($donnees))
        {
            $tableauValeur=array_merge($tableauValeur,$donnees);
        }
  
        // création du formulaire d'enregistrement
        $form=$this->initForm('Commentaire',$tableauValeur);
         
        // génération de la vue avec les données : User, commentaire et formulaire d'ajout de commentaire
        $this->genererVue(array('User'=>$User,'commentaires'=>$commentaires,'formulaire'=>$form->createView()));
    }
    
    /**
     * 
     * Méthode Enregistrer
     * 
     * Cette m�thode est l'action "enregistrer" permettant d'enregistrer un nouvel utilisateur
     * Elle ne doit être exécutée que si les données insérées dans le formulaire sont valides
     * 
     */
    public function enregistrer()
    {
       
        
        // récupération des paramètres de la requête
        $idUser = $this->_requete->getParametre("id");
        $auteur = $this->_requete->getParametre("auteur");
        $contenu = $this->_requete->getParametre("contenu");
        
        // création du formulaire d'ajout de commentaire en l'hydratant avec les valeurs de la requête
        $form=$this->initForm('Commentaire',array('idReference'=>$idUser,'auteur'=>$auteur,'contenu'=>$contenu,'methode'=>'post','action'=>'User/commenter'));
        
        // si la methode est bien POST et que le formulaire est valide, insertion des données en BDD
        if (($this->_requete->getMethode() =='POST')) 
        {   
            $options=array();
            
            if ($form->isValid())
            {
                // appelle de la m�thode permettant d'enregistrer un commentaire en BDD 
                $this->_managerCommentaire->ajouterCommentaire($table, $idUser, $auteur, $contenu);
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