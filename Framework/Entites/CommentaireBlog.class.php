<?php
namespace Framework\Entites;
require_once './Framework/autoload.php';

/**
 * 
 * @author Frédéric Tarreau
 *
 * 26 oct. 2014 - CommentaireForum.class.php
 * 
 * cette classe hérite de la classe Commentaire et  représente un commentaire du Blog
 *
 */

class CommentaireBlog extends \Framework\Commentaire
{
  protected $idArticle;
     
    /**
    * méthode "setter" des attributs privés
    */
   public function setIdArticle($idArticle)
   {
  $this->idArticle= (int) $idArticle ;
   }
   
        
    /**
     * @return int $idArticle
     */
   public function idArticle()
   {
        return $this->idArticle;
   }
}
       
            






