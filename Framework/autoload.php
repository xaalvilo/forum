<?php
/**
 * 
 * fonction d'autochargement des classes/interfaces/trais qui exploite l'utilisation des espaces de noms conformes à l'arborescence
 * il faudra utiliser require_once './Framework/autoload.php'; au début de chaque script instanciant les classes
 * 
 */


function autoloadClass($class)
{
    //stream_resolve_include_path — Résout un nom de fichier suivant les règles du chemin d'inclusion et retourne FALSE en cas d'erreur
	$fileName = stream_resolve_include_path('./'.str_replace('\\', '/', $class).'.class.php');
    if ($fileName !== false) 
    {
    	require_once $fileName;
    }
}

function autoloadTrait($trait)
{
	//stream_resolve_include_path — Résout un nom de fichier suivant les règles du chemin d'inclusion et retourne FALSE en cas d'erreur
 	$fileName = stream_resolve_include_path('./'.str_replace('\\', '/', $trait).'.trait.php');
    if ($fileName !== false) 
    {
    	require_once $fileName;
    }
}

function autoloadInterface($interface)
{
	//stream_resolve_include_path — Résout un nom de fichier suivant les règles du chemin d'inclusion et retourne FALSE en cas d'erreur
	$fileName = stream_resolve_include_path('./'.str_replace('\\', '/', $interface).'.interface.php');
	if ($fileName !== false)
	{
		require_once $fileName;
	}
}
// fonction de chargement automatique de classe/interface/trait avec la fonction autoload correspondante en paramètre
spl_autoload_register('autoloadClass');
spl_autoload_register('autoloadTrait');
spl_autoload_register('autoloadInterface');

