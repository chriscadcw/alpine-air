<?php
// Set up our database parameters
const DB_HOST = 'alpineair_db';
const DB_USER = 'root';
const DB_PASS = 'secret';
const DB_NAME = 'alpineair';

// Set the URL and APP roots to constants
// App Root - Uses `define` as const does not accept output from a function for definition
define('APPROOT', dirname(__FILE__,2));
// URL Root
const URLROOT = 'https://alpine.localhost';
// Site Name
const SITENAME = 'Alpine Air Test Site';
