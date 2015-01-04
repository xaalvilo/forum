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
    * la vue associée donne un lien vers le module d'Inscription d'un nouvel utilisateur (module User)
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
        
        // création du formulaire de connexion et instanciation d'un objet connexion
        $form=$this->initForm('Connexion',$tableauValeur);
         
        // génération de la vue avec le formulaire de connexion
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
                        
                        // Instanciation de l'objet User correspondant
                        $user = $this->_managerUser->getUser($idUser);
                                                
                        // actualisation au besoin du hash
                        if (!empty($resultat['hash']))
                        {
                            // attribution du nouveau hash
                            //$user->setHash($resultat['hash']);
                            
                            // preparation de l'Inscription en BDD
                            //$donnees['hash']=$user->hash();
                            $donnees['hash']=$resultat['hash'];
                        }
                                                
                        // actualisation de la date de connexion "now"
                        $odateConnexion = new \DateTime();
                        $donnees['dateConnexion']= $odateConnexion;
                                                
                        // actualisation des attributs de l'utilisateur avec les nouvelles données
                        $user->hydrate($donnees);

                        // Inscription des données actualisées en BB 
                        $this->_managerUser->actualiserUser($idUser, $donnees);
                        
                        //TODO envoyer un flash de connexion à l'utilisateur
                        echo "connexion réussie";
                        
                        //TODO quelle action de redirection mener ?                        
                    }
                    // le hash ne correspond pas au mdp
                    else
                    { 
                        // recuperation des nom/valeur des champs afin de générer ultérieurement l'affichage du formulaire
                        // pré rempli des champs valides s'il y a échec à l'inscription
                        $options=$form->validField();
                         
                        //il s'agit  d'executer l'action par d�faut permettant d'afficher à nouveau le formulaire de connexion
                        $this->executerAction("index",$options);
                        
                        //TODO envoyer un flash de tentative de connexion invalide à l'utilisateur
                        echo "connexion a échoué";
                    }
                }
                // la requête en BDD User n'a pas permis de trouver ce pseudo ou a échoué
                else 
                {      
                    // recuperation des nom/valeur des champs afin de générer ultérieurement l'affichage du formulaire
                    // pré rempli des champs valides s'il y a échec à l'inscription
                    $options=$form->validField();
                     
                    //il s'agit  ensuite d'executer l'action par d�faut permettant d'afficher à nouveau le formulaire de connexion
                    $this->executerAction("index",$options);
                    
                    //TODO envoyer un flash de tentative de connexion invalide à l'utilisateur
                    echo "connexion a échoué";
                }
            }
            // le formulaire est invalide
            else
            {                    
                // recuperation des nom/valeur des champs afin de générer ultérieurement l'affichage du formulaire
                // pré rempli des champs valides s'il y a échec à l'inscription
                $options=$form->validField();
                 
                //il s'agit  d'executer l'action par d�faut permettant d'afficher à nouveau le formulaire de connexion
                $this->executerAction("index",$options);
            }
         }
         // pas de méthode POST
         else 
         {
             //il s'agit  d'executer l'action par d�faut permettant d'afficher à nouveau le formulaire de connexion
             $this->executerAction("index",$options);
         }         
    }
}    