<?php

class Connexion
{

    public static $connections = [];
    public $database = null;
    
    public function __construct ($config = "default")
    {

        $this->database = $config;

        if ( isset( Connexion::$connections[$config] ) ) {
            return true;
        }

        switch ( Config::get('Database')[$config]['sgbd'] ) {

            case "mysql":
                $connectionQuery = "mysql:host=". Config::get('Database')[$config]['host'] .';dbname='. Config::get('Database')[$config]['base'] .";charset=". Config::get('Database')[$config]['char'];
                $connectionUser = Config::get('Database')[$config]['user'];
                $connectionPass = Config::get('Database')[$config]['pass'];
                break;
            case "sqlite":
                $connectionQuery = "sqlite:". Config::get('System')['datas'] ."/". Config::get('Database')[$config]['base'];
                $connectionUser = null;
                $connectionPass = null;
                break;
            default:
                return false;
                break;
        }

        try {
            Connexion::$connections[$config] = new PDO($connectionQuery, $connectionUser, $connectionPass);
        } catch (PDOException $e) {
            die ( $e->getMessage() );
        }

        return true;

    }

    public function query ( $request, $all = false )
    {
        $query = Connexion::$connections[$this->database]->prepare($request);
        $query->execute();
        
        if ( $all ) {
            $result = $query->fetchAll(PDO::FETCH_OBJ);
        } else {
            $result = $query->fetch(PDO::FETCH_OBJ);
        }

        if ( Config::get('System')['debug'] ) {
            debug( $result );
        }

        return $result;
    }

}