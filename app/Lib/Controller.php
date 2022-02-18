<?php
/*
 * A Base Controller
 * Loads the models and views used by the system
 */
namespace App\Lib;
class Controller {

    /**
     * Array to hold messages, if any exist, they are outputted to the page and then the array is reset.
     * Structure: { $message => $level }
     * @see $this->getMessages() for output formatting
     */
    public $messages = [];

    /**
     * Loads a model
     */
    public function model($model){
        $fileLocation = '../app/models/' . ucwords($model) . '.php';        
        // Require model file
        require_once $fileLocation;

        // Instantiate model
        return new $model();
    }

    /**
     * Load view
     */
    public function view($view, $data = []){
        // Check for view file
        if( file_exists('../app/views/' . $view . '.php')){
            require_once('../app/views/' . $view . '.php');
        } else {
            // View does not exist
            die("View does not exist.");
        }
    }

    /**
     * Redirect to the given page
     * - Attempts to do a header redirect, if it fails it simply dies and returns a message to the screen.
     */
    public function redirect($url){
        header(URLROOT . $url);
        die('Redirect Failed');
    }

    /**
     * Adds an error message to the stack
     * @param string $message
     */
    public function addMessage($message, $level){
        $this->messages = array_merge($this->messages, [$message => $level]);
        $_SESSION['messages'] = $this->messages;
    }

    /**
     * Returns the current error array to a formatted list of alerts, returns an empty string if none are set
     * @return string
     */
    public function getMessages(): string{
        $outputStr = '';
        if(isset($_SESSION['messages']) && count($_SESSION['messages']) > 0) {
            foreach ($_SESSION['messages'] as $message => $level) {
                if($level === 'error') $level = 'danger';
                $outputStr .= '<div class="alert alert-' . strtolower($level) . '" role="alert">' . $message . '</div>';
            }
        }
        unset($_SESSION['messages']);
        return $outputStr;
    }
}
