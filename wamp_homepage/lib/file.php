<?php

class File
{

    public $folder = __DIR__;
    public $listing = [];
    
    /**
     * Constructeur de la classe
     * @param   string  folder
     **/
    public function __construct ($folder = null)
    {
        if ( ! empty ($folder) ) {
            $this->folder = $folder;
        } else {
            $this->folder = dirname(dirname(__DIR__));
        }
    }

    /** 
     * Permet de lister les dossiers
     * @param   array ignored
     * @return  array
     **/
    public function liste ($ignored = [])
    {
        if ( ! empty ($this->listing) ) {
            return $this->listing;
        }

        if ( ! $handle = opendir ($this->folder) ) {
           return false;
        }

        while ( $directory = readdir ($handle) ) {
            
            if ( is_dir ($directory) ) {

                if ( ! in_array ( $directory, $ignored ) ) {

                    $this->listing[] = $directory;
                }
            }
        }
        return $this->listing;
    }

}