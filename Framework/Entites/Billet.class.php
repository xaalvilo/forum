<?php
namespace Framework\Entites;
require_once './Framework/autoload.php';
/**
 *
 * @author Frédéric Tarreau
 *
 * 5 mars 2015 - Billet.class.php
 *
 *  cette classe représente l'entité Billet du forum
 *
 */
class Billet extends \Framework\Entite
{
   /* @var \Datetime */
   protected $date;

   /* @var \Datetime */
   protected $dateModif;

   /* @var string titre */
   protected $titre;

   /* @var string contenu */
   protected $contenu;

  /* @var string nom de l'auteur */
  protected $auteur;

  /* @var int nbre de commentaires associés au billet */
  protected $nbComents;

  /* @var int identifiant du dernier commentaire */
  protected $lastComent;

  /* @var int thème du billet */
  protected $idTopic;

  /* @var int nbre affichage du billet */
  protected $nbVu;

  const AUTEUR_INVALIDE=1;
  const TITRE_INVALIDE=2;
  const CONTENU_INVALIDE=3;

    /**
    * Méthode isValid
    *
    * teste si l'objet Billet est valide
    *
    * elle utilise la fonction "empty(var)" qui  retourne FALSE si la variable existe et est non vide
    *
    * @return Boolean TRUE valide / FALSE non valide
    */
    public function isValid()
    {
        return !(empty($this->auteur) || empty($this->contenu) || empty($this->titre));
    }

    /**
    * méthodes "setters" des attributs privés
    */
    public function setTitre($titre)
    {
        // $titre doit �tre une cha”ne de caract�re infŽrieure ˆ 30
        $longMaxTitre = \Framework\Configuration::get("longMaxTitre", 30);
    	if (!is_string($titre) || empty($titre) || strlen($titre) > $longMaxTitre)
        	$this->erreurs[]=self::TITRE_INVALIDE;
        else
            $this->titre=$titre;
    }

    /**
     * @param string $topic
     */
    public function setIdTopic($idTopic)
    {
        $this->idTopic=$idTopic;
    }

    /**
     * @param int $nbVu
     */
    public function setNbVu($nbVu)
    {
        $this->nbVu=$nbVu;
    }

    /**
    * @param string $auteur
    */
    public function setAuteur($auteur)
    {
    	// $auteur doit etre une chaine de caractere
    	if (!is_string($auteur) || empty($auteur))
    		$this->erreurs[]=self::AUTEUR_INVALIDE;
    	else
    		$this->auteur=$auteur;
    }

    /**
     * @param int $nbComents
     */
    public function setNbComents($nbComents)
    {
        $this->nbComents=$nbComents;
    }

    /**
     * @param int $lastComent
     */
    public function setLastComent($lastComent)
    {
        $this->lastComent=$lastComent;
    }

    /**
     * @param string $contenu
     */
    public function setContenu($contenu)
    {
    	if (!is_string($contenu) || empty($contenu))
    		$this->erreurs[]=self::CONTENU_INVALIDE;
    	else
    		$this->contenu=$contenu;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate(\DateTime $date)
    {
    	$this->date=$date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDateModif(\DateTime $dateModif)
    {
    	$this->dateModif=$dateModif;
    }

    /**
     * mÃ©thodes "getters" des attributs privÃ©s
     */
    public function auteur()
    {
    	return $this->auteur;
    }

    /**
     * @return int
     */
    public function idTopic()
    {
        return $this->idTopic;
    }

    /**
     * @return int
     */
    public function nbVu()
    {
        return $this->nbVu;
    }

    /**
     * @return string
     */
    public function titre()
    {
    	return $this->titre;
    }

    /**
     * @return string
     */
    public function contenu()
    {
    	return $this->contenu;
    }

    /**
     * @return int
     */
    public function nbComents()
    {
        return $this->nbComents;
    }

    /**
     * @return int
     */
    public function lastComent()
    {
        return $this->lastComent;
    }

    /**
     * @return string $date au format de date
     */
    public function date()
    {
    	return $this->date;
    }

    /**
     * @return string $_dateModif au format de date
     */
    public function dateModif()
    {
    	return $this->dateModif;
    }
}








