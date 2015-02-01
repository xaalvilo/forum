<?php
namespace Framework;
require_once './Framework/autoload.php';

/**
*  la classe Abstraite Controleur permet de définir tous les services communs aux classes controleurs 
*/

abstract class Controleur extends ApplicationComponent
{
    /* action � r�aliser par le controleur */
    private $_action;
     
    /* requ�te entrante (utilisable par les classes d�riv�es) */
    protected $_requete;
    
    /* reponse HTTP sortante */
    protected $_reponse;

    /**
    * 
    * Méthode setRequete
    * 
    * cette méthode définit la requête entrante reçue par le serveur en provenance du client
    *
    * @param Requete $requete Requête entrante
    * 
    */
     public function setRequete(Requete $requete)
     {
         $this->_requete=$requete;
     }
     
   /**
    * 
    * Méthode setReponse
    * 
    * cette méthode définit la réponse HTTP sortant envoyée au client
    * 
    * @param Reponse $reponse Reponse sortante
    * 
    */
    public function setReponse(Reponse $reponse)
    {
    	$this->_reponse=$reponse;
    }
    
   /**
    * 
    * Méthode executerAction
    * 
    * cette m�thode execute l'action � r�aliser si la m�thode existe bien dans l'objet controleur associ� � cette action 
    * sinon envoie une exception (utilisation du concept de r�flexion par emploi des methode method_exists() et get_class()
    * Si un tableau d'options est donné, elle le prendra en compte
    *
    * @param array $options tableau d'options à passer éventuellement en paramètre
    * @throws Exception si l'action n'existe pas dans la classe controleur courante
    * 
    */
     public function executerAction($action, array $options = array())
     {
         if (method_exists($this,$action))
        {
            $this->_action = $action;
            
            // appelle de la méthode portant le même nom que l'action sur l'objet Contrôleur courant
            $this->{$this->_action}($options);
        }
        else
        {
            //récupère la classe du Controleur correspondant à la méthode ayant pour nom l'action à réaliser 
            $classeControleur = get_class($this);
            throw new \Exception ("Action $action non définie dans la classeControleur"); 
        }             
    }
    
   /**
    * 
    * Methode Index
    * 
    * cette méthode est abstraite, et oblige les classes dérivées à implémenter la méthode correspondant à l'index par défaut 
    * (quand le parametre action n'est pas défini dans la requete)
    * 
    * @param array $donnees tableau de donnees en option
    * 
    */
    public abstract function index(array $donnees = array());
    
    /**
     *
     * Methode setBandeau
     *
     * cette méthode est abstraite, et oblige les classes dérivées à implémenter la méthode correspondant à l'action "bandeau"
     * qui va personnaliser le bandeau du template "gabarit" en fonction de diverses informations sur l'utilisateur
     * 
     * @param array $donnees tableau de donnees en option
     *
     */
    public function setBandeau(array $donnees = array())
    {
        $donneesBandeau['bandeau']=$donnees;
        $this->_app->userHandler()->peuplerSuperGlobaleSession($donneesBandeau);
    }
    
    /**
     *
     * Méthode initForm
     *
     * Cette méthode permet de créer l'objet entite et le formulaire associe en faisant appel au FormBuilder correspondant
     *
     * @param string $nomEntite nom de l'objet entite à instancié, issu du répertoire "Modèle" : commentaire, billet ...etc
     * @param array $donnees tableau de données permettant d'hydrater l'objet entité créé 
     * @return Form $form objet formulaire
     * 
     */
    public function initForm($nomEntite,array $donnees = array())
    {
        // mettre la première lettre en majuscule par cohérence à la convention de nommage des classes
        // avoir tout converti en minuscule
        $classeEntite = ucfirst(strtolower($nomEntite));
               
        // création du nom de la classe entite en tenant compte du namespace
        $NamespaceClasseEntite ="\\Framework\\Entites\\".$classeEntite;
                
        // il faut hydrater l'objet $entite avec les valeurs du tableau $donnees
        $entite = new $NamespaceClasseEntite($donnees);
                
        // création du nom de la classe FormBuilder du modele en tenant compte du namespace
        $NamespaceClasseFormBuilder = "\\Framework\\FormBuilder\\".$classeEntite."FormBuilder";
        
        // création du constructeur de formulaire avec l'objet monEntite instancié
        $formBuilder = new $NamespaceClasseFormBuilder($entite,$donnees['methode'],$donnees['action']);
             
        // création du formulaire 
        $formBuilder->build();
        $form = $formBuilder->form();
        return $form;
    }
    
    /**
    * 
    * Méthode genererVue
    * 
    * cette méthode entraine la generation de la vue associée au controleur courant 
    * Pour cela elle détermine le nom du repertoire de la Vue à partir du nom du controleur actuel
    * Il est rappelé que les vues spécifiques sont dans les répertoires de type :
    *                    Applications/NomApplication/Modules/NomModule
    * et le nom du contrôleur est de type : ControleurNomModule également dans ces répertoires
    *
    * @param array $donneesVue Données nécessaires pour la génération de la vue
    * 
    */
    protected function genererVue($donneesVue=array())
    {
        // récupération du nom de la classe qui sera du type Namespace\classe du controleur
        $classeControleur = get_class($this);
               
        // il faut retirer le nom du Namespace pour en extraire le nom du repertoire où doit être
        // pris le fichier Vue. 
        // Il est nécessaire de récupérer le nom de l'application en cours d'exécution
        $app = $this->_app;
        $nomApplication = $app->nom();

        // il faut déterminer la chaîne de caractère à supprimer
        $nameSpaceGenerique = "Applications\\".$nomApplication."\\Modules\\";
        $chaine = str_replace($nameSpaceGenerique,"",$classeControleur);
        
        // la chaine est de type NomModule\ControleurNomModule
        $chaine = str_replace ("\\Controleur","",$chaine);
        
        // A ce stade la chaine comporte 2 fois le NomModule
        $count = strlen($chaine);
        $cesure = -$count/2;
        $controleur =substr($chaine,0,$cesure);
        
        // generation de la page avec la vue associée 
        $page = new Page($this->_app,$this->_action,$controleur);
        $page->generer($donneesVue);
    }    
}