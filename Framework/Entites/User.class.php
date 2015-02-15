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
 *             - savoir si l'utilisateur a un message informatif             
 * 
 */ 
namespace Framework\Entites;
require_once './Framework/autoload.php';

class User extends \Framework\Entite
{
    /* identifiant de session */
    protected $_idSession;
    
    /* pseudo */
    protected $_pseudo;
    
    /* nom */
    protected $_nom;
    
    /* prenom */
    protected $_prenom;
    
    /* date de naissance */
    protected $_naissance;
    
    /* mail */
    protected $_mail;
    
    /* pays sous forme de tableau associatif */
    protected $_pays;
    
    /* telephone */
    protected $_telephone;
    
    /* hash du password */
    protected $_hash;
    
    /* statut du visiteur */
    protected $_statut;
    
    /* adresse IP utilisée */
    protected $_ip;
    
    /* fichier avatar */
    protected $_avatar;
    
    /* date Inscription */
    protected $_dateInscription;
    
    /* dernière date connexion */
    protected $_dateConnexion;
    
    /* nombre de commentaires sur le Forum */
    protected $_nbreCommentairesForum;
    
    /* nombre de Billets sur le Forum */
    protected $_nbreBilletsForum;
    
    /* nombre de commentaires sur le Blog */
    protected $_nbreCommentairesBlog;
    
    /* mot de passe de l'utilisateur , il ne sera jamais stocké en BDD */
    protected $_mdp;
    
    /* propriétés du navigateur */
    protected $_browserVersion;
    
    /* drapeau d'authentification */
    protected $_authenticated;
    
    /* constante correspondant au statut possible des visiteurs du site (notamment pour le forum) permettant de donner + ou - de droits */
    const MAX_STATUT=4;
    
    /* constante permettant de reporter le type d'erreur */
    const CHAINE_INVALIDE = 4;
    const STATUT_USER_INVALIDE = 5;
    const TELEPHONE_INVALIDE = 6;
    const MAIL_INVALIDE = 7;
    const NOM_FICHIER_AVATAR_INVALIDE = 8;
    const FORME_HASH_INVALIDE = 9;
    const FORME_MDP_INVALIDE = 10;
		
    
    /**
     * constructeur qui hydratera l'objet si un tableau de valeurs lui est fourni
     */
  //  public function __construct (array $donnees = array())
    //{
      //  parent::__construct();
        //$this->hydrate($donnees);
    //}
    
    
    /**
     *
     * Méthode setPseudo
     *
     * Cette méthode est le setter de pseudo
     * 
     * il vérifie qu'il s'agit bien d'une chaîne de caractère inférieur 
     * à la longueur spécifiée en configuration 
     *
     * @param string $pseudo
     *
     */
    public function setpseudo($pseudo)
    {
        $longMaxPseudo = \Framework\Configuration::get("longMaxPseudo", 30);
        if(!is_string($pseudo) || empty($pseudo) || strlen($pseudo) > $longMaxPseudo)
        {
            $this->erreurs[]= self::CHAINE_INVALIDE;
        }
        else 
        {    
            $this->_pseudo = $pseudo;
        }
    }
    
    /**
     *
     * Méthode pseudo
     *
     * Cette méthode est le getter de pseudo
     *
     * @return string $_pseudo
     */
    public function pseudo()
    {
        return $this->_pseudo;
    }
    
    /**
     * 
     * Méthode authenticated
     * 
     * getter de l'attribut protégé authenticated
     *
     * @return bool attribut authenticated     
     */
    public function authenticated()
    {
        return $this->_authenticated;
    }
    
    /**
     * 
     * Méthode setAuthenticated
     * 
     * setter de l'attribut protégé authenticated
     * 
     * @param bool $authenticated
     */
    public function setAuthenticated($authenticated = TRUE)
    {
        $this->_authenticated = $authenticated;
    }
    
    /**
     * 
     * Méthode browserVersion
     *
     * getter de browserVersin
     * 
     * @return string version du navigateur client
     */
    public function browserVersion()
    {
        return $this->_browserVersion;        
    }
    
    /**
     *
     * Méthode setBrowserVersion
     *
     * setter de setBrowserVersion
     *
     * @param string version du navigateur client
     */
    public function setBrowserVersion($browserVersion)
    {
        $this->_browserVersion = $browserVersion;
    }
    
    /**
     *
     * Méthode setMdp
     *
     * Cette méthode est le setter de Mdp
     *
     * il vérifie qu'il s'agit bien d'une chaîne de caractère inférieur
     * à la longueur spécifiée en configuration
     *
     * @param string $mdp
     *
     */
    public function setMdp($mdp)
    {
        $longMinMdp = \Framework\Configuration::get("longMinMdp", 8);
        $longMaxMdp = \Framework\Configuration::get("longMaxMdp", 12);
        if(!is_string($mdp) || empty($pseudo) || $longMinMdp > strlen($pseudo) || srlen($pseudo) > $longMaxPseudo)
        {
            $this->erreurs[]= self::FORME_MDP_INVALIDE;
        }
        else
        {
            $this->_mdp = $mdp;
        }
    }
    
    /**
     *
     * Méthode mdp
     *
     * Cette méthode est le getter de mdp
     *
     * @return string $_mdp
     */
    public function mdp()
    {
        return $this->_mdp;
    }
    
    /**
     *
     * Méthode setNom
     *
     * Cette méthode est le setter de nom
     *
     * il vérifie qu'il s'agit bien d'une chaîne de caractère inférieur
     * à la longueur spécifiée en configuration
     *
     * @param string $nom
     *
     */
    public function setNom($nom)
    {
        $longMaxNom = \Framework\Configuration::get("longMaxNom", 30);
        if(!is_string($nom) || empty($nom) || strlen($nom) > $longMaxNom)
        {
            $this->erreurs[]= self::CHAINE_INVALIDE;
        }
        else
        {
            $this->_nom = $nom;
        }
    }
    
    /**
     *
     * Méthode nom
     *
     * Cette méthode est le getter de nom
     *
     * @return string $_nom
     */
    public function nom()
    {
        return $this->_nom;
    }
    
    /**
     *
     * Méthode setPrenom
     *
     * Cette méthode est le setter de Prenom
     *
     * il vérifie qu'il s'agit bien d'une chaîne de caractère inférieur
     * à la longueur spécifiée en configuration
     *
     * @param string $prenom
     *
     */
    public function setPrenom($prenom)
    {
        $longMaxPrenom = \Framework\Configuration::get("longMaxNom", 30);
        if(!is_string($prenom) || empty($prenom) || strlen($prenom) > $longMaxPrenom)
        {
            $this->erreurs[]= self::CHAINE_INVALIDE;
        }
        else
        {
            $this->_prenom = $prenom;
        }
    }
    
    /**
     *
     * Méthode prenom
     *
     * Cette méthode est le getter de prenom
     *
     * @return string $_prenom
     */
    public function prenom()
    {
        return $this->_prenom;
    }
    
    /**
     *
     * Méthode setNaissance
     *
     * Cette méthode est le setter de naissance
     *
     * @param int $naissance
     *
     */
    public function setNaissance($naissance)
    {
        $this->_naissance = $naissance;
    }
    
    /**
     *
     * Méthode naissance
     *
     * Cette méthode est le getter de naissance
     *
     * @return int $_naissance
     */
    public function naissance()
    {
        return $this->_naissance;
    }
    
    /**
     *
     * Méthode setMail
     *
     * Cette méthode est le setter de mail
     * il vérifie que l'argument correspond bien à une chaîne de caractère
     *
     * @param string $mail
     *
     */
    public function setMail($mail = '')
    {
        if (!is_string($mail))
        {
            $this->erreurs[]=self::MAIL_INVALIDE;
        }
        else 
        {
            $this->_mail = $mail;
        }
    }
    
    /**
     *
     * Méthode mail
     *
     * Cette méthode est le getter de mail
     *
     * @return string $_mail
     */
    public function mail()
    {
        return $this->_mail;
    }
    
    /**
     *
     * Méthode setPays
     *
     * Cette méthode est le setter de pays
     * 
     * @param string $pays
     *
     */
    public function setPays($pays)
    {
        $this->_pays = $pays;
    }
    
    /**
     *
     * Méthode pays
     *
     * Cette méthode est le getter de pays
     *
     * @return string $_pays
     */
    public function pays()
    {
        return $this->_pays;
    }    
    
    /**
     *
     * Méthode setTelephone
     *
     * Cette méthode est le setter de Telephone
     * 
     * il vérifie que l'argument correspond bien à une chaîne de caractère d'une longueur = 10
     * cet argument peut être NULL
     *
     * @param string $telephone
     *
     */
    public function setTelephone($telephone ='')
    {
        if(!is_string($telephone) || strlen($telephone) != 10)
        {
            $this->erreurs[]= self::TELEPHONE_INVALIDE;
        }
        else 
        {
            $this->_telephone = $telephone;
        }
    }
    
    /**
     *
     * Méthode telephone
     *
     * Cette méthode est le getter de telephone
     *
     * @return string $_telephone
     */
    public function telephone()
    {
        return $this->_telephone;
    }
    
    /**
     *
     * Méthode setStatut
     *
     * Cette méthode est le setter de statut
     *
     * @param int $statut
     *
     */
    public function setStatut($statut)
    {       
        if ((!empty($statut)) && ((int)$statut <= self::MAX_STATUT))
        {
            $this->_statut = (int)$statut;
        }
        else
        {
            $this->erreurs[]=self::STATUT_USER_INVALIDE;
        }
    }
    /**
     *
     * Méthode statut
     *
     * Cette méthode est le getter de statut
     *
     * @return int $_statut
     */
    public function statut()
    {
        return $this->_statut;
    }

    /**
     *
     * Méthode setIp
     *
     * Cette méthode est le setter de IP
     *
     * @param string $ip
     *
     */
    public function setIp($ip)
    {
        $this->_ip = $ip;
    }
    /**
     *
     * Méthode Ip
     *
     * Cette méthode est le getter de ip
     *
     * @return string $_ip
     */
    public function ip()
    {
        return $this->_ip;
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
     * @return string $_dateConnexion
     */
    public function dateConnexion()
    {
        return $this->_dateConnexion;
    }
    
    /**
     *
     * Méthode setDateInscription
     *
     * Cette méthode est le setter de dateInscription
     *
     * @param \DateTime $dateInscription
     *
     */
    public function setDateInscription(\DateTime $dateInscription)
    {
        $this->_dateInscription = $dateInscription;
    }
    
    /**
     *
     * Méthode dateInscription
     *
     * Cette méthode est le getter de dateInscription
     *
     * @return string $_dateInscription
     */
    public function dateInscription()
    {
        return $this->_dateInscription;
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
     * Cette méthode est le setter de NbreCommentairesForum, si le paramètre est NULL, incrémentation de 1
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
     * Méthode setNbreBilletsForum
     *
     * Cette méthode est le setter de NbreBilletsForum
     *
     * @param int $nbreBilletsForum
     *
     */
    public function setNbreBilletsForum($nbreBilletsForum)
    {
    	$this->_nbreBilletsForum = (int) $nbreBilletsForum;
    }
    
    /**
     *
     * Méthode nbreBilletsForum
     *
     * Cette méthode est le getter de NbreBilletsForum
     *
     * @return int $_NbreBilletsForum
     *
     */
    public function nbreBilletsForum()
    {
    	return $this->_nbreBilletsForum;
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
	
	/**
	 *
	 * Méthode hasBandeau
	 *
	 * cette m�thode permet de savoir si un bandeau de session  est associé à
	 * l'utilisateur
	 *
	 * @return boolean TRUE si il y a un bandeau
	 *
	 */
	public function hasBandeau()
	{
	    return isset($_SESSION['bandeau']);
	}
}
