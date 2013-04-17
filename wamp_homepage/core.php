<?php

require_once dirname( __FILE__ ) ."/lib/config.php";

/**
 * On initialise le configurateur
 */
Config::register();

/** 
 * On configure les donnees systeme
 */
Config::write('System', [
    'host'      => $_SERVER['SERVER_NAME'],
    'debug'     => 1,
    'root'      => dirname(__FILE__),
    'lib'       => dirname(__FILE__) .'/lib',
    'datas'     => dirname(__FILE__) .'/datas',
    'webroot'   => '/'. $ressourceFolder .'/webroot'
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