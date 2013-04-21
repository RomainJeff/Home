<?php

require_once dirname( __FILE__ ) ."/lib/config.php";

header('Content-type: text/html; charset=utf-8');

/**
 * On initialise le configurateur
 */
Config::register();

/** 
 * On configure les donnees systeme
 */
Config::write('System', [
    'host'      => $_SERVER['SERVER_NAME'],
    'debug'     => 0,
    'root'      => dirname(__FILE__),
    'lib'       => dirname(__FILE__) .'/lib',
    'datas'     => dirname(__FILE__) .'/datas',
    'layout'    => dirname(__FILE__) .'/view/layout',
    'view'      => dirname(__FILE__) .'/view',
    'webroot'   => '/'. $ressourceFolder .'webroot'
]);


# ================================================================= #

/** 
 * Fonction debug
 * @param obj|array datas
 **/
function debug ($datas)
{
    echo "<pre>";
    print_r ( $datas );
    echo "</pre>";
}