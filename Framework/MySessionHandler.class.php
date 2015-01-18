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
    /* duree de vie */
    private $_lifeTime;
    
    /* modele d'accès à la BDD des sessions */
    private $_managerSession;
    
   /**
    * 
    * @see SessionHandlerInterface::open()
    */
   public function open($save_path,$name)
   {
       $this->_lifeTime = get_cfg_var("session.gc_maxlifetime");
       if(!isset($this->_managerSession))
       {
            $this->_managerSession = new \Framework\Modeles\ManagerSession();
       }
       return TRUE;
   }
   
   /**
    * 
    * @see SessionHandlerInterface::close()
    */
   public function close()
   {
       $maxlifetime = $this->_lifeTime;
       $this->gc($maxlifetime);
       return TRUE;
   }
   
   /**
    * 
    * @see SessionHandlerInterface::read()
    */
   public function read($identifiant)
   {      
       $data =$this->_managerSession->getSessionData($identifiant);
       return $data;
   }
     
   /**
    * 
    * @see SessionHandlerInterface::write()
    */
   public function write($identifiant,$donnees)
   {
       // calcul de la nouvelle date maximale de vie de session
       $date = new \DateTime();
       $interval = 'PT'.$this->_lifeTime.'S';
       $nouvelleDate = $date->add(new \DateInterval($interval));
       $maxLifeDatetime = $nouvelleDate->format('Y-m-d H:i:s');
     ;
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
       return $this->_managerSession->supprimerSession($idSession);
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
   
   /**
    * 
    * Méthode managerSession
    *
    * \Framework\Modeles\ManagerSession
    * 
    * @return \Framework\Modeles\ManagerSession
    */
   public function managerSession()
   {
       return $this->_managerSession;
   }
 }