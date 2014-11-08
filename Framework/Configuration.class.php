<?php
namespace Framework;
/**
 * @author Fr�d�ric Tarreau
 * 
 * Classe fille de la classe AppComponent dont le r�le est la gestion de la configuration du site, permettant d'externaliser la configuration du site en dehors du code source
 * elle charge le fichier de configuration dev.ini ou prod.ini
 * 
 * 11 sept. 2014 - Configuration.class.php
 *
 */

class Configuration extends ApplicationComponent
{
    /**
    * cette classe encapsule un tableau associatif cl�s/valeurs (attribut $parametres) stockant les valeurs des paramètres de configuration. ce tableau est statique (un seul exemplaire par classe)
    * ce qui permet de l'utiliser sans instancier d'objet Configuration
    */
    private static $parametres;

    /**
    * M�thode statique publique get
    * 
    * Cette méthode permet de rechercher la valeur d'un param�tre � partir de son nom.
    * si le param�tre en question est trouvé dans le tableau associatif, la m�thode renvoie la valeur du parametre de configuration 
    * sinon une valeur par d�faut est renvoy�e
    *
    * @param string $nom Nom du param�tre
    * @param string $valeurParDefaut Valeur à renvoyer par d�faut
    * @return string Valeur du param�tre
    */
    public static function get($nom, $valeurParDefaut = null)
    {
        if(isset(self::getParametres()[$nom]))
        {
            $valeur = self::getParametres()[$nom];
        }
        else 
        {
            $valeur = $valeurParDefaut;
        }
        return $valeur;
    }

    /**
    * M�thode statique priv�e getParametres() 
    * 
    * Cette méthode effectue le chargement tardif du fichier contenant les paramètres de configuration. Afin de faire figurer sur 
    * un m�me serveur une configuration de d�veloppement  et une configuration de production, 2 fichiers sont recherchés dans le répertoire Config du site : dev.ini et prod.ini. 
    * 
    * @return array $_parametres tableau associatif des parametres de configuration
    * @throws Exception Si aucun fichier de configuration n'est trouvé
    */
    private static function getParametres()
    {
        //si le fichier n'a pas d�jà �t� charg� 
        if (self::$parametres == null)
        {
            //prendre le fichier de configuration de développement
            //$app = self::app();
            
            //Récupération du nom de l'application qui s'exécute
           // $nomApplication = $app->nom();
            $cheminFichier = "Applications/Frontend/Config/dev.ini";
           
            // s'il n'existe pas , prendre le fichier de configuration de production
            if (!file_exists($cheminFichier))
            {
                $cheminFichier = "Config/prod.ini ";
            }
            
            // si ce dernier n'existe pas non plus, envoyer une erreur 
            if (!file_exists($cheminFichier))
            {
                throw new \Exception("Aucun fichier de configuration trouv�");
            }
            
            // sinon instancier et renvoyer un tableau associatif attribué à l'attribut $_parametres grâce à la fonction parse_ini°file() qui analyse un fichier de configuration 
            // et retourne la configuration sous forme de tableau associatif
            else
            {
                self::$parametres = parse_ini_file($cheminFichier);
            }
        }
        
        // si le fichier de configuration a d�j� �t� charg�, le renvoyer
        return self::$parametres;
    }
}
                
            
