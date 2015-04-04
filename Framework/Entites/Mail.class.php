<?php
namespace Framework\Entites;
require_once './Framework/autoload.php';
/**
 *
 * @author Frédéric Tarreau
 *
 * 27 mars 2015 - Mail.class.php
 *
 * cette classe représente l'entité Mail
 *
 */
class Mail extends \Framework\Entite
{
   /* @var \Datetime */
   protected $_date;

   /* @var string objet */
   protected $_objet;

   /* @var string contenu */
   protected $_contenu;

   /* @var string nom du destinataire */
   protected $_destinataire;

   const DESTINATAIRE_INVALIDE=1;
   const OBJET_INVALIDE=2;
   const CONTENU_INVALIDE=3;

    /**
    * Méthode isValid
    *
    * teste si l'objet "Mail" est valide
    *
    * elle utilise la fonction "empty(var)" qui  retourne FALSE si la variable existe et est non vide
    *
    * @return Boolean TRUE valide / FALSE non valide
    */
    public function isValid()
    {
        return !(empty($this->_destinataire) || empty($this->_contenu) || empty($this->_objet));
    }

    /**
    * méthodes "setters" des attributs privés
    */
    public function setObjet($objet)
    {
        // $titre doit �tre une cha”ne de caract�re infŽrieure ˆ 30
        $longMaxObjet = \Framework\Configuration::get("longMaxObjet", 30);
    	if (!is_string($_objet) || empty($_objet) || strlen($_objet) > $longMaxObjet)
        	$this->erreurs[]=self::OBJET_INVALIDE;
        else
            $this->_objet=$objet;
    }

    /**
    * @param string $destinataire
    */
    public function setDestinataire($destinataire)
    {
    	// $destinataire doit etre une chaine de caractere
    	if (!is_string($destinataire) || empty($destinataire))
    		$this->erreurs[]=self::DESTINATAIRE_INVALIDE;
    	else
    		$this->_destinataire=$destinataire;
    }

    /**
     * @param string $contenu
     */
    public function setContenu($contenu)
    {
    	if (!is_string($contenu) || empty($contenu))
    		$this->erreurs[]=self::CONTENU_INVALIDE;
    	else
    		$this->_contenu=$contenu;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate(\DateTime $date)
    {
    	$this->_date=$date;
    }

    /**
     * mÃ©thodes "getters" des attributs privÃ©s
     */
    public function destinataire()
    {
    	return $this->_destinataire;
    }

    /**
     * @return string
     */
    public function objet()
    {
    	return $this->_objet;
    }

    /**
     * @return string
     */
    public function contenu()
    {
    	return $this->_contenu;
    }

    /**
     * @return string $date au format de date
     */
    public function date()
    {
    	return $this->date;
    }
}








