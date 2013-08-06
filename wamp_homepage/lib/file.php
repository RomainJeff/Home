<?php

class File
{

    public $folder = __DIR__;
    public $listing = [];
    public $config = [];
    public $recursive;

    /**
     * Constructeur de la classe
     * @param   string  folder
     **/
    public function __construct ($folder = null, $recursive = false)
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

    /** 
     * Permet de lister les dossiers
     * @param   array ignored
     * @return  array
     **/
    public function recursive ()
    {
        $ignored = [
            '..','.'
        ];

        if ( ! empty ($this->listing) ) {
            return $this->listing;
        }

        if ( ! $handle = opendir ($this->folder) ) {
           return false;
        }

        while ( $directory = readdir ($handle) ) {

            if ( is_dir ($this->folder .'/'. $directory) ) {

                if ( ! in_array ( $directory, $ignored ) ) {

                    $this->listing[] = $directory;
                }
            }

            if ( is_file ($this->folder .'/'. $directory ) ) {

                if ($directory == 'index.php' || $directory == 'index.html') {
                    $this->listing[] = $directory;
                }

            }
        }
        return $this->listing;
    }

    /**
     * Permet de recuperer les configurations de chaques projets
     */
    public function config ($recursive = false)
    {
        foreach ($this->listing as $key => $dir) {
            $fullDir = $this->folder .'/'. $dir .'/addwebhome.json';
            
            if ( !$recursive ) {
                if ( ! file_exists ($fullDir) ) {

                    file_put_contents($fullDir, '
{
    "title": "'. $dir .'",
    "font": "Entypo",
    "couleur": "blue",
    "icone": "&#128230;",
    "span": "2",
    "link": "/index.php/folder/'. $dir .'"
}
                    ');
                }

                $configFile = file_get_contents($fullDir);
                $this->config[$dir] = json_decode($configFile, true);

            } else {
                if ($dir == 'index.php' || $dir == 'index.html') {

                    $this->config[$dir] = [
                        'title'     => $dir,
                        'font'      => "Entypo",
                        'couleur'   => "orange",
                        'icone'     => "&#9729;",
                        'span'      => "2",
                        'link'      => "fichier"
                    ];
                } else {
                    $this->config[$dir] = [
                        'title'     => $dir,
                        'font'      => "Entypo",
                        'couleur'   => "blue",
                        'icone'     => "&#128230;",
                        'span'      => "2",
                        'link'      => "folder"
                    ];
                }
            }
        }

        return $this->config;
    }

}
