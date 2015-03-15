<?php
namespace Framework;
require_once './Framework/autoload.php';

/**
 *
 * @author Frédéric Tarreau
 *
 * 20 févr. 2015 - FactoryManager.class.php
 *
 * Abstract Factory for Manager, handling access to DB
 *
 */

class FactoryManager
{
    /**
     * @param string entity
     * @return \Framework\Manager
     */
    public static function createManager($entity)
    {
        $managerName="\\Framework\\Modeles\\Manager".$entity;
        $manager=new $managerName();
        return $manager;
    }
}

