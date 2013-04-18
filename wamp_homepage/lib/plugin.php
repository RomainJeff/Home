<?php

class Plugin
{
    
    public static function load (array $plugin)
    {
        foreach ($plugin as $key => $plugin) {
            $pluginLower = strtolower ($plugin);

            require_once Config::get('System')['lib'] ."/plugin/". $pluginLower .".php";

            Container::set($pluginLower, new $plugin);
        }
    }

}