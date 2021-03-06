<?php
namespace Framework\Entites;
require_once './Framework/autoload.php';

/**
 *
 * @author Frédéric Tarreau
 *
 * 26 oct. 2014 - CommentaireBlog.class.php
 *
 * cette classe hérite de la classe Commentaire et représente un commentaire du Blog
 *
 */

class CommentaireBlog extends \Framework\Commentaire
{
    /* @var int identifiant de l'article */
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
   public function getIdArticle()
   {
        return $this->idArticle;
   }
}








