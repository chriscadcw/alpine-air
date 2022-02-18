<?php
/**
 * This file configures our app and sets up the custom autoloader 
 */
// Load the config file
require_once 'config/config.php';

set_error_handler('App\\Helpers\\ErrorHandler::myCustomErrorHandler');

if(!isset($_SESSION['messages'])){
    $_SESSION['messages'] = [];
}
