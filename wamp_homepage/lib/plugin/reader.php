<?php

header('Content-type: text/html; charset=utf8');

require_once dirname (__FILE__) ."/reader_array.php";
require_once dirname (__FILE__) ."/reader_rss.php";

class Reader 
{
    public function __construct ()
    {
        Container::set('connexionReader', new Connexion('reader'));
    }

    public function display ()
    {
        Container::get('template')->set([
            'Reader'    => $this
        ]);
    }

    public function get ($select = [], $limit = 6, $when = 'today')
    {
        $rssReader = new Reader_Rss();
        $finalRss = [];
        if (isset ($select['flux']) ) {
            $fluxRss = Container::get('connexionReader')->query("SELECT * FROM flux WHERE id = '". $select['flux'] ."'", true);
        } elseif (isset ($select['categorie']) ) {
            $fluxRss = Container::get('connexionReader')->query("SELECT * FROM flux WHERE cat_id = '". $select['categorie'] ."'", true);
        } else {
            $fluxRss = Container::get('connexionReader')->query("SELECT * FROM flux", true);
        }
        
        foreach ($fluxRss as $key => $datas) {
            $finalRss[] = $datas->flux;
        }

        $rssReader->load($finalRss);

        return $rssReader->getItems($when, $limit);
    }
}