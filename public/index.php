<?php
session_start();
require_once '../vendor/autoload.php';
use App\Lib\Core;

// Bootstrap our app
require_once('../app/bootstrap.php');

// Initialize the app
$init = new Core();
