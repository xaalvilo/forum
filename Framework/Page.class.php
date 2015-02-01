<?php
/**
 * 
 * @author Frédéric Tarreau
 *
 * 10 nov. 2014 - Page.class.php
 * 
 *  la classe Page h�rite de ApplicationComponent, elle aura le r�le de g�rer la g�n�ration des diff�rentes Vues
 *
 */
namespace Framework;
require_once './Framework/autoload.php';

class Page extends ApplicationComponent
{
    use Affichage;
    
    /* @type string nom du fichier associé à la vue */
    private $_fichier;
 
    /* @type string titre de la page défini dans le fichier spécifique */
    private $_titre;
    
    /* @type array bandeau de la page */
    private $_bandeau;
    
    /* @type string message informatif */
    private $_flash;
    
    /**
    * 
    * Constructeur
    * 
    * cette méthode permet de construire le nom du fichier "vue", dans le répertoire "Vue" à partir de l'action de l'utilisateur et du controleur associé
    * chaque vue doit résider dans le sous répertoire définit dans dev.ini ou prod.ini, dans ce répertoire, chaque vue est stockée dans un sous-répertoire portant le nom du controleur 
    * associé à la vue. Chaque fichier Vue ne contient plus le terme "vue" mais porte directement le nom de l'action aboutissant à l'affichage de la vue
    *
    * @param string $action est un nom d'action à laquelle la page est associée
    * @param string $controleur est le nom du contrôleur auquel la vue est associée 
    */
     public function __construct(Application $app, $action, $controleur ="")
     {
     	parent::__construct($app);
     	
         if ($action != 'erreur')
         {
            $fichier = Configuration::get("repertoireVues");
            if ($controleur != "")
            {
                $fichier = $fichier.$controleur. "/";
            }            
         }
         else 
         {
             $fichier = Configuration::get("repertoireErreurs");
         }      
         $this->_fichier = $fichier.$action.".php";
         
         $this->_bandeau = array('connexion'=>'','pseudo'=>'');
         $this->_flash ='';
     }
     
    /**
    * 
    * Méthode generer
    * 
    * cette m�thode permet de g�n�rer et d'afficher une vue 
    *
    * @param array $donnees Donn�es n�cessaires � la g�n�ration de la vue
    * 
    */
     public function generer($donnees)
     {
        //g�n�ration du contenu sp�cifique de la vue 
        $contenu = $this->genererFichier($this->_fichier,$donnees);
       
        // génération du message flash informatif
        if($this->_app->userHandler()->user()->hasFlash())
        {
            $this->_flash = $this->_app->userHandler()->getFlash();
        }
        
        $repertoireTemplates = Configuration::get("repertoireTemplates","/");
        
        //génération du bandeau spécifique
        if($this->_app->userHandler()->user()->hasBandeau())
        {
            $this->_bandeau = $this->_app->userHandler()->getBandeau();
        }
        $fichierBandeau=$repertoireTemplates.'bandeau.php';
        $bandeau = $this->genererFichier($fichierBandeau,$this->_bandeau);
        
        // On définit une variable locale accessible par la vue pour la racine Web
        // Il s'agit du chemin vers le site sur le serveur Web. c'est nécessaire pour les URL de type controleur/action/id
        $racineWeb = Configuration::get("racineWeb","/");
  
        // spécification de la langue utilisée pour l'affichage de la date et heure
        // grâce au trait horodatage utilisé par la classe mère
    	$this->setHeureDateLocale();
        
         // génération du gabarit commun incluant la partie spécifique 
         $fichierGabarit = $repertoireTemplates.'/gabarit.php';
         $vue = $this->genererFichier($fichierGabarit,array('titre'=>$this->_titre,
                                                            'flash'=>$this->_flash,
                                                            'bandeau'=>$bandeau,
                                                            'contenu'=>$contenu,
                                                            'racineWeb'=>$racineWeb));
         
         //renvoie la vue au navigateur web 
         $this->app()->httpReponse()->send($vue);
     }
     
    /**
    * 
    * Méthode genererFichier
    * 
    * cette méthode permet de générer un fichier "vue" et de renvoyer le résultat produit dans le tampon de sortie 
    *
    * @param string $fichier Chemin du fichier vue à générer
    * @param array $donnees Données nécessaires à la génération de la vue
    *
    * @return string Résultat de la génération de la vue
    * @throws Exception Si le fichier vue est introuvable
    * 
    */
    private function genererFichier($fichier,$donnees)
    {       
         //vérification de l'existence du fichier 
         if (file_exists($fichier))
        {
            //transfert des valeurs du tableau associatif $donnees dans les variables de même nom que les index
            // de ce tableau, 
            extract($donnees);
 
            //demarrage de la temporisation de sortie 
            ob_start();
            
            //inclusion du fichier vue 
            require $fichier;
            
            //le résultat est placé dans la temporisation de sortie  arrêt de la temporisation et renvoi du tampon en sortie
            return ob_get_clean();
        }
        else 
        {
            throw new \Exception ("Fichier $fichier introuvable");
        }             
    }
    
    /**
    * SECURISATION DES DONNEES RECUES ET AFFICHEES 
    * cette méthode permet "d'échapper", c'est à dire de nettoyer toutes les données insérées dans la page pour empêcher
    * l'exécution de script et donc éviter l'injection de code sur la page web finale (faille WSS)
    * paramètres de htmlspecialchars : 
    * ENT_QUOTES 	Convertit les guillemets doubles et les guillemets simples.
    * UTF-8 	  	Unicode 8 bits multioctets, compatible avec l'ASCII 
    */
    private function nettoyer($valeur)
    {
       // TODO return htmlspecialchars($valeur, ENT_QUOTES,'UTF-8',false);
       return $valeur;
    }
}
     