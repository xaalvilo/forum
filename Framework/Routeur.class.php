<?php
namespace Framework;
require_once './Framework/autoload.php';

/**
 *  la classe Routeur hérite de la classe ApplicationComponent et a pour rôle d'analyser une requête entrante afin d'en déduire le contrôleur à utiliser ainsi que
 *  l'action (methode) à exécuter. Il s'agit d'un contrôleur frontal
 */

class Routeur extends ApplicationComponent
{
    /* constante de classe déterminant la page d'accueil */
    const PAGE_ACCUEIL = "Accueil";

    /* controleur généré */
    protected $_controleur;

    /**
     *
     * Méthode controleur
     *
     * getter du controleur généré
     *
     *@return \Framework\Controleur
     */
    public function controleur()
    {
        return $this->_controleur;
    }

    /**
    *
    *  Méthode routerRequête
    *
    *  cette méthode principale appelée par le contrôleur frontal examine la requête et exécute l'action appropriée
    *  elle génére une erreur si une exception est levée au cours des principales étapes de construction de la réponse à la requête
    *
    *  @param Application $app
    *
    */
    public function routerRequete(Application $app)
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
        if ($requete->existeParametre('controleur')){
            $controleur=$requete->getParametre('controleur');

            // mettre la première lettre en majuscule par cohérence à la convention de nommage des fichiers
            // Controleur/Controleur<$controleur>.php , après avoir tout converti en minuscule
            $controleur = ucfirst(strtolower($controleur));
        }

        //  création du nom de la classe controleur correspondante
        $classeControleur = "Controleur".$controleur;

        // création du nom du fichier du controleur dans le répertoire suivant :
        // Applications/$nomApplication/Modules/$controleur/ de notre arborescence
        // cela nécessite la récuperation de l'application ex�cut�e
        $app = $requete->app();
        $nomApplication = $app->nom();

        $repertoireControleur = "Applications/".$nomApplication."/Modules/".$controleur."/";

        $fichierControleur =  $repertoireControleur.$classeControleur.".class.php" ;

        // si ce fichier existe, instanciation de l'objet controleur associé à l'action
        if (file_exists($fichierControleur)){
            // création de l'espace de nom correspondant
            $NamespaceClasseControleur = "\\Applications\\".$nomApplication."\\Modules\\".$controleur."\\".$classeControleur;

            // instanciation du controleur adapté à la requête
            $controleur = new $NamespaceClasseControleur($app);
            $this->_controleur = $controleur;

            // la requete en paramètre est associée à ce controleur */
            $controleur->setRequete($requete);
            return $controleur ;
        } else throw new \Exception ("Fichier '$fichierControleur' introuvable");
    }

    /**
    *
    *  Méthode creerAction
    *
    *  Méthode permettant de déterminer l'action à exécuter en fonction de la requete entrante
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
            //récupération de l'action de la requete reçue
            $action = $requete->getParametre('action');

        //envoi de l'action récupérée ou de celle par défaut */
        return $action ;
    }

    /**
    *
    *  Méthode gererErreur
    *
    *  Méthode permettant de gérer les erreurs d'exécution et d'afficher les messages dans une vue dédiée aux erreurs
    *
    * @param Exception $exception Exception interceptée
    *
    */
    private function gererErreur (\Exception $exception)
    {

        // si l'erreur intervient après que l'objet Page associé à l'application ait été instancié par le controleur
        // il faut le détruire
       // if ($this->_page instanceof Page)
       // {
            //il faut détruire l'objet page et le remplacer
       // }

        // creation de la page de réponse
        $page = new Page($this->_app,'erreur');

        // génération de la vue spécifique avec les données propres à l'erreur
        $page->generer(array('msgErreur'=>$exception->getMessage()));
    }
}
