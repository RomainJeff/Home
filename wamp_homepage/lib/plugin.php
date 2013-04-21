<?php

class Plugin
{
    
    public static function load (array $plugin)
    {
        foreach ($plugin as $key => $plugin) {
            
            $pluginLower = strtolower ($plugin);
            $plugin = "Plugin_". $plugin;

            Container::set($pluginLower, new $plugin);

            Container::get($pluginLower)->display();
        }
    }

}