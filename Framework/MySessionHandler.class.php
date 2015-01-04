<?php
namespace Framework;
require_once './Framework/autoload.php';

/**
 * 
 * @author Frédéric Tarreau
 *
 * 31 dec. 2014 - MySessionHandler.class.php
 * 
 * la classe MySessionHandler est un gestionnaire de session personnalisé qui permet de stocker les données 
 * de session en BBD
 *
 */

class MySessionHandler extends ApplicationComponent implements \SessionHandlerInterface
{
       
    /* modele d'accès à la BDD des sessions */
    private $_managerSession;
    
    /* objet de la classe session */
    private $_session;
    
    /**
     * 
     * Constructeur
     *
     * le constructeur instancie les objets des classes requises
     * 
     * @param Application $app
     * 
     */
    public function __construct($app)
    {
        parent::__construct($app);
        $this->_managerSession = new managerSession();
    }
   
   /**
    * 
    * @see SessionHandlerInterface::open()
    */
   public function open()
   {
       
   }
   
   /**
    * 
    * @see SessionHandlerInterface::close()
    */
   public function close()
   {
       $maxlifetime = ini_get('session.gc_maxlifetime');
       $this->gc($maxlifetime);
   }
   
   /**
    * 
    * @see SessionHandlerInterface::read()
    */
   public function read();
   
   
   /**
    * 
    * @see SessionHandlerInterface::write()
    */
   public function write($identifiant, $donnees)
   {
       // calcul de la nouvelle date maximale de vie de session
       $date = new \DateTime();
       $interval = 'PT'.ini_get('session.gc_maxlifetime').'S';
       $nouvelleDate = $date->add(new \DateInterval($interval));
       $maxLifeDatetime = $nouvelleDate->format('Y-m-d H:i:s');
       
       $tableauResultat = $this->_managerSession->rechercheIdentifiant($identifiant);
       
       if(array_key_exists('identifiant', $tableauResultat))
       {
           return $this->_managerSession->actualiserSession($identifiant,$maxLifeDatetime,$donnees);
       }
       else 
       {
           return $this->_managerSession->ajouterSession($identifiant,$maxLifeDatetime,$donnees);            
       }
   }
   
   /**
    * 
    * @see SessionHandlerInterface::destroy()
    */
   public function destroy($idSession)
   {
       $this->_managerSession->supprimerSession($idSession);
   }
   
   /**
    * 
    * @see SessionHandlerInterface::gc()
    */
   public function gc($maxlifetime)
   {   
       $odate = new \DateTime();
       $expiredSessions = array(); 
       
       $expiredSessions = $this->_managerSession->getExpiredSessions($odate);
       if ($expiredSessions!=FALSE)
       {
           $resultat = TRUE;
           foreach ($expiredSessions as $identifiant)
           {
                if ($resultat === TRUE)
                {
                    $resultat = $this->_managerSession->supprimerSession($identifiant);
                }
           }
           return $resultat;
       }
       else 
       {
            return FALSE;
       }
   }
 }