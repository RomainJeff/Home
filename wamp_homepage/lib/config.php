<?PHP

class Config 
{
    static $configs = [];

    public static function register ()
    {
        $fileGeneral = file_get_contents ( dirname(dirname(__FILE__)) ."/datas/general.json" );
        $uncodedGeneral = json_decode($fileGeneral, true);
        //var_dump($uncodedGeneral); die();
        Config::$configs = $uncodedGeneral;
    }

    public static function get ($key)
    {
        return Config::$configs[$key];
    }

    public static function write ( $key, $value )
    {
        Config::$configs[$key] = $value;
    }

}