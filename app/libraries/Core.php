<?php

declare(strict_types = 1);

/*
 * App Core Class
 * Creates URL & loads core controller
 * URL FORMAT - /controller/method/params
 */

class Core
{
    protected $currentController = 'PagesController';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->getUrl();

        // Look in controllers for first value
        if (isset($url[0]) &&
            file_exists('../app/controllers/'.ucwords($url[0]).'Controller.php')) {
            // If exists, set as controller
            $this->currentController = ucwords($url[0].'Controller');
            // Unset 0 index
            unset($url[0]);
        }

        // Require the controller
        require_once '../app/controllers/'.$this->currentController.'.php';

        // Instantiate controller
        $this->currentController = new $this->currentController;

        // Check for second part of url
        if (isset($url[1]) &&
            // Check to see if method exists in controller
            method_exists($this->currentController, $url[1])) {
            $this->currentMethod = $url[1];
            // Unset 1 index
            unset($url[1]);
        }

        // Get params
        if ($url) {
            $this->params = array_values($url);
        }

        // Call a callback with array of params
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    private function getUrl(): array
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);

            return $url;
        }

        return [];
    }
}
