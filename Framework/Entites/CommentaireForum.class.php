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
    * méthodes "setters" des attributs privés
    */
   public function setIdBillet($idBillet)
   {
      $this->idBillet= (int) $idBillet ;
   }
   
        
    /**
     * @return int $idBillet
     */
   public function idBillet()
   {
        return $this->idBillet;
   }
}
       
            






