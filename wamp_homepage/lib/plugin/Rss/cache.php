<?php

class Plugin_Rss_Cache
{
    private $expire;
    private $clean;
    private $prepare;
    private $filter = 'today';
    private $limit;
    public  $current = [];
    public  $h1 = "Mon flux";

    public function __construct ()
    {
        $expireFile = file_get_contents(dirname (__FILE__) ."/cache.json");
        $this->expire = json_decode ($expireFile, true)['expire'];
        $this->clean = json_decode ($expireFile, true)['clean'];
        $this->limit = Config::get('Rss')['limit'];
    }

    /** 
     * Permet de savoir si le expire est expiré
     */
    public function isOut () 
    {
        if ($this->expire < time()) {
            return true;
        }

        return false;
    }

    /** 
     * Permet de verifier si un item/flux/categorie existe
     */
    public function exists ($key, $type) 
    {
        // Verfie l'existance d'un flux/item/categorie

        switch ($type) {
            case "flux":
                if (is_int ($key)) {
                    $keyTested = 'id';
                } else {
                    $keyTested = 'flux';
                }
                $verifyExists = Container::get('sql_rss')->query("SELECT * FROM flux WHERE ". $keyTested ." = '". $key ."' ");
                if ( !empty ($verifyExists) ) {
                    return true;
                }
                return false;
                break;
            case "categorie":
                $verifyExists = Container::get('sql_rss')->query("SELECT ". $keyTested ." FROM categories WHERE id = '". $key ."' ");
                if ( !empty ($verifyExists) ) {
                    return true;
                }
                return false;
                break;
            case "items":
                if (is_int ($key)) {
                    $keyTested = 'id';
                } else {
                    $keyTested = 'guid';
                }
                $verifyExists = Container::get('sql_rss')->query("SELECT ". $keyTested ." FROM items WHERE ". $keyTested ." = '". $key ."' ");
                if ( !empty ($verifyExists) ) {
                    return true;
                }
                return false;
                break;
            default:
                return false;
                break;
        }
    }

    /**
     * Permet de modifier/ajouter un flux/items
     */
    public function save ($datas, $type) 
    {
        // Ajoute des items/flux/categories au cache

        switch ($type) {
            case "flux":
                if ($this->exists($datas['flux'], 'flux')) {
                    Container::get('sql_rss')->execute("UPDATE flux SET name = '". $datas['title'] ."' WHERE flux = '". $datas['flux'] ."' ");
                } else {
                    Container::get('sql_rss')->execute("INSERT INTO flux (name, flux) VALUES ('". $datas['title'] ."', '". $datas['flux'] ."') ");
                }
                break;
            case "items":
                foreach ($datas as $key => $datas) {
                    if ($this->exists($datas['guid'], 'items')) {
                        return true;
                    } else {
                        Container::get('sql_rss')->execute("INSERT INTO items (guid, flux_id, title, date, timestamp) VALUES ('". $datas['guid'] ."', '". $datas['flux_id'] ."', '". $datas['title'] ."', '". $datas['date'] ."', '". $datas['timestamp'] ."') ");
                    }
                }
                break;
            case "categorie":

                break;
            default:
                return false;
                break;
        }
    }

    /**
     * Permet de supprimer un flux/categorie
     */
    public function delete ($key, $type) 
    {
        // Supprimer un flux, item, ou categorie

        switch ($type) {
            case "flux":
                Container::get('sql_rss')->execute("DELETE FROM flux WHERE id ='". $key ."' ");
                Container::get('sql_rss')->execute("DELETE FROM items WHERE flux_id = '". $key ."' ");
                break;
            case "categorie":
                Container::get('sql_rss')->execute("DELETE FROM categories WHERE id ='". $key ."' ");
                $flux = Container::get('sql_rss')->query("SELECT id FROM flux WHERE cat_id = '". $key ."' ");
                Container::get('sql_rss')->execute("DELETE FROM flux WHERE cat_id ='". $flux->id ."' ");
                Container::get('sql_rss')->execute("DELETE FROM items WHERE flux_id = '". $key ."' ");
                break;
            default:
                return false;
                break;
        }
    }

    /**
     * Permet de recuperer un filtre
     */
    public function getFilter ()
    {
        switch ($this->filter) {
            case "today":
                $filter = "date = '". date('d/m/Y') ."'";
                $this->h1 = "Aujourd'hui";
                break;
            case "yesturday":
                $d = idate('d') - 1;
                $filter = "date = '". $d ."/". date('m/Y') ."'";
                $this->h1 = "Hier";
                break;
            default:
                $filterExploded = explode(':', $this->filter);
                $filter = $filterExploded[0] ." = '". $filterExploded[1] ."'";
                $this->h1 = "Mon Fil (". $filterExploded[1] .")";
                break;
        }
        return $filter;
    }

    /** 
     * Permet de recupérer tous les items
     */
    public function getAll ($filter = true) 
    {
        if ($filter) {
            $filter = "WHERE items.". $this->getFilter();
        } else {
            $this->h1 = "Tout";
        }
        
        $queryCategorie = Container::get('sql_rss')->query("SELECT * FROM categories", true);
        $queryFlux = Container::get('sql_rss')->query("SELECT * FROM flux", true);
        $queryItems = Container::get('sql_rss')->query("SELECT * FROM items ". $filter ." ORDER BY timestamp DESC", true);
        $finalItems = [];
        $i = 0;

        foreach ($queryCategorie as $key => $cat) {
            foreach ($queryFlux as $key => $data) {
                if ($cat->id == $data->cat_id) {
                    foreach ($queryItems as $key => $value) {
                        if ($data->id == $value->flux_id && $i < $this->limit) {
                            $value->categorieInfos = [
                                'name'  => $cat->name,
                                'color' => $cat->color
                            ];
                            $value->fluxInfos = [
                                'name'  => $data->name,
                                'flux'  => $data->flux
                            ];
                            $finalItems[] = $value;
                            $i++;
                        }
                    }
                }
            }
        }

        return $finalItems;
    }

    /** 
     * Permet de recuperer les items d'une categorie
     */
    public function getCategories($id, $filter = true) 
    {
        // Permet de récupérer les items des flux d'une catégories
        if ($filter) {
            $filter = "WHERE ". $this->getFilter();
        }
        $queryCategorie = Container::get('sql_rss')->query("SELECT * FROM categories WHERE id = '". $id ."'");
        $queryFlux = Container::get('sql_rss')->query("SELECT * FROM flux WHERE cat_id = '". $queryCategorie->id ."'", true);
        $queryItems = Container::get('sql_rss')->query("SELECT * FROM items ". $filter ."", true);
        $finalItems = [];
        $i = 0;

        foreach ($queryFlux as $key => $data) {
            foreach ($queryItems as $key => $value) {
                if ($data->id == $value->flux_id && $i < $this->limit) {
                    $value->categorieInfos = [
                        'name'  => $queryCategorie->name,
                        'color' => $queryCategorie->color
                    ];
                    $value->fluxInfos = [
                        'name'  => $data->name,
                        'flux'  => $data->flux
                    ];
                    $finalItems[] = $value;
                    $i++;
                }
            }
        }

        $this->h1 = $queryCategorie->name;

        return $finalItems;
    }

    /**
     * Permet de recuperer les items d'un flux complet
     */
    public function getFlux($key, $filter = true) 
    {
        // Permet de recuperer les items d'un flux particulié
        if ($filter) {
            $filter = "AND ". $this->getFilter();
        }
        $queryFlux = Container::get('sql_rss')->query("SELECT * FROM flux WHERE id = '". $key ."' ");
        $queryItems = Container::get('sql_rss')->query("SELECT * FROM items WHERE flux_id = '". $key ."' ". $filter ." ", true);
        $queryCategorie = Container::get('sql_rss')->query("SELECT * FROM categories WHERE id = '". $queryFlux->cat_id ."' ");
        $finalItems = [];

        foreach ($queryItems as $key => $datas) {
            $datas->fluxInfos = [
                'name'  => $queryFlux->name,
                'flux'  => $queryFlux->flux
            ];
            $datas->categorieInfos = [
                'name'  => $queryCategorie->name,
                'color' => $queryCategorie->color
            ];
            $finalItems[] = $datas;
        }

        $this->h1 = $queryFlux->name;

        return $finalItems;
    }

    /**
     * Modifie le nombre d'items affichés
     */
    public function setLimit ($limit) 
    {
        // Permet de definir le nombre limite d'affichage
        // d'items
        $this->limit = $limit;
    }

    /**
     * Permet de modifier le filtre
     */
    public function setFilter ($filter) 
    {
        // Permet de definir le filtre d'affichage des items
        // Par exemple: today, yesturday, all
        $this->filter = $filter;
    }

    /**
     * Permet de modifier la date d'expiration
     */
    public function setExpire ($minutes = 10)
    {
        $this->expire = time() + ($minutes * 60);

        $formatJson = json_encode(['expire' => $this->expire, 'clean' => $this->clean]);
        file_put_contents (dirname (__FILE__) ."/cache.json", $formatJson);
    }

    /**
     * Permet de nettoyer les articles trop vieux
     * Il est executé une fois par jour
     */
    public function clean ()
    {
        // Permet de nettoyer la bdd
        // Supprime tous les items vieux de plus de 30 jours
        if ($this->clean > time()) {
            return false;
        }

        $maxold = time() - ((60 * 60) * 24) * Config::get('Rss')['maxold'];

        Container::get('sql_rss')->query("DELETE FROM items WHERE timestamp < ". $maxold ." ");

        $timeNext = time() + (60 * 60) * 24;
        $jsonEncoded = json_encode([
            'expire'    => $this->expire,
            'clean'     => $timeNext
        ]);

        file_put_contents(dirname (__FILE__) ."/cache.json", $jsonEncoded);
    }
}