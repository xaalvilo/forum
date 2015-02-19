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
*             - assigner un message informatif
*             - récupérer ce message
*             - définir un statut
*             - obtenir son adresse IP
*
* Rappel sur les sessions : PHP envoie au navigateur un identifiant de session et stocke des données du client
* dans un fichier correspondant à l'identifiant
*/
namespace Framework;
require_once './Framework/autoload.php';

class UserHandler extends ApplicationComponent
{
    /* objet session */
    protected $_session;

    /* objet User */
    protected $_user;

    /* objet manager User */
    protected $_managerUser;

    /**
     *
     * Méthode __construct
     *
     * constructeur avec injection de dépendances, la classe UserHandler ayant besoin de la classe Session
     *
     * @param Session $_session
     * @param array $donnees
     */
    public function __construct(Application $app,\Framework\Entites\Session $session, \Framework\Entites\User $user)
    {
        parent::__construct($app);
        $this->_session = $session;
        $this->_user = $user;
        $this->_managerUser = new \Framework\Modeles\ManagerUser();
    }

    /**
     *
     * Méthode session
     *
     * getter de l'atttribut session (objet \Framework\Entites\Session)
     *
     * @return \Framework\Entites\Session
     */
    public function session()
    {
        return $this->_session;
    }

    /**
     *
     * Méthode setSession
     *
     * setter de l'attribut session
     *
     * @param \Framework\Entites\Session $session
     */
    public function setSession(\Framework\Entites\Session $session)
    {
        $this->_session = $session;
    }

    /**
     *
     * Méthode user
     *
     * getter de l'attribut user
     *
     * @return \Framework\Entites\User
     */
    public function user()
    {
        return $this->_user;
    }

    /**
     * Méthode setUser
     *
     * setter de l'attribut user
     *
     * @param \Framework\Entites\User $user
     */
    public function setUser($user)
    {
        $this->_user=$user;
    }

    /**
     *
     * Méthode setAttribute
     *
     * cette m�thode permet d'assigner un attribut associ� � l'utilisateur à l'objet Session
     *
     * @param string $cle
     * @param mixed $valeur valeur de l'attribut
     */
    public function setAttribute($cle,$valeur)
    {
        $this->_session->set($cle, $valeur) ;
    }

    /**
     * Méthode managerUser
     *
     * getter de l'attribut managerUser
     *
     * @return \Framework\Modeles\ManagerUser
     */
    public function managerUser()
    {
    	return $this->_managerUser;
    }

    /**
     *
     * Méthode removeAttribute
     *
     * cette methode permet de supprimer une donnée de la superglobale $_SESSION
     *
     * @param string $cle
     */
    public function removeAttribute($cle)
    {
        $this->_session->remove($cle);
    }

    /**
     *
     * Méthode getAttribute
     *
     * cette m�thode permet d'obtenir la valeur de l'attribut associ� � l'utilisateur dans le tableau super globale
     * $_SESSION
     *
     * @param string $cle
     * @return mixed valeur de la variable ou NULL
     *
     */
    public function getAttribute($cle)
    {
        return $this->_session->get($cle);
    }

    /**
     *
     * Méthode setUserAuthenticated
     *
     * cette m�thode permet de pr�ciser que l'utilisateur est bien authentifi�
     *
     * @param boolean $authenticated
     * @throws \Exception si le paramètre n'est pas un booléen
     *
     */
    public function setUserAuthenticated($authenticated=true)
    {
        if(!is_bool($authenticated))
        {
            throw new \Exception ('la valeur sp�cifi�e � User�::authenticated doit �tre un bool�en');
        }
        $this->_user->setAuthenticated($authenticated);
        $this->setAttribute('user', array('authenticated'=>$authenticated));
        if($authenticated)
            $this->peuplerSuperGlobaleSession(array('user'=>array('browserVersion'=>$this->_user->browserVersion(),
                                                                    'ip'=>$this->_user->ip())));
    }

    /**
     *
     * Méthode IsUserAuthenticated
     *
     * cette m�thode permet de v�rifier que l'utilisateur est bien authentifi�
     *
     * @return Boolean, valeur de retour TRUE si authentifié
     *
     */
    public function IsUserAuthenticated()
    {
        // verification contre le vol de session par comparaison du couple IP, Version du navigateur
        $ip = $this->getUserIp();
        $browserVersion = $this->getUserBrowserVersion();

        return isset($_SESSION['user']['authenticated'])
                && $_SESSION['user']['authenticated'] === true
                && $ip === $_SESSION['user']['ip']
                && $browserVersion === $_SESSION['user']['browserVersion'];
    }

    /**
     *
     * Méthode setAutorised
     *
     * cette m�thode permet de pr�ciser que l'utilisateur est bien autorisé
     *
     * @param boolean $autorised
     * @throws \Exception si le paramètre n'est pas un booléen
     *
     */
    public function setUserAutorised($autorised=true)
    {
        if(!is_bool($autorised))
        {
            throw new \Exception ('la valeur sp�cifi�e � User�::autorised doit �tre un bool�en');
        }
        $this->_user->setAutorised($autorised);
        $this->setAttribute('user', array('autorised'=>true));
    }

    /**
     *
     * Méthode IsUserAutorised
     *
     * cette m�thode permet de v�rifier que l'utilisateur est bien autorisé à commenter sur le Blog
     *
     * @return Boolean, valeur de retour TRUE si autorisé
     *
     */
    public function IsUserAutorised()
    {
    	// si l'utilisateur est authenifié, il est automatiquement autorisé
    	if ($this->IsUserAuthenticated())
    		return TRUE;
    	else
    		return isset($_SESSION['user']['autorised']) && $_SESSION['user']['autorised'] === TRUE;
    }

    /**
     *
     * Méthode peuplerSuperGlobaleSession
     *
     * cette méthode permet d'enregistrer des variables dans la superglobale $_SESSION
     *
     * @param array $donnees
     */
    public function peuplerSuperGlobaleSession(array $donnees)
    {
        foreach ($donnees as $cle=>$valeur)
        {
            $this->setAttribute($cle, $valeur);
        }
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
        $this->setAttribute('flash', $valeur);
    }

    /**
     *
     * Méthode getFlash
     *
     * cette m�thode permet de r�cup�rer le message ��flash�� informatif  qui s'affichera sur
     * la page de l'utilisateur sur la dernière page construite
     *
     * @return string $flash correspondant au texte du message
     *
     */
    public function getFlash()
    {
        $flash = $this->getAttribute('flash');
        $this->removeAttribute('flash');
        return $flash;
    }

    /**
     *
     * Méthode getBandeau
     *
     * cette m�thode permet de r�cup�rer le bandeau permanent pour l'afficher durant la session
     *
     * @return array $bandeau correspondant aux donnees du bandeau
     *
     */
    public function getBandeau()
    {
        return (isset($_SESSION['bandeau'])) ? $_SESSION['bandeau']: NULL;
    }

    /**
     *
     * Méthode regenerIdSession
     *
     * méthode permettant de regénérer l'Id de session sans détruire les données de session associées
     * utilise pour cela la fonction session_regenerate_id() de PHP avec l'option delete_old_session = FALSE
     * par défaut. la nouvelle session PHP conserve les données de l'ancienne, l'ancienne session et son cookie
     * ont une durée de vie de 30 secondes
     *
     *@param bool TRUE pour détruire également les données de session dans la BDD
     */
    public function regenererIdSession($delete_old_session=NULL)
    {
        if (!$delete_old_session)
        {
            // modification de la durée d'expiration de la session en cours PHP (après 30 s)
            $this->_session->setMaxLifeDatetime(30);
            $NewMaxLifeDatetime=$this->_session->maxLifeDatetime()->format('Y-m-d H:i:s');
            $oldIdentifiant = $this->_session->identifiant();
            $this->_app->sessionHandler()->managerSession()->actualiserSession($oldIdentifiant, $NewMaxLifeDatetime);
            $this->detruireCookieSession(30);

			// creation d'une session PHP sans détruire la précédente
            if(session_regenerate_id($delete_old_session))
            {
                // recupération du nouvelle identifiant dans l'objet Session
                $newIdentifiant = session_id();
                $this->_session->setIdentifiant($newIdentifiant);

                // fermeture des sessions pour permettre à d'autres scripts de les utiliser
                session_write_close();

                // reprise de la nouvelle session PHP
                session_id($newIdentifiant);

                // il faut bien spécifier que le nouveau cookie de session est valable pour tout le site Forum
                $path = \Framework\Configuration::get('racineWeb');
                $this->_session->setParamCookieSession(0,$path);
                session_start();
            }
            else
            {
            	throw new \Exception ("erreur regénération identifiant de session  après login");
            }
        }
    }

    /**
     *
     * Méthode detruireCookieSession
     *
     * méthode de destruction d'un cookie en lui mettant une durée de vie courte
     *
     *@param int $maxLifetime durée de vie restante ne seconde
     */
    public function detruireCookieSession($maxLifetime)
    {
        // Destruction du cookie de session
        if(ini_get("session.use_cookies"))
        {
            $param = $this->_session->paramCookieSession();
            $expire = time() - $maxLifetime;
            $this->_session->setParamCookieSession(TRUE,'',$expire, $param ['path'],$param['domain'],$param['secure'],$param['httponly']);
        }
    }

    /**
     *
     * Méthode detruireSession
     *
     * Cette méthode permet de mettre fin à une session, de supprimer les donnees en BBD
     * ainsi que les données dans la superglobale $_SESSION et de détruire le cookie de session
     * id session ???????????
     */
    public function detruireSession()
    {
        $this->_session->detruireVariableSession();
        $this->detruireCookieSession(10);
        session_destroy();
        $this->_session->__destruct();
        $this->setUserAuthenticated(FALSE);
    }

    /**
     *
     * Méthode defineStatut
     *
     * Cette méthode permet de définir le statut de l'utilisateur, ouvrant des droits sur l'espace privé du site
     *
     * @param int $statut de l'utilisateur
     *
     */
    public function defineStatut($statut)
    {

    }

    /**
     *
     * Méthode getUserIp
     *
     * Cette méthode permet de récupérer l'adresse Ip de l'utilisateur
     *
     * @return string $ip
     */
    public function getUserIp()
    {
        if(isset($_SERVER))
        {
            if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            {
                $ipReelle=$_SERVER['HTTP_X_FORWARDED_FOR'];
            }
            elseif (isset($_SERVER['HTTP_CLIENT_IP']))
            {
                $ipReelle=$_SERVER['HTTP_CLIENT_IP'];
            }
            else
            {
                $ipReelle=$_SERVER['REMOTE_ADDR'];
            }
        }
        else
        {
            if(getenv('HTTP_X_FORWARDER_FOR'))
            {
                $ipReelle=getenv('HTTP_X_FORWARDED_FOR');
            }
            elseif (getenv('HTTP_CLIENT_IP'))
            {
                $ipReelle=getenv('HTTP_CLIENT_IP');
            }
            else
            {
                $ipReelle=getenv('REMOTE_ADDR');
            }
        }
        return $ipReelle;
    }

    /**
     *
     * Méthode getUserBrowserVersion
     *
     * elle permet d'obtenir la version du navigateur de l'utilisateur
     *
     * @return string $browserVersion, description de la version du navigateur     *
     */
    public function getUserBrowserVersion()
    {
        $browserVersion = '';
        if(isset($_SERVER['HTTP_USER_AGENT']))
        {
            $browserVersion = $_SERVER['HTTP_USER_AGENT'];
        }
        return $browserVersion;
    }

    /**
     *
     * Méthode VerifierUserCountry
     *
     * Cette méthode permet de récupérer le pays de connexion de l'utilisateur
     * en fonction de son adresse Ip
     *
     * @param string $ip
     * @return string $country
     */
    public function VerifierUserCountry($ip)
    {
        $country = '';
        return $country;
    }
}