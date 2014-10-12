<?php
namespace Framework;
require_once './Framework/autoload.php';

/**
*  la classe Abstraite Controleur permet de définir tous les services communs aux classes controleurs 
*/

abstract class Controleur extends ApplicationComponent
{
    /**  action � r�aliser par le controleur */
    private $_action;
     
    /** requ�te entrante (utilisable par les classes d�riv�es) */
    protected $requete;

    /**
    * cette méthode définit la requête entrante
    *
    * @param Requete $requete Requête entrante
    */
     public function setRequete(Requete $requete)
     {
         $this->requete=$requete;
     }
     
   /**
    * Méthode executerAction
    * 
    * cette m�thode execute l'action � r�aliser si la m�thode existe bien dans l'objet controleur associ� � cette action 
    * sinon envoie une exception (utilisation du concept de r�flexion par emploi des methode metho_exists() et get_class()
    * Si un tableau d'options est donné, elle le prendra en compte
    *
    * @param array $options tableau d'options à passer éventuellement en paramètre
    * @trows Exception si l'action n'existe pas dans la classe controleur courante
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
            throw new \Exception ("Action '$action' non définie dans la classeControleur"); 
        }             
    }
    
   /**
    * 
    * Methode Index
    * 
    * cette méthode est abstraite, et oblige les classes dérivées à implémenter la méthode correspondant à l'index par défaut 
    * (quand le parametre action n'est pas défini dans la requete)
    * 
    */
    public abstract function index(array $donnees = array());
    
    /**
     *
     * Méthode initForm
     *
     * Cette méthode permet de créer l'objet entite et le formulaire associe en faisant appel au FormBuilder correspondant
     *
     * return_type Form $form objet formulaire
     *
     * @param string $nomEntite nom de l'objet entite à instancié, issu du répertoire "Modèle" : commentaire, billet ...etc
     * @param array $donnees tableau de données permettant d'hydrater l'objet entité créé
     */
    public function initForm($nomEntite,array $donnees = array())
    {
        // mettre la première lettre en majuscule par cohérence à la convention de nommage des classes
        // avoir tout converti en minuscule
        $classeEntite = ucfirst(strtolower($nomEntite));
               
        //  création du nom de la classe entite en tenant compte du namespace
        $NamespaceClasseEntite ="\\Modele\\".$classeEntite;
                
        // il faut hydrater l'objet $entite avec les valeurs du tableau $donnees
        $entite = new $NamespaceClasseEntite($donnees);
        
        //  création du nom de la classe FormBuilder du modele en tenant compte du namespace
        $NamespaceClasseFormBuilder = $NamespaceClasseEntite."FormBuilder";
        
        // création du constructeur de formulaire avec l'objet monEntite instancié
        $formBuilder = new $NamespaceClasseFormBuilder($entite,$donnees['methode'],$donnees['action']);
             
        // création du formulaire 
        $formBuilder->build();
        $form = $formBuilder->form();
        return $form;
    }
    
    /**
    * cette méthode entraine la generation de la vue associée au controleur courant 
    *
    * @param array $donneesVue Données nécessaires pour la génération de la vue
    */
    protected function genererVue($donneesVue=array())
    {
        //détermination du  nom du fichier Vue à partir du nom du controleur actuel
        $classeControleur = get_class($this);
              
        // suppression de la chaîne de caractère "Controleur\Controleur"  dans le nom de la classe
        $controleur = str_replace("Controleur\\Controleur","",$classeControleur);
        
        // generer la vue associée 
        $vue = new Vue($this->_action,$controleur);
        $vue->generer($donneesVue);
    }      
}