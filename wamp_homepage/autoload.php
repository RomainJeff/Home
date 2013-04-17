<?php

require_once dirname( __FILE__ ) ."/core.php";

class Autoloader
{

    public static function initialize ()
    {
        spl_autoload_register([
            new Autoloader,
            'autoload'
        ]);
    }

    public function autoload ($class)
    {
        $class = strtolower ( $class );

        $classPath = Config::get('System')['lib'] ."/". $class .".php";

        if ( ! file_exists( $classPath ) ) {
            return false;
        } else {
            require_once $classPath;
        }
    }

}