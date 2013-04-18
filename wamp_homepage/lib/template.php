<?php

class Template
{
    private $datas = [];
    private $layout = 'default';
    private $block = [];
    private $currentblock;

    /**
     * Permet de passer une ou plusieurs variables a la vue
     * @param   string|array    key
     * @param   string          value
     * @return  boolean
     */
    public function set ($key, $value = null)
    {
        if ( ! empty ($value) ) {
            $this->datas[$key] = $value;

            return true;
        }

        foreach ($key as $key => $value) {
            $this->datas[$key] = $value;
        }

        return true;
    }

    /**
     * Permet de configurer le layout
     * @param   string  layout
     */
    public function layout ($layout)
    {
        $this->layout = $layout;
    }

    /**
     * Permet de rendre une vue
     * @param   string  render
     */
    public function render ($view)
    {
        $this->datas['url'] = "http://". Config::get('System')['host'].Config::get('System')['webroot'];
        extract($this->datas);

        ob_start();
        require_once Config::get('System')['view'] ."/". $view;
        $this->block['content'] = ob_get_clean();

        require_once Config::get('System')['layout'] ."/". $this->layout .".tpl";
    }

    /**
     * Permet de recupérer le contenue d'un block
     * A UTILISER DANS LA VUE !
     * $this->fetch('blockname');
     * @param   string  block
     * @return  string
     */
    private function fetch ($block)
    {
        return isset ($this->block[$block]) ? $this->block[$block] : false;
    }

    /**
     * Permet de debuter un block
     * A UTILISER DANS LA VUE !
     * $this->start('blockname');
     * @param   string  name
     */
    private function start ($name)
    {
        $this->currentblock = $name;
        ob_start();
    }

    /**
     * Permet de terminer un block
     * A UTILISER DANS LA VUE !
     * $this->end();
     */
    private function end()
    {
        $this->block[$this->currentblock] = ob_get_clean();
    }

}