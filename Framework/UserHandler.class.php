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
*             - initialiser la session avec session_start()
*             - assigner un attribut
*             - obtenir la valeur d'un attribut
*             - authentifier l'utilisateur
*             - assigner un message informatif
*             - récupérer ce message
*             - définir un statut
*             - obtenir son adresse IP
*
* Rappel sur les sessions : PHP envoie au navigateur un identifiant de session et stocke des données du client
* dans un fichier correspondant à l'identifiant
*/

Namespace Framework;
require_once './Framework/autoload.php';

class UserHandler extends ApplicationComponent
{

    /* objet session */
    protected $_session;
    
    /* objet User */
    protected $_user;
    
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
        var_dump($this->_session->identifiant());
        var_dump($this->_session->name());
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
     * Méthode user
     *
     * getter de l'attribut user (objet \framework\Entites\User)
     * 
     * @return \Framework\Entites\User
     */
    public function user()
    {
        return $this->_user;
    }
    
    /**
     *
     * Méthode setAttribute
     *
     * cette m�thode permet d'assigner un attribut associ� � l'utilisateur à l'objet Session
     *
     * @param string $cle 
     * @param mixed $valeur valeur de l'attribut
     *
     */
    public function setAttribute($cle,$valeur)
    {
        $this->_session->set($cle, $valeur) ;
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
        $this->_session->set('authenticated',$authenticated);
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
     * Méthode detruireSession
     *
     * Cette méthode permet de mettre fin à une session, de supprimer les donnees en BBD
     * ainsi que les données dans la superglobale $_SESSION et de détruire le cookie de session
     * id session ??????????? 
     */
    public function detruireSession()
    {
        $this->_session->detruireVariableSession();  
        
        // Destruction du cookie de session
        if(ini_get("session.use_cookies"))
        {
            $param = $this->_session->paramCookieSession();
            $expire = time() - 10;
            $this->_session->setParamCookieSession(TRUE,'',$expire, $param ['path'],$param['domain'],$param['secure'],$param['httponly']);
        }
        $this->_session->__destruct();
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
     *
     */
    public function getUserIp()
    {
        $ip = '192.168.1.2';
        return $ip;
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