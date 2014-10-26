<?php
namespace Modele;
require_once './Framework/autoload.php';

/**
 * 
 * @author Frédéric Tarreau
 *
 * 20 oct. 2014 - Article.class.php
 * 
 * Cette classe hérite de la classe entité et représente l'article d'un Blog
 *
 */

class Article extends \Framework\Entite
{
  protected $date;
  protected $dateModif;
  protected $titre;
  protected $contenu;
  protected $image;
  
  const TITRE_INVALIDE=2;
  const CONTENU_INVALIDE=3;
  
    /**
    * mÃ©thode testant si l'objet Article est valide
    * elle utilise la fonction "empty(var)" qui  retourne FALSE si la variable existe et est non vide
    *
    * @return Boolean TRUE valide / FALSE non valide
    */
    //public function isValid()
    //{
      //  return !(empty($this->auteur) || empty($this->contenu) || empty($this->titre));
    //}
    
    /**
     * 
     * Méthode setTitre
     * 
     * Setter de titre
     * 
     * @param string $titre
     */
    public function setTitre($titre)
    {
        // $titre doit �tre une cha”ne de caract�re infŽrieure ˆ 30
    	if (!is_string($titre) || empty($titre) || strlen($titre) > 30)
        {
        	$this->erreurs[]=self::TITRE_INVALIDE;
        }
        else 
        {
        	$this->titre=$titre;
        }
    }
          
    /**
     * 
     * Méthode setContenu
     * 
     * Setter de contenu
     * 
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
    		$this->contenu=$contenu;
    	}
    }
    
    /**
     * 
     * Méthode setDate
     * 
     * Setter de date
     * 
     * @param \DateTime $date
     */
    public function setDate(\DateTime $date)
    {
    	$this->date=$date; 
    }
    
    /**
     *
     * Méthode setDateModif
     *
     * Setter de dateModif
     *
     * @param \DateTime $dateModif
     */
    public function setDateModif(\DateTime $dateModif)
    {
    	$this->dateModif=$dateModif;
    }

    /**
     *
     * Méthode setImage
     *
     * Setter de Image
     *
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image=$image;
    }
    
    /**
     * 
     * Méthode titre
     * 
     * Getter de titre
     *
     * @return string $_titre
     */
    public function titre()
    {
    	return $this->titre;
    }
    
    /**
     * 
     * Méthode contenu
     *
     * Getter de contenu
     * 
     * @return string $contenu
     */
    public function contenu()
    {
    	return $this->contenu;
    }
    
    /**
     * 
     * Méthode date
     * 
     * Getter de date
     * 
     * @return string $date au format de date
     */
    public function date()
    {
    	return $this->date;
    }
    
    /**
     * 
     * Méthode dateModif
     * 
     * Getter de dateModif
     * 
     * @return string $dateModif au format de date
     */
    public function dateModif()
    {
    	return $this->dateModif;
    }
    
    /**
     *
     * Méthode image
     *
     * Getter de image
     *
     * @return String $image
     */
    public function image()
    {
        return $this->image;
    }
}
       
            






