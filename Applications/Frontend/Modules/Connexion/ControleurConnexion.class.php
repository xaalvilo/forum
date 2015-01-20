<?php
/**
 * 
 * @author Frédéric Tarreau
 *
 * 30 nov. 2014 - ControleurConnexion.class.php
 * 
 * la classe ControleurConnexion hérite de la classe abstraite Controleur du framework. 
 *  elle utilise également la methode genererVue pour générer la vue associée à l'action
 *  Elle permet de :
 *  - afficher un formulaire de login
 *  - connecter l'utilisateur en vérifiant son login
 *  - déconnecter l'utilisateur en supprimant la session et ses données
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
    * la vue associée donne un lien vers le module d'Inscription d'un nouvel utilisateur (module User)
    * 
    * @param array $donnees tableau de données éventuellement passé en paramètre, permettant d'afficher dans le formulaire les champs valides saisis lors d'une
    * requête précédente 
    *  
    */
    public function index(array $donnees = array())
    {        
        if(!$this->_app->userHandler()->userAuthenticated())
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
        
            // création du formulaire de connexion et instanciation d'un objet connexion
            $form=$this->initForm('Connexion',$tableauValeur);
         
            // génération de la vue avec le formulaire de connexion
            $this->genererVue(array('formulaire'=>$form->createView()));
        }
        else
        {
            //TODO redirection interne il faut coder cette fonction
            $_GET['controleur']='Forum';
            $_GET['action']='';
            $_GET['id']='';
            $this->_app->routeur()->routerRequete($this->_app);
        }
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
     * Méthode connecter
     * 
     * cette méthode correspond à l'action "connecter" permettant de se connecter
     * Elle ne doit être exécutée que si les données insérées dans le formulaire sont valides 
     *
     */
    public function connecter()
    {
        $pseudo = $this->_requete->getParametre("pseudo");
        $mdp = $this->_requete->getParametre("mdp");

        // création du formulaire de connexion en l'hydratant avec les valeurs de la requête
        $form=$this->initForm('Connexion',array('pseudo'=>$pseudo,
                                                'mdp'=>$mdp,
                                                'methode'=>'post',
                                                'action'=>'connexion/connecter'));
        
        $options = array();
        
        // si la methode est bien POST et que le formulaire est valide, recherche du login correspondant en BDD 
        if (($this->_requete->getMethode() =='POST'))
        {                      
            // le formulaire est valide
            if ($form->isValid())
            {
                // vérification de la validité du login
                $tableauDonnees = $this->_managerUser->recherchePseudo($pseudo);            
                                                     
                if (array_key_exists('id',$tableauDonnees) && array_key_exists('_hash',$tableauDonnees))
                {
                    $hash = $tableauDonnees['_hash'];
                    
                    // vérification du hash avec le mot de passe, resultat sous forme de tableau associatif
                    $resultat = $this->_loginHandler->verifierHash($mdp, $hash);
                    
                    // si la vérification a réussi 
                    if ($resultat['valide']) 
                    {
                        $idUser = $tableauDonnees['id'];
                                                                     
                        // actualisation au besoin du hash
                        if (!empty($resultat['hash']))
                        {
                            $donnees['hash']=$resultat['hash'];
                        }
                                                
                        // actualisation de la date de connexion "now"
                        $odateConnexion = new \DateTime();
                        $donnees['_dateConnexion']= $odateConnexion;
                                                
                        // Inscription des données actualisées en BB 
                        $this->_managerUser->actualiserUser($idUser, $donnees);
                         
                         // hydratation de l'instance User créée par le UserHandler avec l'ensemble des donnees
                        $user = $this->_app->userHandler()->user();
                        $valeurAttributs = $this->_managerUser->getUser($idUser);
                        
                        // ajout de données non stockées en BBD
                        $valeurAttributs['browserVersion']=NULL;
                        $user->hydrate($valeurAttributs);     
                        
                        // regeneration de l'Id de la session en conservant les données
                        $this->_app->userHandler()->regenererIdSession();
                        
                        // utilisateur vu  comme authentifié dans la session associée
                        $this->_app->userHandler()->setUserAuthenticated();
                        
                        // remplissage de la variable $_SESSION
                        $this->_app->userHandler()->peuplerSuperGlobaleSession(array('pseudo'=>$user->pseudo(),
                                                                                     'statut'=>$user->statut(),
                                                                                     'browserVersion'=>$user->browserVersion()));
                        //envoyer un flash de connexion à l'utilisateur
                        $pseudo = $user->pseudo();
                        $this->_app->userHandler()->setFlash("Bonjour $pseudo");
                        
                        //TODO redirection interne il faut coder cette fonction
                        $_GET['controleur']='Forum';
                        $_GET['action']='';
                        $_GET['id']='';
                        $this->_app->routeur()->routerRequete($this->_app);
                    }
                    // le hash ne correspond pas au mdp
                    else
                    { 
                        // recuperation des nom/valeur des champs afin de générer ultérieurement l'affichage du formulaire
                        // pré rempli des champs valides s'il y a échec à l'inscription
                        $options=$form->validField();
                         
                        //envoyer un flash d'échec à l'utilisateur
                        $this->_app->userHandler()->setFlash('Echec de la connexion');
                        
                        //il s'agit  d'executer l'action par d�faut permettant d'afficher à nouveau le formulaire de connexion
                        $this->executerAction("index",$options);
                    }
                }
                // la requête en BDD User n'a pas permis de trouver ce pseudo ou a échoué
                else 
                {      
                    // recuperation des nom/valeur des champs afin de générer ultérieurement l'affichage du formulaire
                    // pré rempli des champs valides s'il y a échec à l'inscription
                    $options=$form->validField();
                     
                    //envoyer un flash d'échec à l'utilisateur
                    $this->_app->userHandler()->setFlash('Echec de la connexion');
                    
                    //il s'agit  ensuite d'executer l'action par d�faut permettant d'afficher à nouveau le formulaire de connexion
                    $this->executerAction("index",$options);
                }
            }
            // le formulaire est invalide
            else
            {                    
                // recuperation des nom/valeur des champs afin de générer ultérieurement l'affichage du formulaire
                // pré rempli des champs valides s'il y a échec à l'inscription
                $options=$form->validField();
                 
                //envoyer un flash de données invalide
                $this->_app->userHandler()->setFlash('Format des données saisies invalide');
                
                //il s'agit  d'executer l'action par d�faut permettant d'afficher à nouveau le formulaire de connexion
                $this->executerAction("index",$options);
            }
         }
         // pas de méthode POST
         else 
         {
             //envoyer un flash d'échec à l'utilisateur
             $this->_app->userHandler()->setFlash('Données non transmises');
             
             //il s'agit  d'executer l'action par d�faut permettant d'afficher à nouveau le formulaire de connexion
             $this->executerAction("index",$options);
         }         
    }
    
    /**
     * 
     * Méthode deconnecter
     *
     * cette méthode correspond à l'action de déconnexion de l'utilisateur.
     * Elle ne doit pourvoir s'exécuter que si l'utilisateur est déjà connecter
     * 
     */
    public function deconnecter()
    {
        $this->_app->userHandler()->detruireSession();
    }
}    