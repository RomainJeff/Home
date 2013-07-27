<<<<<<< HEAD
<?php

class Plugin_Rss_Reader
{

    public $months = [
        'Jan'   => '01',
        'Feb'   => '02',
        'Fev'   => '02',
        'Mar'   => '03',
        'Apr'   => '04',
        'Avr'   => '04',
        'Mai'   => '05',
        'May'   => '05',
        'Jun'   => '06',
        'Jul'   => '07',
        'Jui'   => '07',
        'Aug'   => '08',
        'Aou'   => '08',
        'Sep'   => '09',
        'Oct'   => '10',
        'Nov'   => '11',
        'Dec'   => '12',
    ];

    public function __construct ()
    {
        Container::set('sql_rss', new Connexion('rss'));
        $configs = Container::get('sql_rss')->query("SELECT * FROM configs LIMIT 1 ");

        Config::write('Rss', [
            'maxold'    => $configs->max_old, // Nombre de jours max d'ancienté d'un item
            'limit'     => $configs->limit
        ]);
    }

    /**
     * Methode executée par defaut par le gestionnaire de PlugIn
     */
    public function display() 
    {
        Container::set('rss_cache', new Plugin_Rss_Cache());

        $urls = Container::get('sql_rss')->query("SELECT * FROM flux", true);

        $this->load($urls);

        Container::get('rss_cache')->clean();

        Container::get('template')->set([
            'rssConfig'     => Container::get('sql_rss')->query("SELECT * FROM configs LIMIT 1 ")
        ]);
    }

    /**
     * Charge et redirige les flux
     */
    public function load ($url) 
    {
        if (Container::get('rss_cache')->isOut()) {
            foreach ($url as $key => $datas) {
                $this->read($datas->flux);
            }
        }
    }

    /**
     * Lis et recupere le contenue d'un flux
     */
    public function read ($url)
    {
        $fileRss = @simplexml_load_file($url);

        if ( !$fileRss ) {
            return false;
        }

        $channel = $fileRss->channel;

        Container::get('rss_cache')->save([
            'title'         => $fileRss->channel->title,
            'flux'          => $url
        ], 'flux');
        
        //var_dump ($channel->item);
        $items = [];

        $fluxInfos = Container::get('sql_rss')->query("SELECT id FROM flux WHERE flux = '". $url ."' ");
        
        foreach ($channel->item as $item) {
            if ($date = $this->transformDate($item->pubDate, true)) {
                $items[] = [
                    'flux_id'   => $fluxInfos->id,
                    'title'     => str_replace('\'', '"', $item->title),
                    'guid'      => $item->guid,
                    'date'      => $date['d'] ."/". $date['m'] ."/". $date['y'],
                    'timestamp' => $date['time']
                ];
            }
        }

        Container::get('rss_cache')->save($items, 'items');

        Container::get('rss_cache')->setExpire();

    }

    /**
     * Transforme la date xml en date standard
     */
    public function transformDate ($date, $filter = false)
    {
        $a = str_replace(',', '', $date);
        $a = explode(' ', $a);
        $h = explode(':', $a[4]);

        $timeDate = mktime($h[0], $h[1], $h[2], $this->months[$a[2]], $a[1], $a[3]);

        if ($filter) {
            $timeBefore = time() - ((60 * 60) * 24) * Config::get('Rss')['maxold'];
            if ($timeDate < $timeBefore) {
                return false;
            }
        }

        return [
            'd'     => $a[1],
            'm'     => $this->months[$a[2]],
            'y'     => $a[3],
            'time'  => $timeDate
        ];
    }

    /**
     * Reconstitue le titre originel
     */
    static function filter ($title)
    {
        return str_replace('"', '\'', $title);
    }

}
=======
<?php

class Plugin_Rss_Reader
{

    public $months = [
        'Jan'   => '01',
        'Feb'   => '02',
        'Fev'   => '02',
        'Mar'   => '03',
        'Apr'   => '04',
        'Avr'   => '04',
        'Mai'   => '05',
        'May'   => '05',
        'Jun'   => '06',
        'Jul'   => '07',
        'Jui'   => '07',
        'Aug'   => '08',
        'Aou'   => '08',
        'Sep'   => '09',
        'Oct'   => '10',
        'Nov'   => '11',
        'Dec'   => '12',
    ];

    public function __construct ()
    {
        Container::set('sql_rss', new Connexion('rss'));
        $configs = Container::get('sql_rss')->query("SELECT * FROM configs LIMIT 1 ");

        Config::write('Rss', [
            'maxold'    => $configs->max_old, // Nombre de jours max d'ancienté d'un item
            'limit'     => $configs->limit
        ]);
    }

    /**
     * Methode executée par defaut par le gestionnaire de PlugIn
     */
    public function display() 
    {
        Container::set('rss_cache', new Plugin_Rss_Cache());

        $urls = Container::get('sql_rss')->query("SELECT * FROM flux", true);

        $this->load($urls);

        Container::get('rss_cache')->clean();

        Container::get('template')->set([
            'rssConfig'     => Container::get('sql_rss')->query("SELECT * FROM configs LIMIT 1 ")
        ]);
    }

    /**
     * Charge et redirige les flux
     */
    public function load ($url) 
    {
        if (Container::get('rss_cache')->isOut()) {
            foreach ($url as $key => $datas) {
                $this->read($datas->flux);
            }
        }
    }

    /**
     * Lis et recupere le contenue d'un flux
     */
    public function read ($url)
    {
        $fileRss = @simplexml_load_file($url);

        if ( !$fileRss ) {
            return false;
        }

        $channel = $fileRss->channel;

        Container::get('rss_cache')->save([
            'title'         => $fileRss->channel->title,
            'flux'          => $url
        ], 'flux');
        
        //var_dump ($channel->item);
        $items = [];

        $fluxInfos = Container::get('sql_rss')->query("SELECT id FROM flux WHERE flux = '". $url ."' ");
        
        foreach ($channel->item as $item) {
            if ($date = $this->transformDate($item->pubDate, true)) {
                $items[] = [
                    'flux_id'   => $fluxInfos->id,
                    'title'     => str_replace('\'', '"', $item->title),
                    'guid'      => $item->guid,
                    'date'      => $date['d'] ."/". $date['m'] ."/". $date['y'],
                    'timestamp' => $date['time']
                ];
            }
        }

        Container::get('rss_cache')->save($items, 'items');

        Container::get('rss_cache')->setExpire();

    }

    /**
     * Transforme la date xml en date standard
     */
    public function transformDate ($date, $filter = false)
    {
        $a = str_replace(',', '', $date);
        $a = explode(' ', $a);
        $h = explode(':', $a[4]);

        $timeDate = mktime($h[0], $h[1], $h[2], $this->months[$a[2]], $a[1], $a[3]);

        if ($filter) {
            $timeBefore = time() - ((60 * 60) * 24) * Config::get('Rss')['maxold'];
            if ($timeDate < $timeBefore) {
                return false;
            }
        }

        return [
            'd'     => $a[1],
            'm'     => $this->months[$a[2]],
            'y'     => $a[3],
            'time'  => $timeDate
        ];
    }

    /**
     * Reconstitue le titre originel
     */
    static function filter ($title)
    {
        return str_replace('"', '\'', $title);
    }

}
>>>>>>> 3324ea59168c1ab2a3998b849a550d945a557fea
