<?php
namespace Framework\Entites;
require_once './Framework/autoload.php';
/**
 *
 * @author Frédéric Tarreau
 *
 * 26 oct. 2014 - Commentaire.class.php
 *
 * cette classe représente l'entité Commentaire d'un billet du forum ou d'un article du Blog
 *
 */

class Commentaire extends \Framework\Entite
{
    /*@var int */
    protected $idParent;

    /*@var \DateTime */
    protected $date;

    /*@var \DateTime */
    protected $dateModif;

    /*@var string */
    protected $contenu;

    /*@var string */
    protected $auteur;

  const AUTEUR_INVALIDE=1;
  const CONTENU_INVALIDE=3;

    /**
    * méthode isValid
    *
    * Permet de tester si l'objet Commentaire est valide
    * elle utilise la fonction "empty(var)" qui  retourne FALSE si la variable existe et est non vide
    *
    * @return Boolean TRUE valide / FALSE non valide
    */
    public function isValid()
    {
        return !(empty($this->auteur) || empty($this->contenu));
    }

    /**
    * méthodes "setters" des attributs privés
    */
   public function setIdParent($idParent)
   {
        $this->idParent= (int) $idParent ;
   }

    /**
     * @param unknown $auteur
     */
    public function setAuteur($auteur)
    {
    	if (!is_string($auteur) || empty($auteur) || strlen($auteur) > 15)
    	{
    		$this->erreurs[]=self::AUTEUR_INVALIDE;
    	}
    	else
    	{
    		$this->auteur= (string) $auteur;
    	}
    }

    /**
     * @param string $contenu
     */
    public function setContenu($contenu)
    {
    	if (!is_string($contenu) || empty($contenu))
    	{
    		$this->erreurs[]=self::CONTENU_INVALIDE;
    	}
    	else
    	{
    		$this->contenu= (string) $contenu;
    	}
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
     * méthodes "getters" des attributs privés
     */
    public function auteur()
    {
    	return $this->auteur;
    }

    /**
     * @return int $idParent
     */
   public function idParent()
   {
    	return $this->idParent;
    }

    /**
     *
     */
    public function contenu()
    {
    	return $this->contenu;
    }

    /**
     * @return string $date au format de date
     */
    public function date()
    {
    	return $this->date;
    }

    /**
     * @return string $dateModif au format de date
     */
    public function dateModif()
    {
    	return $this->dateModif;
    }
}








