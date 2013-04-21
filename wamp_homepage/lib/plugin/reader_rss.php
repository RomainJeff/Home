<?php

class Reader_Rss
{
    public $file;
    public $infosFilter = ['title', 'href', 'link'];
    public $items = false;

    /**
     * Charge un ou plusieurs flux
     * @param   string|array    url
     **/
    public function load ($url)
    {
        if (is_array ($url) ) {
            foreach ($url as $key => $url) {
                $this->file[$key] = simplexml_load_file($url);
                $this->items[$key] = $this->file[$key]->channel;
            }
            return true;
        }

        $this->file = simplexml_load_file($url);
        $this->items = $this->file->channel;
    }

    /**
     * Recupère des informations sur le flux
     * @return  object
     */
    public function getInfos ()
    {
        if (is_array ($this->file) ) {
            foreach ($this->file as $key => $datas) {
                foreach ($datas->channel as $channel) {
                    foreach ($this->infosFilter as $key => $value) {
                        if (isset ($channel->$value) ) {
                            $this->infos[$value] = $channel->$value;
                        }
                    }
                }
            }
        }

        foreach ($this->file->channel as $channel) {
            foreach ($this->infosFilter as $key => $value) {
                if (isset ($channel->$value) ) {
                    $this->infos[$value] = $channel->$value;
                }
            }
        }

        return $this->infos;
    }

    /**
     * Recupère les articles des flux
     * @param   int|string  numbers
     * @param   int         limit
     * @return  array
     */
    public function getItems ($numbers = '*', $limit = 5)
    {
        if ($numbers == '*') {
            $items = [];
            foreach ($this->items as $key => $item) {
                foreach ($item->item as $datas) {
                    $items[] = $datas;
                }
            }
            usort($items, [new Reader_Array(), 'dateInverse']);
            $items = array_slice($items, count($items) - $limit, NULL, false);
            usort($items, [new Reader_Array(), 'date']);
            return $items;
        } elseif ($numbers == 'today') {
            $items = [];
            foreach ($this->items as $key => $item) {
                foreach ($item->item as $datas) {
                    $pubDate = new Reader_Array();
                    $pubDate = $pubDate->transformDate($datas->pubDate);
                    $pubDate = $pubDate['d'] .'/'. $pubDate['m'] .'/'. $pubDate['y'];
                    if ($pubDate == date('d/m/Y')) {
                        $items[] = $datas;
                    }
                }
            }
            usort($items, [new Reader_Array, 'date']);
            return $items;
        }

        return $this->items[$numbers]->item;
    }
}
