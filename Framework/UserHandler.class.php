<?php
/**
 *
* @author Frédéric Tarreau
*
* 21 nov. 2014 - UserHandler.class.php
*
* Classe héritée de ApplicationComponent
*
* cette classe a pour r�le d'enregistrer les informations
* temporaires concernant l'utilisateur (classe User) sur le serveur et de g�rer sa session:
*             - assigner un attribut
*             - obtenir la valeur d'un attribut
*             - authentifier l'utilisateur
*             - assigner un message informatif
*             - récupérer ce message
*
* Rappel sur les sessions : PHP envoie au navigateur un identifiant de session et stocke des données du client
* dans un fichier correspondant à l'identifiant
*/

Namespace Framework;

// Dès l'inclusion du fichier par l'auto_load, la session se créée
// PHP essaie de lire l'identifiant fourni par l'utilisateur (cookie nommé par défaut PHPSESSID, s'il n'en existe pas ,
// il en créé un aléatoirement, l'envoie au client et créé des entrées dans le tableau $_SESSION[]
session_start();

class UserHandler extends ApplicationComponent
{
    /**
     *
     * Méthode setAttribute
     *
     * cette m�thode permet d'assigner un attribut associ� � l'utilisateur dans le tableau superglobale
     * $_SESSION
     *
     * @param mixed &attribut attribut
     * @param mixed $valeur valeur de l'attribut
     *
     */
    public function setAttribute($attribut,$valeur)
    {
        $_SESSION[$attribut] = $valeur;
    }

    /**
     *
     * Méthode getAttribute
     *
     * cette m�thode permet d'obtenir la valeur de l'attribut associ� � l'utilisateur dans le tableau super globale
     * $_SESSION
     *
     * @param mixed $attribut
     * @return mixed valeur de la variable ou NULL
     *
     */
    public function getAttribute($attribut)
    {
        return isset($_SESSION[$attribut])? $_SESSION[$attribut]: NULL;
    }

    /**
     *
     * Méthode setAuthenticated
     *
     * cette m�thode permet de pr�ciser que l'utilisateur est bien authentifi�
     *
     * @param boolean $authenticated
     * @throws \Exception si le paramètre n'est pas un booléen
     *
     */
    public function setAuthenticated($authenticated=true)
    {
        if(!is_bool($authenticated))
        {
            throw new \Exception ('la valeur sp�cifi�e � User�::authenticated doit �tre un bool�en');
        }
        $_SESSION['auth'] = $authenticated;
    }
   
    /**
     *
     * Méthode setFlash
     *
     * cette m�thode permet d'assigner un message flash informatif � l'utilisateur qui s'affichera sur
     * la page
     *
     * @param string $valeur correspondant au texte du message
     *
     */
    public function setFlash($valeur)
    {
        $_SESSION['flash'] = $valeur;
    }

    /**
     *
     * Méthode getFlash
     *
     * cette m�thode permet de r�cup�rer le message ��flash�� informatif  qui s'affichera sur
     * la page de l'utilisateur
     *
     * @return string $flash correspondant au texte du message
     *
     */
    public function getFlash()
    {
        $flash = $_SESSION['flash'];

        // destruction de la variable de session
        unset ($_SESSION['flash']);
        return $flash;
    }

    /**
     *
     * Méthode detroySession
     *
     * Cette méthode permet de mettre fin à une session, elle utilise la fonction de PHP
     * 
     * @param int $idSession
     * 
     */
    public function destroySession($idSession)
    {
        
    }
    }
}
