<?php
/**
 *
* @author Frédéric Tarreau
*
* 05 dec. 2014 - LoginHandler.class.php
*
* Classe héritée de ApplicationComponent
*
* cette classe a pour r�le de gérer les données de l'objet login 
*             - générer le hash du password
*             - comparer un password et un hash
* 
*/
namespace Framework;
require_once './Framework/autoload.php';

class LoginHandler extends ApplicationComponent
{
    /**
     * 
     * Méthode creerHash
     * 
     * cette méthode utilise les fonctions natives de php 5 pour générer le hash d'un mot de pass
     * 
     * @param string $mdp mot de passe à hasher
     * @return string $hash hash généré
     */
    public function creerHash($mdp)
    {
        $hash = password_hash($mdp, PASSWORD_DEFAULT);
        return $hash;
    }
    
    /**
     * 
     * Méthode verifierHash
     * 
     * cette méthode utilise les fonctions natives de php 5 pour vérifier qu'un mot de passe 
     * correspond à une table de hachage 
     *
     * @return array $resultat tableau comportant : 
     *                                   un boolean (FALSE si non valide, TRUE si valide), 
     *                                   un boolean précisant si le hash est regénéré,
     *                                   un string correspondant au hash regénéré
     */
    public function verifierHash($mdp,$hash)
    {
        $resultat=array('valide'=> FALSE);
         
        if (is_string($mdp) && is_string($hash))
        {
            if (password_verify($mdp, $hash))
            {      
                $resultat['valide']=TRUE;   
              
                // vérification de la pertinence du hash par rapport à l'algorithme par défaut en vigueur
                if (password_needs_rehash($hash, PASSWORD_DEFAULT)) 
                {
                    // génération d'un nouveau hash qu'il faudra faire stocker en BDD par le contrôleur
                    $resultat['hash']= password_hash($mdp, PASSWORD_DEFAULT); 
                }
            }
       }
       return $resultat ;
    }
  
    
}