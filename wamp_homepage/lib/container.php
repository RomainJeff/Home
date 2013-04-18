<?php

class Container
{
    
    static $instances = [];

    /**
     * Ajoute une instance au tableau des instances
     * @param   string  name
     * @param   object  instance
     */
    public static function set ($name, $instance)
    {
        Container::$instances[$name] = $instance;
    }

    /**
     * Retourne une instance voulue
     * @param   string  name
     * @return  object
     */
    public static function get ($name)
    {
        return Container::$instances[$name];
    }
}