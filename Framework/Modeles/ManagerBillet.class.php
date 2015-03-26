<?php
/**
 *
 * @author Frédéric Tarreau
 *
 * 4 mars 2015 - ManagerBillet.class.php
 *
 * classe héritée de la classe abstraite Modèle dont le rôle est la gestion des accès à la base de données des Billets
 *
 */
namespace Framework\Modeles ;
require_once './Framework/autoload.php';

class ManagerBillet extends \Framework\Manager
{
    /**
    *
    * Méthode getBillets
    *
    * méthode renvoyant la liste de l'ensemble des billets de la BDD
    *
    * @param int $idTopic
    * @return PDOStatement la liste des billets
    */
    public function getBillets($idTopic=NULL)
    {
        // TODO provisoire
        if($idTopic==NULL){
            //requête avec classement des billets dans l'ordre décroissant
            $sql = 'select BIL_ID as id, TOPIC_ID as idTopic, BIL_DATE as date, BIL_NBVU as nbVu,'
                    . ' BIL_AUTEUR as auteur, BIL_TITRE as titre, BIL_CONTENU as contenu, BIL_NBCOMENTS as nbComents from T_BILLET'
                    . ' order by BIL_DATE desc';
        }
        else {
            //requête avec classement des billets dans l'ordre décroissant
            $sql = 'select B.BIL_ID as id, B.TOPIC_ID as idTopic, B.BIL_DATE as date, B.BIL_NBVU as nbVu,'
                    . ' U.USER_PSEUDO as auteur, B.BIL_TITRE as titre, B.BIL_CONTENU as contenu, B.BIL_NBCOMENTS as nbComents'
                    . ' from T_BILLET B'
                    . ' join T_USER U on U.USER_ID =B.USER_ID'
                    . ' where B.TOPIC_ID=? order by B.BIL_DATE desc';
        }
        // instanciation d'objets "Modele\Billet" dont les attributs publics prennent pour valeur les donn�es de la BDD
        $requete = $this->executerRequete($sql,array($idTopic),'\Framework\Entites\Billet');

        //la requ�te retourne un tableau contenant toutes les lignes du jeu d'Inscriptions , les colonnes sont li�s aux attributs de la
        //la classe
        $billets = $requete->fetchAll();

        //permettre � la requ�te d'�tre de nouveau ex�cut�e
        $requete->closeCursor();

        // spécification de la langue utilisée pour l'affichage de la date et heure
        // cela permet d'utliser la fonction strftime() au moment d'afficher l'heure
    	$this->setHeureDateLocale();

    	// il faut transformer l'attribut Date et DateModif en objet DateTime
        foreach ($billets as $billet){
        		$billet->setDate(new \DateTime($billet->date()));
        		$billet->setDateModif(new \DateTime($billet->dateModif()));
        }
        return $billets;
    }

    /**
    *
    * Méthode getBillet
    *
    * méthode renvoyant l'ensemble des informations sur le billet sélectionné
    *
    * @param int $idBillet identifiant du billet
    * @return array le billet sélectionné
    * @throws Exception si l'identifiant du billet est inconnu
    */
    public function getBillet($idBillet)
    {
      $sql = 'select B.BIL_ID as id, T.TOPIC_TITRE as topic, B.BIL_DATE as date, B.BIL_DATEMODIF as dateModif,'
                . ' U.USER_PSEUDO as auteur, B.BIL_TITRE as titre, B.BIL_CONTENU as contenu, B.BIL_NBVU as nbVu,'
                . ' B.BIL_NBCOMENTS as nbComents, T.TOPIC_ID as idTopic,'
                . ' U.USER_NBRECOMMENTAIRESFORUM as nbUserComents, U.USER_NBREBILLETSFORUM as nbUserBillets'
                . ' from T_BILLET B'
                . ' join T_FORUM_TOPIC T on B.TOPIC_ID=T.TOPIC_ID'
                . ' join T_USER U on U.USER_ID =B.USER_ID'
                . ' where B.BIL_ID=?';

  		// instanciation d'objet "Modele\Billet" dont les attributs publics prennent pour valeur les donn�es de la BDD
        $resultat =$this->executerRequete($sql, array($idBillet),'\Framework\Entites\Billet');

        //si un billet correspond (row_count() retourne le nombre de lignes affectées par la dernière requête) , renvoyer ses informations
        //(fetch() renvoie la première ligne d'une requête )
        if ($resultat->rowcount()==1) {
            $billet = $resultat->fetch();

            //liberer la connexion
            $resultat->closeCursor();

            // spécification de la langue utilisée pour l'affichage de la date et heure
            // cela permet d'utliser la fonction strftime() au moment d'afficher l'heure
            $this->setHeureDateLocale();

            // il faut transformer l'attribut Date et DateModif en objet DateTime
        	$billet->setDate(new \DateTime($billet->date()));
        	$billet->setDateModif(new \DateTime($billet->dateModif()));
        	return $billet;
        } else throw new \Exception("Aucun billet ne correspond à l'identifiant '$idBillet'");
    }

    /**
     *
     * Méthode getLastBillet
     *
     * méthode renvoyant l'ensemble des informations sur le billet le plus récent d'un topic donné
     *
     * @param int $idTopic identifiant du topic
     * @return array le billet sélectionné
     * @throws Exception si l'identifiant du Topic est inconnu
     */
    public function getLastBillet($idTopic)
    {
        // récupération du billet le plus récent
        $sql = 'select BIL_ID as id from T_BILLET where TOPIC_ID=? order by BIL_DATE desc limit 0,1';

        $requeteSQL =$this->executerRequete($sql, array($idTopic),NULL);

        if ($requeteSQL->rowcount()==1) {
            $tableauResultat = $requeteSQL->fetch();

            //liberer la connexion
            $requeteSQL->closeCursor();
            return $tableauResultat;
        }
        else throw new \Exception("Aucun billet ne correspond à l'identifiant de Topic $idTopic");
    }

    /**
     *
     * Méthode getNewBillets
     *
     * permet de récupérer tous les nouveaux billets postérieurs à une date de dernière connexion d'un utilisateur
     *
     * @param string $date
     * @return \PDOStatement liste des billets
     * @throws \Exception
     */
    public function getNewBillets($idUser)
    {
        $sql = 'select DISTINCT B.BIL_ID as id, B.TOPIC_ID as idTopic, T.TOPIC_TITRE as titreTopic, B.BIL_DATE as date, B.BIL_NBVU as nbVu,'
                . ' U.USER_PSEUDO as auteur, B.BIL_TITRE as titre, B.BIL_CONTENU as contenu, B.BIL_NBCOMENTS as nbComents'
                . ' from T_BILLET B'
                . ' join T_USER U on U.USER_ID=B.USER_ID'
                . ' join T_FORUM_TOPIC T on T.TOPIC_ID=B.TOPIC_ID'
                . ' join T_COMMENTAIRE C on C.BIL_ID=B.BIL_ID'
                        // TODO ATTENTION COMPARAISON INVERSEE
                . ' where C.COM_DATE < (select U.USER_DATELASTCONNEXION from T_USER U where U.USER_ID=?)'
                . ' or B.BIL_DATE < (select U.USER_DATELASTCONNEXION from T_USER U where U.USER_ID=?)'
                . ' order by BIL_DATE desc';

        //instanciation d'objets "Modele\Billet" dont les attributs publics prennent pour valeur les donn�es de la BDD
        $resultat = $this->executerRequete($sql,array($idUser,$idUser),'\Framework\Entites\Billet');

        //la requ�te retourne un tableau contenant toutes les lignes du jeu d'Inscriptions, les colonnes sont li�s aux attributs de la
        //la classe
        $billets = $resultat->fetchAll();

        //permettre � la requ�te d'�tre de nouveau ex�cut�e
        $resultat->closeCursor();

        // spécification de la langue utilisée pour l'affichage de la date et heure
        // grâce au trait Affichage utilisé par la classe mère
        $this->setHeureDateLocale();

        foreach ($billets as $billet)
        {
            // il faut transformer l'attribut Date en objet DateTime
            $billet->setDate(new \DateTime($billet->date()));
            $billet->setDateModif(new \DateTime($billet->dateModif()));
        }
        return $billets;
    }
    /**
     *
     * Méthode ajouterBillet
     *
     * Cette méthode insère un nouveau billet en BDD
     *
     * @param int $idTopic identifiant du topic
     * @param string $titre
     * @param int $idAuteur idenfiant du user dans la table User
     * @param string $contenu
     */
    public function ajouterBillet($idTopic,$titre,$idAuteur,$contenu)
    {
        //requ�te avec insertion du commentaire
        $sql = 'insert into T_BILLET(TOPIC_ID, BIL_DATE, BIL_TITRE, USER_ID, BIL_CONTENU)'
             . ' values(?, ?, ?, ?, ?)';

        // utilisation de la classe DateTime pour faire correspondre le format Php avec le format DateTime de MySql, time courant de la machine
        $odate = new \DateTime();

        // il faut formater la date en cha�ne de caract�re
        $date = $odate->format('Y-m-d H:i:s');

        $resultat = $this->executerRequete($sql,array($idTopic,$date,$titre,$idAuteur,$contenu),'\Framework\Entites\Billet');
        return $resultat;
    }

    /**
     *
     * Méthode actualiserBillet
     *
     * cette méthode permet d'actualiser un billet
     *
     * @param int $idBillet
     * @param array $donnees à actualiser
     */
    public function actualiserBillet ($idBillet, $donnees)
    {
       if(array_key_exists('date', $donnees))
            $donnees['date']= $donnees['date']->format('Y-m-d H:i:s');

        if(array_key_exists('dateModif', $donnees))
            $donnees['dateModif']= $donnees['dateModif']->format('Y-m-d H:i:s');

        // création de la chaîne de caractère pour la requête SQL
        // retirer au préalable l'identifiant qui n'est jamais actualisé
        unset ($donnees['id']);
        $nbreModifications=count($donnees);
        $modification ='';
        $i=0;

        foreach ($donnees as $attribut=>$valeur){
            $i++;
            if ($attribut=='nbComents'){
                $modification.='BIL_NBCOMENTS=BIL_NBCOMENTS + '.$valeur.'';
                unset($donnees['nbComents']);
            } elseif ($attribut=='nbVu') {
                $modification.='BIL_NBVU=BIL_NBVU + '.$valeur.'';
                unset($donnees['nbVu']);
            } else $modification.='BIL_'.strtoupper($attribut).'=?';
            if ($i<$nbreModifications)
                $modification.=', ';
        }

         // préparation de la requête SQL UPDATE
        $sql = 'update T_BILLET set '.$modification.' where BIL_ID=?';

         // ajout de l'identifiant pour l'exécution de la requête
         $donnees['id']= $idBillet;

        // transformation du tableau en tableau indexé
        $donnees = array_values($donnees);

        $resultat = $this->executerRequete($sql,$donnees,'\Framework\Entites\Billet');

        if ($resultat===FALSE){
            //TODO msg Flash non OK
            throw new \Exception("Données du billet '$idBillet' non mises à jour");
        }
    }

    /**
     * Méthode supprimerBillet
     *
     * cette méthode permet de supprimer un billet de la BDD
     *
     * @param int $idBillet
     * @return bool
     */
    public function supprimerBillet($idBillet)
    {
        $sql = 'delete from T_BILLET where BIL_ID = ?';
        $requeteSQL = $this->executerRequete($sql, array($idBillet),'\Framework\Entites\Billet');
        return ($requeteSQL->rowcount()==1);
    }
}


