<<<<<<< HEAD
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

            if (preg_match('`^'. $page .'$`', $current, $matches)) {

                foreach ($matches as $key => $value) {
                    if ($key != 0) {
                        $_GET[] = $value;
                    }
                }

                $functions();

                return true;
            }
        }
    }
}
=======
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

            if (preg_match('`^'. $page .'$`', $current, $matches)) {

                foreach ($matches as $key => $value) {
                    if ($key != 0) {
                        $_GET[] = $value;
                    }
                }

                $functions();

                return true;
            }
        }
    }
}
>>>>>>> 3324ea59168c1ab2a3998b849a550d945a557fea
