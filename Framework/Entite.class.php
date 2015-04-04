<?php
namespace Framework ;
require_once './Framework/autoload.php';

/**
* Classe abstraite fournissant les fonctionnalites nécessaires à toute entité
* du modèle. Elle impl�mente notamment l'interface PHP ArrayAccess qui permet d'afficher les attributs de l'objet en
* le parcourant comme s'il s'agissait d'un tableau
*/

abstract class Entite implements \ArrayAccess
{
    /* @var int identifiant de l'entité dans la BDD */
    protected $id;

    /* @var array erreurs stockées sous forme de tableau*/
    protected $erreurs = array();

    /**
    * constructeur qui hydratera l'objet si un tableau de valeurs lui est fourni
    */
    public function __construct(array $donnees = array())
    {
        // si on a sp�cifi� des valeurs, on hydrate l'objet
    	if (!empty($donnees))
           $this->hydrate($donnees);
    }

    /**
    * méthode précisant si l'entité est nouvelle ou non
    *
    * @return Boolean TRUE si l'entité est nouvelle
    */
    public function isNew()
    {
        return empty($this->id);
    }

    /**
    * setter de l'attribut "id" comme Integer
    */
    public function setId($id)
    {
        $this->id = (int)$id ;
    }

    /**
     * getter de l'attribut "id"
     *
     * @return int id
     */
    public function id()
    {
    	return $this->id;
    }

    /**
    * getter de l'attribut "erreurs"
    *
    * @return array erreurs
    */
    public function erreurs()
    {
        return $this->erreurs;
    }

    /**
    * fonction d'hydratation de l'objet représentant une donnée stockée
    * avec les valeurs du tableau en paramètre
    *
    * @param array $donnees tableau des valeurs des attributs
    */
    public function hydrate(array $donnees)
    {
        foreach ($donnees as $attribut=>$valeur)
        {
            // définition du setter pour chaque attribut
            // utilisation de "ucfirst()" pour remplacer le premier caractère par sa majuscule,
            // si le premier caractère est alphabétique
            $attribut = ltrim($attribut,'_');
            $methode = 'set'.ucfirst($attribut);

            // si le setter existe bien, on appelle le setter
            // on utilise "is_callable()" qui vérifie qu'une variable peut être appelée comme fonction.
            // Cette fonction peut vérifier qu'une variable contient un nom de fonction valide,
            // ou bien qu'elle contient un tableau, avec un objet et un nom de méthode.
            if (is_callable(array($this,$methode)))
            {
               $this->$methode($valeur);
            }
         }
    }

    /**
     * M�thodes de l'interface ArrayAccess
     *
     */
    public function offsetGet($var)
    {
    	if (isset($this->$var) && is_callable(array($this,$var)))
    		return $this->$var();
    }

    public function offsetSet($var, $value)
    {
    	$method = 'set'.ucfirst($var);
    	if (isset($this->$var) && is_callable(array($this, $method)))
    		$this->$method($value);
    }

    public function offsetExists($var)
    {
    	return isset($this->$var) && is_callable(array($this, $var));
    }

    public function offsetUnset($var)
    {
    	throw new \Exception('Impossible de supprimer une quelconque valeur');
    }

    /**
     *
     * Méthode EntiteToArray
     *
     * Complémentaire à l'interface, elle permet de transformer un objet en tableau en utilisant le "cast" to array
     * qui permet de prendre en compte tous les attributs (même protégés), alors que get_object_vars() ne retourne que les
     * attributs publics
     *
     * @return array
     */
    protected function EntiteToArray()
    {
        $tableau= (array)$this;
        foreach ($tableau as $cle=>$valeur)
        {
            $tableau[str_replace(chr(0).'*'.chr(0),'',$cle)]=$valeur;
        }
        return $tableau;
    }
}
