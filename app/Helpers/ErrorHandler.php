<?php
namespace App\Helpers;

class ErrorHandler {

    public function __construct(){

    }

    /**
     * Error handling function, grabs the error, creates a message, and adds it to the $_SESSION['messages'] stack
     * that is displayed the next time the page refreshes
     */
    public static function myCustomErrorHandler(int $errNo, string $errMsg, string $file, int $line){
        // Don't display error if no error number
        if( !(error_reporting() && $errNo) ){
            return;
        }

        // Records errors according to the error number
        //display errors according to the error number
        switch ($errNo)
        {
            case E_USER_ERROR:
                $str = "<b>ERROR</b> [$errNo] $errMsg<br />\n
                       Fatal error on line $line in file $file
                       PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n
                       Aborting...<br />\n";
                break;

            case E_USER_WARNING:
                $str = "<b>WARNING</b> [$errNo] $errMsg<br />\n";
                break;

            case E_USER_NOTICE:
                $str =  "<b>NOTICE</b> [$errNo] $errMsg<br />\n";
                break;

            default:
                $str = "<b>UNKNOWN ERROR</b> [$errNo] $errMsg<br />\n";
                break;
        }
        if($str != ""){
            $_SESSION['messages'] = array_merge($_SESSION['messages'], [$str => 'error']);
        }

        //don't execute PHP internal error handler
        return true;
    }
}
