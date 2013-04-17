<?php

class Routeur
{
    static $urls = [];
    
    /**
     * Permet d'ajouter une regle aux routes
     * @param   string  page
     * @param   func    function
     **/
    public static function connect ($page, $function)
    {
        Routeur::$urls[$page] = $function;
    }

    /**
     * Permet de démarer le routeur
     * @param   string  current
     * @return  boolean
     **/
    public static function start ($current)
    {
        foreach (Routeur::$urls AS $page => $functions) {

            if ($current == $page) {

                $functions();

                return true;
            }
        }
    }
}