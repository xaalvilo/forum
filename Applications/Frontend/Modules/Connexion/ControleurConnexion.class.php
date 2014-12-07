<?php
/**
 * 
 * @author Frédéric Tarreau
 *
 * 30 nov. 2014 - ControleurConnexion.class.php
 * 
 * la classe ControleurConnexion hérite de la classe abstraite Controleur du framework. 
*  elle utilise également la methode genererVue pour générer la vue associée à l'action
 *
 */

namespace Applications\Frontend\Modules\Connexion;
require_once './Framework/autoload.php';

class ControleurConnexion extends \Framework\Controleur
{
    /* Manager de User */
    private $_managerUser;
    
    /* Gestionnaire de Login */
    private $_loginHandler;
     
    /** 
    * le constructeur instancie les classes "mod�les" requises
    * il sera nécessaire de vérifier dans la base des utilisateurs l'exsitence du login
    */
    public function __construct(\Framework\Application $app) 
    {
    	parent::__construct($app);
        $this->_managerUser= new \Framework\Modeles\ManagerUser();
        $this->_loginHandler = new \Framework\LoginHandler($app);     
    }
     
    /**
    * 
    * Méthode index
    * 
    * cette m�thode est l'action par d�faut consistant � afficher le formulaire de login
    * la vue associée donne un lien vers le module d'enregistrement d'un nouvel utilisateur (module User)
    * 
    * @param array $donnees tableau de données éventuellement passé en paramètre, permettant d'afficher dans le formulaire les champs valides saisis lors d'une
    * requête précédente 
    *  
    */
    public function index(array $donnees = array())
    {        
        // tableau des valeurs à prendre en compte pour le formulaire
        $tableauValeur = array('methode'=>'post','action'=>'connexion/connecter');
        
        // si le tableau de données transmises n'est pas vide, le fusionner avec le tableau précédent, le tableau $donnees
        // écrasera éventuellement les valeurs du tableau $tableauValeur si les clés sont identiques (car est en second argument de la fonction
        // array_merge(..)
        if(!empty ($donnees))
        {
            $tableauValeur=array_merge($tableauValeur,$donnees);
        }
        
        // création du formulaire de login et instanciation d'un objet login
        $form=$this->initForm('Connexion',$tableauValeur);
         
        // génération de la vue avec le formulaire de login
        $this->genererVue(array('formulaire'=>$form->createView()));
    }
    
    /**
     * 
     * Méthode connecter
     * 
     * cette méthode correspond à l'action "connecter" permettant de se connecter
     * Elle ne doit être exécutée que si les données insérées dans le formulaire sont valides
     *
     * return_type
     *
     */
    public function connecter()
    {
        $pseudo = $this->_requete->getParametre("pseudo");
        $mdp = $this->_requete->getParametre("mdp");
               
        // prise en compte de la date courante
       // $date = new \DateTime();
        
        // création du formulaire de connexion en l'hydratant avec les valeurs de la requête
        $form=$this->initForm('Connexion',array('pseudo'=>$pseudo,
                                             'mdp'=>$mdp,
                                             'methode'=>'post',
                                             'action'=>'connexion/connecter'));
        
        // si la methode est bien POST et que le formulaire est valide, recherche du login correspondant en BDD 
        if (($this->_requete->getMethode() =='POST'))
        {
            $options=array();
        
            // le formulaire est valide
            if ($form->isValid())
            {
                // vérification de la validité du login
                $user = $this->_managerUser->recherchePseudo($pseudo);
                 
                if ($user instanceof \Framework\Entites\User)
                {
                    // récupération du hash de l'utilisateur
                    $hash = $user->hash();
                    
                    // vérification du hash avec le mot de passe
                    $resultat = $this->_loginHandler->verfierHash($mdp, $hash);
                    
                    // si la vérification à réussi
                    if ($resultat)
                    {
                        // actualisation de la date de connexion "now"
                        $dateConnexion = new \DateTime();
                        $user->setDateConnexion($dateConnexion);
                        
                        //TODO envoyer un flash de connexion à l'utilisateur
                        echo "connexion réussie";
                        
                    }
                    else
                    {
                        //il s'agit  d'executer l'action par d�faut permettant d'afficher à nouveau le formulaire de connexion
                        $this->executerAction("index",$options);
                    }
                }
                // la requête en BDD User n'a pas permis de trouver ce pseudo ou a échoué
                else 
                {                    
                    //il s'agit  ensuite d'executer l'action par d�faut permettant d'afficher à nouveau le formulaire de connexion
                    $this->executerAction("index",$options);
                }
            }
            // le formulaire est invalide
            else
            {
                // recuperation des nom/valeur des champs valides afin de générer ultérieurement l'affichage du formulaire
                $options=$form->validField();
                
                //il s'agit  d'executer l'action par d�faut permettant d'afficher à nouveau le formulaire de connexion
                $this->executerAction("index",$options);
            }
         }         
    }
}    