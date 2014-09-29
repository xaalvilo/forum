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
    * cette m�thode execute l'action � r�aliser si la m�thode existe bien dans l'objet controleur associ� � cette action 
    * sinon envoie une exception (utilisation du concept de r�flexion par emploi des methode metho_exists() et get_class()
    *
    * @trows Exception si l'action n'existe pas dans la classe controleur courante
    */
     public function executerAction($action)
     {
         if (method_exists($this,$action))
        {
            $this->_action = $action;
            // appelle de la méthode portant le même nom que l'action sur l'objet Contrôleur courant
            $this->{$this->_action}();
        }
        else
        {
       //récupère la classe du Controleur correspondant à la méthode ayant pour nom l'action à réaliser
       
            $classeControleur = get_class($this);
            throw new \Exception ("Action '$action' non définie dans la classeControleur"); 
        }             
    }
    
    /**
    * cette méthode est abstraite, et oblige les classes dérivées à implémenter la méthode correspondant à l'index par défaut (quand le parametre action 
    * n'est pas défini dans la requete)
    */
    public abstract function index();
      
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