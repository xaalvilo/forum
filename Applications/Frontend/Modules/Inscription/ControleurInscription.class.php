<?php
/**
 * 
 * @author Frédéric Tarreau
 *
 * 14 dec. 2014 - ControleurInscription.class.php
 * 
 * la classe ControleurUser hérite de la classe abstraite Controleur du framework. 
*  elle utilise également la methode genererVue pour générer la vue associée à l'action
 *
 */

namespace Applications\Frontend\Modules\Inscription;
require_once './Framework/autoload.php';

class ControleurInscription extends \Framework\Controleur
{
    /* Manager de User */
    private $_managerUser;
    
    /* Gestionnaire de Login */
    private $_loginHandler;
    
    /* gestionnaire d'utilisateur */
    //private $_userHandler;
    
    /** 
    * le constructeur instancie les classes "mod�les" requises
    * Il est notamment nécessaire d'instancier un loginHandler pour générer un hash
    * 
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
    * cette m�thode est l'action par d�faut consistant � afficher le formulaire d'Inscription
    * la vue associée donne un lien vers le module d'Inscription d'un nouvel utilisateur (module User)
    * 
    * @param array $donnees tableau de données éventuellement passé en paramètre, permettant d'afficher dans le formulaire les champs valides saisis lors d'une
    * requête précédente 
    *  
    */
    public function index(array $donnees = array())
    {        
        // tableau des valeurs à prendre en compte pour le formulaire
        $tableauValeur = array('methode'=>'post','action'=>'inscription/valider');
        
        // si le tableau de données transmises n'est pas vide, le fusionner avec le tableau précédent, le tableau $donnees
        // écrasera éventuellement les valeurs du tableau $tableauValeur si les clés sont identiques (car est en second argument de la fonction
        // array_merge(..)
        if(!empty ($donnees))
        {
            $tableauValeur=array_merge($tableauValeur,$donnees);
        }
        
        // création du formulaire d'inscription et instanciation d'un objet User
        $form=$this->initForm('User',$tableauValeur);
         
        // génération de la vue avec le formulaire d'inscription
        $this->genererVue(array('formulaire'=>$form->createView()));
    }
    
    /**
     * 
     * Méthode valider
     * 
     * cette méthode correspond à l'action "valider" permettant de confirmer les éléments d'inscription de l'utilisateur
     * Elle ne doit être exécutée que si les données insérées dans le formulaire sont valides
     *
     * return_type
     *
     */
    public function valider()
    {       
        // récupération des données de la requête
        $pseudo = $this->_requete->getParametre("pseudo");
        $nom = $this->_requete->getParametre("nom");
        $prenom = $this->_requete->getParametre("prenom");
        $mail = $this->_requete->getParametre("mail");
        $telephone = $this->_requete->getParametre("telephone");
        $pays = $this->_requete->getParametre("pays");  
        $mdp = $this->_requete->getParametre("mdp"); 
        $avatar = $this->_requete->getParametre("avatar");  
        $naissance = $this->_requete->getParametre("naissance");
        
        // tableau des valeurs à prendre en compte pour le formulaire
        $tableauValeur = array ('pseudo'=> $pseudo,
                                'nom'=>$nom, 
                                'prenom'=> $prenom, 
                                'mail'=>$mail, 
                                'telephone'=>$telephone,
                                'pays'=>$pays,
                                'naissance'=>$naissance,
                                'mdp'=>$mdp,
                                'avatar'=>$avatar,
                                'methode'=>'post',
                                'action'=>'inscription/valider');

        // conversion des dates en objet datetime
        
        // création du formulaire d'inscription en l'hydratant avec les valeurs de la requête
        $form=$this->initForm('User',$tableauValeur);
        
        $options = array();
              
        // si la methode est bien POST et que le formulaire est valide, enregistrement en BDD 
        if (($this->_requete->getMethode() =='POST'))
        {             
            // le formulaire est valide
            if ($form->isValid())
            {      
                // initialisation de certaines données
                $nbreCommentairesBlog = 0;
                $nbreCommentairesForum = 0;
                $statut = \Framework\ Configuration::get('visiteur');
                
                // génération du hash à partir du mot de passe en passant par le loginHandler
                $hash = $this->_loginHandler->creerHash($mdp);               
                
                // récupération de l'adresse IP de l'utilisateur
                $ip = $this->_userHandler->getUserIp();
                 
                // préparation du tableau de paramètre pour la requête
                $param = array ($statut,$pseudo,$mail,$telephone,$avatar,$nbreCommentairesBlog,
                        $nbreCommentairesForum,$nom,$prenom,$naissance,$ip,$hash,$pays);
                
                // vérifier si l'utilisateur n'existe pas déjà en BDD en regardant si l'une des entrées
                // mail, pseudo, nom  n'existe pas déjà en BDD
                if (!$this->_managerUser->userExists())
                {    
                    // enregistrer le nouvel utilisateur en BDD
                    $this->_managerUser->ajouterUser($param);
                        
                    //TODO envoyer un flash de succès de l'inscription à l'utilisateur
                    echo "inscription réussie";
                        
                        //TODO quelle action de redirection mener ?  
                }
                // si existe déjà en BDD
                else 
                {
                    //il s'agit  d'executer l'action par d�faut permettant d'afficher à nouveau le formulaire d'inscription
                    // pré rempli avec les champs valides
                    $options=$form->validField();
                    $this->executerAction("index",$options);
                    
                    //TODO envoyer un flash de tentative d'inscription invalide à l'utilisateur
                    echo "L'inscription a échoué, l'utilisateur existe déjà";
                    
                }                      
             }
             // le formulaire est invalide
             else
             { 
                //il s'agit  d'executer l'action par d�faut permettant d'afficher à nouveau le formulaire d'inscription
                // pré rempli avec les champs valides
                 $options=$form->validField();
                 $this->executerAction("index",$options);

                 //TODO envoyer un flash de tentative d'inscription invalide à l'utilisateur
                 echo "L'inscription a échoué";
             }               
         }
         // la requet ne contenait pas de méthode POST
         else  
         {
             //il s'agit  d'executer l'action par d�faut permettant d'afficher à nouveau le formulaire d'inscription
             $this->executerAction("index",$options);
             
             //TODO envoyer un flash de tentative de connexion invalide à l'utilisateur
             echo "L'inscription a échoué";
         }           
    }
}    