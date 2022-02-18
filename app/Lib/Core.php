<?php
namespace App\Lib;
/*
 * Core Class
 * Creates a prettied URL and loads core controller
 * URL FORMAT - /{controller}/{method}/{params}
 */
use App\Controllers\Auth;
use App\Controllers\Users;

class Core {
    protected $currentController = 'Users';
    protected $currentMethod = 'home';
    protected $params = [];

    public function __construct(){
        $url = $this->getUrl();
        // Look in controllers for first value
        if(file_exists('../app/Controllers/' . ucwords($url[0]) . '.php')){
            // If exists, set as current controller
            $this->currentController = ucwords($url[0]);
            // Unset the 0 index
            unset($url[0]);
        }
        // Instantiate the controller class
        $this->currentController = '\\App\\Controllers\\'.$this->currentController;
        $this->currentController = new $this->currentController;
        // Check for second part of the url
        if( isset($url[1])){
            // Check to see if method exists in controller
            if(method_exists($this->currentController, $url[1])){
                // If method exists, update currentMethod
                $this->currentMethod = $url[1];
                // Unset the 1 index
                unset($url[1]);
            }
        }

        // Get Params
        $this->params = $url ? array_values($url) : [];

        // Call a callback with array of params
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function getUrl(){
        if(isset($_SERVER['REQUEST_URI'])){
            $url = ltrim(rtrim($_SERVER['REQUEST_URI'], '/'), '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            return explode('/', $url);
        }
        return '';
    }
}
