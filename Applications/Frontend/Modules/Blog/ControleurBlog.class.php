<?php
/**
 *
 * @author Frédéric Tarreau
 *
 * 25 oct. 2014 - ControleurBlog.class.php
 *
 * la classe ControleurBlog hérite de la classe abstraite Controleur du framework.
 * elle utilise également la methode genererVue pour générer la vue associée à l'action
 *
 */
namespace Applications\Frontend\Modules\Blog;
require_once './Framework/autoload.php';

class ControleurBlog extends \Framework\Controleur
{
    /* Manager de article */
    private $_managerArticle;

    /**
    * le constructeur instancie les classes "modèles" requises
    */
    public function __construct(\Framework\Application $app)
    {
    	parent::__construct($app);
        $this->_managerArticle= new \Framework\Modeles\ManagerArticle();
    }

    /**
    *
    * Méthode index
    *
    * cette méthode est l'action par défaut consistant à :
    * - afficher l'article le plus récent du blog, puis la liste des articles regroupés par page
    * - créer le formulaire d'ajout de commentaire par la méthode initForm si l'utilisateur est administrateur
    * - afficher l'ensemble des articles avec le même libellé et permettre la navigation au sein de ce groupe
    *
    * elle utilise notamment les méthodes privées :
    * - calculerPagination : en fonction du nombre d'article
    * - selectionnerArticles : avec un filtre
    *
    * et exploite la superGlobale de session pour savoir si la navigation au seind es articles est limlitée à un libellé ou non
    *
    * @param array $donnees tableau de données éventuellement passé en paramètre, permettant d'afficher dans le formulaire les champs valides saisis lors d'une
    * requête précédente ou de restreindre la navigation dans un libelle d'article pré selectionné
    *
    */
    public function index(array $donnees = array())
    {
        if((!$this->_requete->existeParametre('id')) && (!array_key_exists('choixLibelle', $donnees)))
        {
            // supprimer la variable de session relative aux libellés
            if(!empty($_SESSION['choixLibelle']))
                 $this->_app->userHandler()->removeAttribute('choixLibelle');
        }

        if(empty($_SESSION['choixLibelle']))
        {
            // les articles étant affichées 5 / page, il faut définir un curseur pour afficher la bonne page
            $curseur =1;
            if($this->_requete->existeParametre('id'))
                $curseur =  $this->_requete->getParametre('id');

            $donneesVue = $this->selectionnerArticles(array('curseur'=>$curseur));

            // affichage du formulaire d'ajout d'article si l'utilisateur est administrateur et qu'il s'agit de l'affichage du dernier article
            $administrateur= \Framework\Configuration::get('admin');
            if($curseur==1)
            {
                if($this->_app->userHandler()->IsUserAuthenticated() && $this->_app->userHandler()->user()->statut()==$administrateur)
                {
                    // tableau des valeurs à prendre en compte pour le formulaire
                    $tableauValeur = array('methode'=>'post','action'=>'blog/editer');

                    // si le tableau de données transmises n'est pas vide, le fusionner avec le tableau précédent, le tableau $donnees
                    // écrasera éventuellement les valeurs du tableau $tableauValeur si les clés sont identiques (car est en second argument de la fonction
                    // array_merge(..)
                    if(!empty ($donnees))
                        $tableauValeur=array_merge($tableauValeur,$donnees);

                    // création du formulaire d'ajout d'un article
                    $form=$this->initForm('article',$tableauValeur);

                    $donneesVue['formulaire']=$form->createView();
                }
            }
        }
        // supprimer la variable de session permettant la navigation dans des articles correspondants à un libellé particulier
        // $this->_app->userHandler()->removeAttribute('choixLibelle');
        // il y a des données relatives au libelle en session
        else
        {
            // la variable en paramètre de la méthode contient des données sur le choix du libelle
            if((!empty($donnees)) && (array_key_exists('choixLibelle', $donnees)))
            {
                $curseur = 1;
                $choixLibelle = $donnees['choixLibelle'];
            }
            // il s'agit d'une navigation au sein du groupe d'article correspondant au Libelle
            else
            {
                if($this->_requete->existeParametre('id'))
                    $curseur =  $this->_requete->getParametre('id');
                $choixLibelle = $this->_app->userHandler()->getAttribute('choixLibelle');
            }
            $donneesVue = $this->selectionnerArticles(array('curseur'=>$curseur,'choixLibelle'=>$choixLibelle));
        }
        $this->genererVue($donneesVue);
    }

    /**
    *
    * Méthode calculerPagination
    *
    * calcule le nombre de pages à prévoir pour la barre de navigation en fonction du nombre d'articles par page et
    * du nombre total d'articles
    *
    * @param string $filtre
    * @return array $listeArticles, référence les id d'articles pour chaque page
    */
    private function calculerPagination($filtre=NULL)
    {
        // récupération de données sur le nombre d'articles et pagination (suivant config)
        $nombreArticlesParPage=\Framework\Configuration::get('nombreArticleParPage',5);
        $nombreTotalArticles = $this->_managerArticle->getNombreArticles($filtre);

        // calcul du nombre de liens en bas de page vers les articles suivants
        if(($nombreTotalArticles%$nombreArticlesParPage)===0)
            $nombrePage = $nombreTotalArticles/$nombreArticlesParPage;
        else
            $nombrePage = floor($nombreTotalArticles/$nombreArticlesParPage) + 1;

        $listeArticles[0]= 1;
        $i=0;
        while($i<$nombrePage-1)
        {
            $listeArticles[$i+1]=$listeArticles[$i]+$nombreArticlesParPage;
            $i++;
        }
        return $listeArticles;
    }

    /**
     *
     * Méthode selectionnerArticles
     *
     * en fonction du filtre elle sélectionne les artciles à afficher et récupère l'ensemble des libellés pour alimenter la barre latérale (aside)
     *
     * @param array $donneesFiltre, paramètres du filtre de la BDD suivant les articles à sélectionner
     */
    private function selectionnerArticles($donneesFiltre=array())
    {
        // récupération de données sur le nombre d'articles et pagination (suivant config)
        $nombreArticlesParPage=\Framework\Configuration::get('nombreArticleParPage',5);

        $curseur = $donneesFiltre['curseur'];
        $choixLibelle = '';
        if(array_key_exists('choixLibelle', $donneesFiltre))
            $choixLibelle = $donneesFiltre['choixLibelle'];

        $listeArticles = $this->calculerPagination($choixLibelle);

        //récupération des articles
        if(($curseur==1)&& (empty($choixLibelle)))
        {
            $donneesVue['dernierArticle'] = $this->_managerArticle->getDernierArticle();
            $donneesVue['articles'] = $this->_managerArticle->getArticles($curseur,$nombreArticlesParPage-1);
        }
        else
        {
            $donneesVue['dernierArticle'] = NULL;
            $donneesVue['articles'] = $this->_managerArticle->getArticles($curseur-1,$nombreArticlesParPage,$choixLibelle);
        }

        $listeLibelles = $this->_managerArticle->getLibelles();

        $donneesVue['listeArticles']= $listeArticles;
        $donneesVue['curseur']= $curseur;
        $donneesVue['listeLibelles']=$listeLibelles;

        $donneesVue['formulaire']='';
        return $donneesVue;
    }

    /**
     *
     * Méthode selectionnerLibelles
     *
     * lorsqu'un lien de la barre de navigation latérale (aside) permet de restreindre la navigation sur le libelle choisi
     *
     */
    public function selectionnerLibelles()
    {
        // supprimer l'ancien en variable de session (repésentée par un tableau : libellé et curseur)
        if(!empty($_SESSION['choixLibelle']))
           $this->_app->userHandler()->removeAttribute('choixLibelle');

        $choixLibelle=$this->_requete->getParametre("id");

        // créer la variable de session
        $this->_app->userHandler()->setAttribute('choixLibelle',$choixLibelle);
        var_dump($_SESSION);
        $this->executerAction('index',array('choixLibelle'=>$choixLibelle));
    }

    /**
     *
     * Méthode editer
     *
     * cette méthode correspond à l'action "editer" permettant d'ajouter un article du blog
     * Elle ne doit être exécutée que si les données insérées dans le formulaire sont valides
     *
     */
    public function editer()
    {
        $titre = $this->_requete->getParametre("titre");
        $libelle = $this->_requete->getParametre("libelle");
        $contenu = $this->_requete->getParametre("contenu");
        $image = $this->_requete->getParametre("image");

        // prise en compte de la date courante
        $date = new \DateTime();

        // création du formulaire d'ajout d'un article en l'hydratant avec les valeurs de la requête
        $form=$this->initForm('article',array('titre'=>$titre,
                'libelle'=>$libelle,
                'contenu'=>$contenu,
                'date'=>$date,
                'image'=>$image,
                'methode'=>'post',
                'action'=>'blog/editer'));

        $options=array();

        // si la methode est bien POST et que le formulaire est valide, insertion des données en BDD
        if (($this->_requete->getMethode() =='POST'))
        {
            if ($form->isValid())
            {
                // appelle de la m�thode permettant d'enregistrer un article en BDD
                $this->_managerArticle->ajouterArticle($titre,$libelle,$contenu,$image);
            }
            else
            {
                // recuperation des nom/valeur des champs valides afin de générer ultérieurement l'affichage du formulaire
                $options=$form->validField();
            }
        }

        //il s'agit sinon ou ensuite d'executer l'action par d�faut permettant d'afficher la liste des articles
        $this->executerAction("index",$options);
    }

}