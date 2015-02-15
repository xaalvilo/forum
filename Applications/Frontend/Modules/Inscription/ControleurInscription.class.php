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
     * la vérification de l'existence d'un même utilisateur (pseudo et mail ) en BDD est laissée au manager en utilisant les index UNIQUE de MySQL
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
                $statut = \Framework\Configuration::get('visiteur');
                
                // génération du hash à partir du mot de passe en passant par le loginHandler
                $hash = $this->_loginHandler->creerHash($mdp);               
                
                // récupération de l'adresse IP de l'utilisateur
                $ip = $this->_app->userHandler()->getUserIp();
                
                //TODO récupération de la version du navigateur
               
                // préparation du tableau de paramètre pour la requête
                $param = array ($statut,$pseudo,$mail,$telephone,$avatar,$nbreCommentairesBlog,
                        $nbreCommentairesForum,$nom,$prenom,$naissance,$ip,$hash,$pays);

                // enregistrer le nouvel utilisateur en BDD 
                $idUser = $this->_managerUser->ajouterUser($param);
               
                // s'il n'y a pas de doublon
                if(ctype_digit($idUser))
                {     
                    //envoyer un flash de succès de l'inscription à l'utilisateur
                    $this->_app->userHandler()->setFlash('test inscription réussie');
                                         
                    //TODO redirection interne il faut coder cette fonction
               		$_GET['controleur']='Connexion';
                 	$_GET['action']='';
                    $_GET['id']='';
                    $this->_app->routeur()->routerRequete($this->_app);
                }
                //TODO s'il y a un doublon ( existe déjà en BDD)
                else 
                {
                	// préparer le pré remplissage du formulaire avec les champs valides
                	$options=$form->validField();
                	
                	// Changement du nom de variable par un plus lisible
                	$erreur =&$idUser;
                	
                	// On vérifie que l'erreur concerne bien un doublon - Le code d'erreur 23000 signifie "doublon" dans le standard ANSI SQL      	 
                	if (23000 == $erreur[0]) 
                	{                 		 
                		// expression rationnelle appliquée sur le message d'erreur SQL pour rechercher la valeur à l'origine du doublon
                		preg_match("`Duplicate entry '(.+)' for key`", $erreur[2], $valeur_probleme);
                		
                		$valeur_probleme = $valeur_probleme[1];
                	
                		if ($pseudo == $valeur_probleme)    
                		{         			 
                			$this->_app->userHandler()->setFlash("Ce pseudo est déjà utilisé.");
                			$options['pseudo'] ='';
                		}
						else if ($mail == $valeur_probleme) 
						{
                			$this->_app->userHandler()->setFlash("Cette adresse e-mail est déjà utilisée.");
                			$options['mail'] ='';
						}
 						else 
 						{
 							$this->_app->userHandler()->setFlash("Doublon non identifié dans la base de données, reéssayez."); 
 							$options['pseudo'] ='';
 							$options['mail'] =''; 							
 						}
       				}
       				else
       				{
                    	$this->_app->userHandler()->setFlash("L'inscription a échoué, le pseudo ou le mail existe déjà");
       				}               
              
                 //il s'agit  d'executer l'action par d�faut permettant d'afficher à nouveau le formulaire d'inscription
                 // pré rempli avec les champs valides                 
                 $this->executerAction("index",$options);
                }
             }
             // le formulaire est invalide
             else
             { 
                //il s'agit  d'executer l'action par d�faut permettant d'afficher à nouveau le formulaire d'inscription
                // pré rempli avec les champs valides
                 $options=$form->validField();
                 
                 //envoyer un flash de tentative d'inscription invalide à l'utilisateur
                 $this->_app->userHandler()->setFlash("L'inscription a échoué, certains champs sont invalides");
                 
                 $this->executerAction("index",$options);
             }               
         }
         // la requete ne contenait pas de méthode POST
         else  
         {
             //envoyer un flash de tentative d'inscription invalide à l'utilisateur
             $this->_app->userHandler()->setFlash("La requête d'inscription a échoué");
             
             //il s'agit  d'executer l'action par d�faut permettant d'afficher à nouveau le formulaire d'inscription
             $this->executerAction("index",$options);
         }           
    }
}    