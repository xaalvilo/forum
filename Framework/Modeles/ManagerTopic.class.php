<?php
/**
 *
 * @author Frédéric Tarreau
 *
 * 4 mars 2015 - ManagerTopic.class.php
 *
 * classe héritée de la classe abstraite Modèle dont le rôle est la gestion des accès à la base de données des Topics du Forum
 *
 */
namespace Framework\Modeles ;
require_once './Framework/autoload.php';
class ManagerTopic extends \Framework\Manager
{
    /**
    *
    * Méthode getTopics
    *
    * méthode renvoyant la liste de l'ensemble des topics de la BDD
    *
    * @param int $idCat catégorie
    * @return PDOStatement la liste des topics et leurs caractéristiques
    */
    public function getTopics($idCat)
    {
        // requete avec jointure pour recuperer la liste des topics (T_FORUM_TOPIC)
        // les donnees du dernier billet associé (T_BILLET)
        // le nom de la catégorie associée (T_FORUM_CAT)
        $sql = 'select T.TOPIC_ID as id, T.TOPIC_TITRE as titre, T.TOPIC_VU as vu, T.TOPIC_NBPOST as nbPost, B.BIL_ID as idBillet,'
        . ' U.USER_PSEUDO as auteur, B.BIL_DATE as date, B.BIL_TITRE as titreBillet, C.CAT_NAME as nomCategorie'
        . ' from T_FORUM_TOPIC T'
        . ' join T_BILLET B'
        . ' on B.BIL_ID=T.TOPIC_LASTPOST'
        . ' join T_FORUM_CAT C'
        . ' on C.CAT_ID=T.CAT_ID'
        . ' join T_USER U'
        . ' on B.USER_ID=U.USER_ID'
        . ' where T.CAT_ID=?';

        $requete = $this->executerRequete($sql,array($idCat),NULL);

        //la requ�te retourne un tableau contenant toutes les lignes du jeu d'Inscriptions
        $topics = $requete->fetchAll();

        //permettre à la requ�te d'être à nouveau exécutée
        $requete->closeCursor();

        // spécification de la langue utilisée pour l'affichage de la date et heure
        // cela permet d'utliser la fonction strftime() au moment d'afficher l'heure
        $this->setHeureDateLocale();

        $i=0;
        foreach ($topics as $topic)
        {
            // il faut transformer l'attribut Date en objet DateTime
            $topics[$i]['date'] = new \DateTime($topics[$i]['date']);
            $i++;
        }
        return $topics;
    }

    /**
    *
    * Méthode getTopic
    *
    * méthode renvoyant l'ensemble des informations sur le topic sélectionné
    *
    * @param int $idTopic identifiant du topic
    * @return array le topic sélectionné
    * @throws Exception si l'identifiant du topic est inconnu
    */
    public function getTopic($idTopic)
    {
        $sql = 'select TOPIC_TITRE as titre, CAT_ID as idCat, TOPIC_VU as vu, TOPIC_LASTPOST as lastPost'
                . ' from T_FORUM_TOPIC where TOPIC_ID=?';

  		// requete avec un format de retour en tableau
        $resultat =$this->executerRequete($sql,array($idTopic),NULL);

        //si un topic correspond (row_count() retourne le nombre de lignes affectées par la dernière requête) , renvoyer ses informations
        //(fetch() renvoie la première ligne d'une requête )
        if ($resultat->rowcount()==1)
        {
            $topic = $resultat->fetch();

            //liberer la connexion
            $resultat->closeCursor();

        	return $topic;
        }
        else
            throw new \Exception("Aucun Topic ne correspond à l'identifiant '$idTopic'");
    }

    /**
     *
     * Méthode actualiserTopic
     *
     * cette méthode permet d'actualiser les données d'un Topic
     *
     * @param int $idTopic
     * @param array $donnees à actualiser
     */
    public function actualiserTopic($idTopic,$donnees)
    {
        // création de la chaîne de caractère pour la requête SQL
        $nbreModifications=count($donnees);
        $modification ='';
        $i=0;

        foreach ($donnees as $attribut=>$valeur)
        {
            $i++;
            if ($attribut=='nbPost'){
                $modification.='TOPIC_NBPOST=TOPIC_NBPOST + '.$valeur.'';
                unset($donnees['nbPost']);
            }
            elseif ($attribut=='vu') {
                $modification.='TOPIC_VU=TOPIC_VU + '.$valeur.'';
                unset($donnees['vu']);
            }
            else $modification.='TOPIC_'.strtoupper($attribut).'=?';
            if ($i<$nbreModifications)
                $modification.=', ';
        }

        // préparation de la requête SQL UPDATE
        $sql = 'update T_FORUM_TOPIC set '.$modification.' where TOPIC_ID=?';

        // ajout de l'identifiant pour l'exécution de la requête
        $donnees['id']= $idTopic;

        // transformation du tableau en tableau indexé
        $donnees = array_values($donnees);

        $resultat = $this->executerRequete($sql,$donnees,NULL);

        if ($resultat===FALSE)
        {
            //TODO msg Flash non OK
            throw new \Exception("Données du Topic '$idTopic' non mises à jour");
        }
    }

    /**
     * Méthode getParent
     *
     * cette méthode permet de récupérer l'id du topic auquel le billet en paramètre est associé,
     * ainsi que le dernier billet de ce topic
     *
     * @param int $idBillet
     * @throws \Exception en cas d'échec de la requête SQL pour trouver l'identifiant
     * @return array $tableauRésultat, à une entrée comportant l'id du Parent
     */
    public function getParent($idBillet)
    {
        $sql = 'select T.TOPIC_ID as idParent, T.TOPIC_LASTPOST as lastPost'
                .' from T_FORUM_TOPIC T join T_BILLET B'
                .' on T.TOPIC_ID=B.TOPIC_ID'
                .' where B.BIL_ID = ?';

        $requeteSQL = $this->executerRequete($sql, array($idBillet),NULL);

        if ($requeteSQL->rowcount()==1)
        {
            // modification du type de récupération des données de la BDD
            $tableauResultat = $requeteSQL->fetch();

            // liberer la connexion
            $requeteSQL->closeCursor();

            return $tableauResultat;
        }
        else
        {
            throw new \Exception("Impossible d'obtenir les données du Topic associé au billet");
        }
    }
}


