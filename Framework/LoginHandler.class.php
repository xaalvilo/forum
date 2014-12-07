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

Namespace Framework;

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
     *
     */
    public function verfierHash($mdp,$hash)
    {
        if (password_verify($mdp, $hash))
        {
            /* Valid */
            if (password_needs_rehash($hash, PASSWORD_DEFAULT)) 
            {
                $hash = password_hash($mdp, PASSWORD_DEFAULT);
            /* Store new hash in db */
            }
        }
        else 
        {
            /* Invalid */
        }
    }
  
    
}