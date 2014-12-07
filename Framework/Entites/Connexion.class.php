<?php
namespace Framework\Entites;
require_once './Framework/autoload.php';

/**
 * 
 * @author Frédéric Tarreau
 *
 * 30 nov. 2014 - Connexion.class.php
 * 
 * cette classe représente le couple login / mot de passe
 *
 */
class Connexion extends \Framework\Entite
{
    /* reférence de l'utilisateur */
    protected $_idUser;
    
    /* pseudo */
    protected $_pseudo;
    
    /* mot de passe */
    protected $_mdp;
  
    /**
     * 
     * Méthode isValid
     * 
     * Cette méthode précise si l'objet connexion est valable
     * Elle utilise la fonction "empty(var)" qui retourne FALSE si la variable existe et esst non vide
     * 
     * @return boolean TRUE valide / FALSE non valide
     * 
     */
    public function isValid()
    {
        return !(empty($this->_mdp) || empty($this->_pseudo));        
    }
    
   /**
    * 
    * Méthode setIdUser
    *
    * cette méthode est le setter de l'attribut IdUser
    * 
    * @param int $idUser
    * 
    */
    public function setIdUser($idUser)
    {
        $this->_idUser=$idUser;
    } 

    /**
     * 
     * Méthode idUser
     *
     * cette méthode est le getter de l'attribut IdUser
     * 
     * @return int $_idUser
     *
     */
    public function idUser()
    {
    	return $this->_idUser;	
    }   
    
    /**
     *
     * Méthode setMdp
     *
     * cette méthode est le setter de l'attribut Mdp
     *
     * @param int $mdp
     *
     */
    public function setMdp($mdp)
    {
        $this->_mdp=$mdp;
    }
    
    /**
     *
     * Méthode mdp
     *
     * cette méthode est le getter de l'attribut mdp
     *
     * @return int $_mdp
     *
     */
    public function mdp()
    {
        return $this->_mdp;
    }
    
    /**
     *
     * Méthode setPseudo
     *
     * cette méthode est le setter de l'attribut pseudo
     *
     * @param string $pseudo
     *
     */
    public function setPseudo($pseudo)
    {
        $this->_pseudo=$pseudo;
    }
    
    /**
     *
     * Méthode pseudo
     *
     * cette méthode est le getter de l'attribut pseudo
     *
     * @return string $_pseudo
     *
     */
    public function pseudo()
    {
        return $this->_pseudo;
    }
}
       
            






