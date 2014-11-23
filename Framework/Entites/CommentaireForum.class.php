<?php
namespace \Framework\Entites;
require_once './Framework/autoload.php';

/**
 * 
 * @author Frédéric Tarreau
 *
 * 26 oct. 2014 - CommentaireForum.class.php
 * 
 * cette classe hérite de la classe Commentaire et  représente un commentaire du Forum 
 *
 */

class CommentaireForum extends \Framework\Commentaire
{
    protected $idBillet;
        
   /**
    * 
    * Méthode setIdBillet
    *
    * cette méthode est le setter de idBillet
    * 
    * @param int $idBillet
    */
   public function setIdBillet($idBillet)
   {
      $this->idBillet= (int) $idBillet ;
   }
        
   /**
    * 
    * Méthode getIdBillet
    *
    * cette méthode est le getter de idBillet
    * 
    * @return number $idBillet
    * 
    */
   public function getIdBillet()
   {
        return $this->idBillet;
   }
}
       
            






