<?php
namespace Framework;
require_once './Framework/autoload.php';

/**
 *  la classe Routeur a pour rôle d'analyser une requête entrante afin d'en déduire le contrôleur à utiliser ainsi que 
 *  l'action (methode) à exécuter. Il s'agit d'un contrôleur frontal
 */

class Routeur
{     
    /* constante de classe déterminant la page d'accueil */
    const PAGE_ACCUEIL = "Accueil"; 
    
    /** 
    * Méthode principale appelée par le contrôleur frontal. Elle examine la requête et exécute l'action appropriée
    */
    public function routerRequete(Application$app)
    {      
        try 
        {
            // instanciation de l'objet Requête, Fusion des paramètres des tableaux superglobales 
            // GET et POST de la requête
            // Permet de gérer uniformément ces deux types de requête HTTP
            $requete = new Requete($app,array_merge($_GET,$_POST));
            
            // création du controleur associé à l'action de la requete
            $controleur = $this->creerControleur($requete);
            
            // détermination de l'action à exécuter
            $action= $this->creerAction($requete);
            
            // exécuter la méthode du controleur correspondant à l'action
            $controleur->executerAction($action);
        }
        catch (\Exception $e)
        {
            $this->gererErreur($e);
        }
    } 
            
    /** 
    * Méhode privée creerControleur
    * 
    * Elle permet de créer le controleur adapté à la requete entrante et renvoyant une instance de la classe
    * associée. Grâce à la redirection dans la fichier .htaccess, toutes les URL entrantes sont du type :
    * index.php?controleur=XXX&action=YYY&id=ZZZ 
    * 
    * @param Requete $requete Requête reçue
    * @return Instance d'un contrôleur
    * @throws Exception Si la création du contrôleur échoue
    */   
    private function creerControleur(Requete $requete)
    {
        // il s'agit de définir le controleur par defaut 
        $controleur = self::PAGE_ACCUEIL;
        
        // puis de créer le nom du controleur à activer
        if ($requete->existeParametre('controleur'))
        {
            $controleur=$requete->getParametre('controleur');
            
            // mettre la première lettre en majuscule par cohérence à la convention de nommage des fichiers
            // Controleur/Controleur<$controleur>.php , après avoir tout converti en minuscule 
            $controleur = ucfirst(strtolower($controleur));
        }
        
        //  création du nom de la classe controleur correspondante 
        $classeControleur = "Controleur".$controleur;
        
        // création du nom du fichier du controleur dans le répertoire "Controleur" de notre arborescence 
        $fichierControleur = "Controleur/" .$classeControleur.".class.php" ;
        
        // si ce fichier existe, instanciation de l'objet controleur associé à l'action 
        if (file_exists($fichierControleur))
        {
            // inclusion du script du controleur 
            //require($fichierControleur) ; pas utile il y a d�j� l'autoload
            
            // recuperation de l'application ex�cut�e
            $app = $requete->app();
            
            // instanciation du controleur adapté à la requête
            $NamespaceClasseControleur = "\\Controleur\\".$classeControleur;
            
            $controleur = new $NamespaceClasseControleur ($app);
            
            // le requete en paramètre est associée à ce controleur */
            $controleur->setRequete($requete);
            return $controleur ;
        }
        else
        {
            throw new \Exception ("Fichier '$fichierControleur' introuvable");
        }
    }
    
    /** 
    *  Méthode permettant de déterminer l'action à exécuter  en fonction de la requete entrante
    * 
    * @param Requete $requete Requête reçue
    * @return string $action Action à exécuter
    */   
    
    private function creerAction (Requete $requete)
    {
        //index est toujours l'action par defaut 
        $action = "index" ;
        
        // vérification de l'existence du parametre action 
        if ($requete->existeParametre('action'))
        {
            //récupération de l'action de la requete reçue
            $action = $requete->getParametre('action') ; 
        }
        
        //envoi de l'action récupérée ou de celle par défaut */
        return $action ;
    }
        
    /** 
    *  Méthode permettant de gérer les erreurs d'exécution et d'afficher les messages dans une vue dédiée aux erreurs
    *
    * @param Exception $exception Exception interceptée
    */   
    
    private function gererErreur (\Exception $exception)
    {
        $vue = new Vue('erreur');
        $vue->generer(array('msgErreur'=>$exception->getMessage()));
    }  
}  
    