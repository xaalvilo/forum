<?php
/**
* fonction d'autochargement des classes qui exploite l'utilisation des espaces de noms conformes à l'arborescence
* il faudra utiliser require_once './Framework/autoload.php'; au début de chaque script instanciant les classes
*/

function autoload($class)
{
    require_once './'.str_replace('\\', '/', $class).'.class.php';
}

// fonction de chargement automatique de classe avec la fonction autoload en paramètre
spl_autoload_register('autoload');

