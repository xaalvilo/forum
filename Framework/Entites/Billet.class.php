<?php
namespace Framework\Entites;
require_once './Framework/autoload.php';

/**
* cette classe reprÃ©sente l'entitÃ© Billet du forum
*/

class Billet extends \Framework\Entite
{
  protected $date;
  protected $dateModif;
  protected $titre;
  protected $contenu;
  protected $auteur;
  
  const AUTEUR_INVALIDE=1;
  const TITRE_INVALIDE=2;
  const CONTENU_INVALIDE=3;
  
    /**
    * mÃ©thode testant si l'objet Billet est valide
    * elle utilise la fonction "empty(var)" qui  retourne FALSE si la variable existe et est non vide
    *
    * @return Boolean TRUE valide / FALSE non valide
    */
    public function isValid()
    {
        return !(empty($this->auteur) || empty($this->contenu) || empty($this->titre));
    }
    
    /**
    * mÃ©thodes "setters" des attributs privÃ©s
    */
    public function setTitre($titre)
    {
        // $titre doit �tre une cha”ne de caract�re infŽrieure ˆ 30
        $longMaxTitre = \Framework\Configuration::get("longMaxTitre", 30);
    	if (!is_string($titre) || empty($titre) || strlen($titre) > $longMaxTitre)
        {
        	$this->erreurs[]=self::TITRE_INVALIDE;
        }
        else 
        {
        	$this->titre=$titre;
        }
    }
    
    public function setAuteur($auteur)
    {
    	// $auteur doit etre une chaine de caractere
    	if (!is_string($auteur) || empty($auteur))
    	{
    		$this->erreurs[]=self::AUTEUR_INVALIDE;
    	}
    	else
    	{
    		$this->auteur=$auteur;
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
    		$this->contenu=$contenu;
    	}
    }
    
    /**
     * @param \DateTime $date
     */
    public function setDate(\DateTime $date)
    {
    	$this->date=$date; 
    }
    
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
    
    public function titre()
    {
    	return $this->titre;
    }
    
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
     * @return string $_dateModif au format de date
     */
    public function dateModif()
    {
    	return $this->dateModif;
    }
}
       
            






