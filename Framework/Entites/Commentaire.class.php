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
  protected $idReference;
  protected $date;
  protected $contenu;
  protected $auteur;
  
  const AUTEUR_INVALIDE=1;
  const CONTENU_INVALIDE=3;
  
    /**
    * méthode testant si l'objet Commentaire est valide
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
   public function setIdReference($idReference)
   {
        $this->idReference= (int) $idReference ;
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
     * méthodes "getters" des attributs privés
     */
    public function auteur()
    {
    	return $this->auteur;	
    }
    
    /**
     * @return int $idReference
     */
   public function idReference()
   {
    	return $this->idReference;
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
}
       
            






