<?php
/**
 * 
 * @author Frédéric Tarreau
 *
 * 16 nov. 2014 - User.class.php
 * 
 * Classe héritée de Entite
 * 
 * cette classe repr�sente un visiteur du site. Elle permet notamment de :
 *             - savoir si l'utilisateur est authentifié
 *             - savoir si l'utilisateur a un message informatif *               
 * 
 */
 
Namespace Framework\Entites;

class User extends \Framework\Entite
{
    /* identifiant de la session */
    protected $_sessionId;
    
    /* pseudo */
    protected $_userPseudo;
    
    /* nom */
    protected $_userNom;
    
    /* prenom */
    protected $_userPrenom;
    
    /* date de naissance */
    protected $_userNaissance;
    
    /* mail */
    protected $_userMail;
    
    /* adresse sous forme de tableau associatif */
    protected $_userAdresse;
    
    /* telephone */
    protected $_userTelephone;
    
    /* hash du password */
    protected $_hash;
    
    /* statut du visiteur */
    protected $_userStatut;
    
    /* adresse IP utilisée */
    protected $_userIP;
    
    /* fichier avatar */
    protected $_avatar;
    
    /* date enregistrement */
    protected $_dateEnregistrement;
    
    /* dernière date connexion */
    protected $_dateConnexion;
    
    /* nombre de commentaires sur le Forum */
    protected $_nbreCommentairesForum;
    
    /* nombre de commentaires sur le Blog */
    protected $_nbreCommentairesBlog;
    
    /* constante correspondant au statut possible des visiteurs du site (notamment pour le forum) permettant de donner + ou - de droits */
    const MAX_STATUT=4;
    
    /* constante permettant de reporter le type d'erreur */
    const CHAINE_INVALIDE = 4;
    const STATUT_USER_INVALIDE = 5;
    const TELEPHONE_INVALIDE = 6;
    const MAIL_INVALIDE = 7;
    const NOM_FICHIER_AVATAR_INVALIDE = 8;
    const FORME_HASH_INVALIDE = 9;
    
    /**
     * 
     * Méthode setSessionId
     *
     * Cette méthode est le setter de sessionId
     * 
     * @param int $sessionId
     * 
     */
    public function setSessionId($sessionId)
    {
        $this->_sessionId = $sessionId;
    }
    
    /**
     *
     * Méthode sessionId
     *
     * Cette méthode est le getter de sessionId
     *
     * @return int $_sessionId
     */
    public function sessionId()
    {
        return $this->_sessionId;
    }
		
    /**
     *
     * Méthode setUserPseudo
     *
     * Cette méthode est le setter de userPseudo
     * 
     * il vérifie qu'il s'agit bien d'une chaîne de caractère inférieur 
     * à la longueur spécifiée en configuration 
     *
     * @param string $userPseudo
     *
     */
    public function setUserPseudo($userPseudo)
    {
        $longMaxPseudo = \Framework\Configuration::get("longMaxPseudo", 30);
        if(!is_string($userPseudo) || empty($userPseudo) || strlen($userPseudo) > $longMaxPseudo)
        {
            $this->erreurs[]= self::CHAINE_INVALIDE;
        }
        else 
        {    
            $this->_userPseudo = $userPseudo;
        }
    }
    
    /**
     *
     * Méthode userPseudo
     *
     * Cette méthode est le getter de userPseudo
     *
     * @return string $_userPseudo
     */
    public function userPseudo()
    {
        return $this->_userPseudo;
    }
    
    /**
     *
     * Méthode setUserNom
     *
     * Cette méthode est le setter de userNom
     *
     * il vérifie qu'il s'agit bien d'une chaîne de caractère inférieur
     * à la longueur spécifiée en configuration
     *
     * @param string $userNom
     *
     */
    public function setUserNom($userNom)
    {
        $longMaxNom = \Framework\Configuration::get("longMaxNom", 30);
        if(!is_string($userNom) || empty($userNom) || strlen($userNom) > $longMaxNom)
        {
            $this->erreurs[]= self::CHAINE_INVALIDE;
        }
        else
        {
            $this->_userNom = $userNom;
        }
    }
    
    /**
     *
     * Méthode userNom
     *
     * Cette méthode est le getter de userNom
     *
     * @return string $_userNom
     */
    public function userNom()
    {
        return $this->_userNom;
    }
    
    /**
     *
     * Méthode setUserPrenom
     *
     * Cette méthode est le setter de userPrenom
     *
     * il vérifie qu'il s'agit bien d'une chaîne de caractère inférieur
     * à la longueur spécifiée en configuration
     *
     * @param string $userPrenom
     *
     */
    public function setUserPrenom($userPrenom)
    {
        $longMaxPrenom = \Framework\Configuration::get("longMaxNom", 30);
        if(!is_string($userPrenom) || empty($userPrenom) || strlen($userPrenom) > $longMaxPrenom)
        {
            $this->erreurs[]= self::CHAINE_INVALIDE;
        }
        else
        {
            $this->_userPrenom = $userPrenom;
        }
    }
    
    /**
     *
     * Méthode userPrenom
     *
     * Cette méthode est le getter de userPrenom
     *
     * @return string $_userPrenom
     */
    public function userPrenom()
    {
        return $this->_userPrenom;
    }
    
    /**
     *
     * Méthode setUserNaissance
     *
     * Cette méthode est le setter de userNaissance
     *
     * @param \DateTime $userNaissance
     *
     */
    public function setUserNaissance(\DateTime $userNaissance)
    {
        $this->_userNaissance = $userNaissance;
    }
    
    /**
     *
     * Méthode userNaissance
     *
     * Cette méthode est le getter de userNaissance
     *
     * @return \DateTime $_userNaissance
     */
    public function userNaissance()
    {
        return $this->_userNaissance;
    }
    
    /**
     *
     * Méthode setUserMail
     *
     * Cette méthode est le setter de userMail
     * il vérifie que l'argument correspond bien à une chaîne de caractère
     *
     * @param string $userMail
     *
     */
    public function setUserMail($userMail = '')
    {
        if (!is_string($userMail))
        {
            $this->erreurs[]=self::MAIL_INVALIDE;
        }
        else 
        {
            $this->_userMail = $userMail;
        }
    }
    
    /**
     *
     * Méthode userMail
     *
     * Cette méthode est le getter de userMail
     *
     * @return string $_userMail
     */
    public function userMail()
    {
        return $this->_userMail;
    }
    
    /**
     *
     * Méthode setUserAdresse
     *
     * Cette méthode est le setter de userAdresse
     * l'argument par défaut est NULL
     *
     * @param array $userAdresse
     *
     */
    public function setUserAdresse($userAdresse = array())
    {
        $this->_userAdresse = $_userAdresse;
    }
    
    /**
     *
     * Méthode userAdresse
     *
     * Cette méthode est le getter de userAdresse
     *
     * @return array $_userAdresse
     */
    public function userAdresse()
    {
        return $this->_userAdresse;
    }    
    
    /**
     *
     * Méthode setUserTelephone
     *
     * Cette méthode est le setter de userTelephone
     * 
     * il vérifie que l'argument correspond bien à une chaîne de caractère d'une longueur = 10
     * cet argument peut être NULL
     *
     * @param string $userTelephone
     *
     */
    public function setUserTelephone($userTelephone ='')
    {
        if(!is_string($userTelephone) || strlen($userTelephone) != 10)
        {
            $this->erreurs[]= self::TELEPHONE_INVALIDE;
        }
        else 
        {
            $this->_userTelephone = $userTelephone;
        }
    }
    
    /**
     *
     * Méthode userTelephone
     *
     * Cette méthode est le getter de userTelephone
     *
     * @return string $_userTelephone
     */
    public function userTelephone()
    {
        return $this->_userTelephone;
    }
    
    /**
     *
     * Méthode setUserStatut
     *
     * Cette méthode est le setter de userStatut
     *
     * @param int $userStatut
     *
     */
    public function setUserStatut($userStatut)
    {
        
        if ((!empty($userStatut)) && (is_in($userStatut)) && ($userStatut <= self::MAX_STATUT))
        {
            $this->_userStatut = $userStatut;
        }
        else
        {
            $this->erreurs[]=self::STATUT_USER_INVALIDE;
        }
    }
    /**
     *
     * Méthode userStatut
     *
     * Cette méthode est le getter de userStatut
     *
     * @return int $_userStatut
     */
    public function userStatut()
    {
        return $this->_userStatut;
    }

    /**
     *
     * Méthode setUserIP
     *
     * Cette méthode est le setter de userIP
     *
     * @param string $userIP
     *
     */
    public function setUserIP($userIP)
    {
       $this->_userIP = $userIP;
    }
    /**
     *
     * Méthode userIP
     *
     * Cette méthode est le getter de userIP
     *
     * @return string $_userIP
     */
    public function userIP()
    {
        return $this->_userIP;
    }
    
    /**
     *
     * Méthode setAvatar
     *
     * Cette méthode est le setter de Avatar
     *
     * @param string $avatar correspondant au nom du fichier image
     *
     */
    public function setAvatar($avatar = '')
    {
        if(!is_string($avatar))
        {
            $this->erreurs[]=self::NOM_FICHIER_AVATAR_INVALIDE;
        }
        else 
        {
            $this->_avatar = $avatar;
        }
    }
    
    /**
     *
     * Méthode avatar
     *
     * Cette méthode est le getter de Avatar 
     *
     * @return string $_avatar
     */
    public function avatar()
    {
        return $this->_avatar;
    }
    
    /**
     *
     * Méthode setHash
     *
     * Cette méthode est le setter de Hash
     *
     * @param string $hash correspondant au hash du mot de passe
     *
     */
    public function setHash($hash)
    {
        if(!is_string($hash))
        {
            $this->erreurs[]=self::FORME_HASH_INVALIDE;
        }
        else
        {
            $this->_hash = $hash;
        }
    }
    
    /**
     *
     * Méthode hash
     *
     * Cette méthode est le getter de Hash
     *
     * @return string $_hash
     */
    public function hash()
    {
        return $this->_hash;
    }
    
    /**
     *
     * Méthode setDateConnexion
     *
     * Cette méthode est le setter de dateConnexion
     *
     * @param \DateTime $dateConnexion 
     *
     */
    public function setDateConnexion(\DateTime $dateConnexion)
    {
        $this->_dateConnexion = $dateConnexion;        
    }
    
    /**
     *
     * Méthode dateConnexion
     *
     * Cette méthode est le getter de dateConnexion
     *
     * @return \DateTime $_dateConnexion
     */
    public function dateConnexion()
    {
        return $this->_dateConnexion;
    }
    
    /**
     *
     * Méthode setDateEnregistrement
     *
     * Cette méthode est le setter de dateEnregistrement
     *
     * @param \DateTime $dateEnregistrement
     *
     */
    public function setDateEnregistrement(\DateTime $dateEnregistrement)
    {
        $this->_dateEnregistrement = $dateEnregistrement;
    }
    
    /**
     *
     * Méthode dateEnregistrement
     *
     * Cette méthode est le getter de dateEnregistrement
     *
     * @return \DateTime $_dateEnregistrement
     */
    public function dateEnregistrement()
    {
        return $this->_dateEnregistrement;
    }
    
    /**
     *
     * Méthode setNbreCommentairesBlog
     *
     * Cette méthode est le setter de NbreCommentairesBlog
     *
     * @param int $nbreCommentairesBlog
     *
     */
    public function setNbreCommentairesBlog($nbreCommentairesBlog)
    {
           $this->_nbreCommentairesBlog =(int) $nbreCommentairesBlog;
    }
    
    /**
     *
     * Méthode nbreCommentairesBlog
     *
     * Cette méthode est le getter de NbreCommentairesBlog
     *
     * @return int $_nbreCommentairesBlog
     * 
     */
    public function nbreCommentairesBlog()
    {
        return $this->_nbreCommentairesBlog;
    }
    
    /**
     *
     * Méthode setNbreCommentairesForum
     *
     * Cette méthode est le setter de NbreCommentairesForum
     *
     * @param int $nbreCommentairesForum
     *
     */
    public function setNbreCommentairesForum($nbreCommentairesForum)
    {
         $this->_nbreCommentairesForum = (int) $nbreCommentairesForum;
    }
    
    /**
     *
     * Méthode nbreCommentairesForum
     *
     * Cette méthode est le getter de NbreCommentairesForum
     *
     * @return int $_NbreCommentairesForum
     * 
     */
    public function nbreCommentairesForum()
    {
        return $this->_nbreCommentairesForum;
    }
    
	/**
	 * 
	 * Méthode isAuthenticated
	 * 
	 * cette m�thode permet de v�rifier que l'utilisateur est bien authentifi�
	 *
	 * @return Boolean, valeur de retour TRUE si authentifié
	 * 
	 */
	public function isAuthenticated()
	{
		return isset($_SESSION['auth']) && $_SESSION['auth'] === true;
	}

	/**
	 * 
	 * Méthode hasFlash
	 * 
	 * cette m�thode permet de savoir si un message ��flash�� informatif  est associé à
	 * l'utilisateur
	 *
	 * @return boolean TRUE si il y a un message informatif
	 * 
	 */
	public function hasFlash()
	{
		return isset($_SESSION['flash']);
	}
}
