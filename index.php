<?php

// Application configuration
//----------------------------------------------------------------------------------------------



// You might want to comment this out...
ini_set('display_errors', 'On');

// Error reporting level
error_reporting(E_STRICT|E_ALL);

// Static location
define('STATIC', 'static');

// Configuration
define('CONFIGURATION', 'development');

// Application location
define('APPLICATION', 'application');

// Location of Burner core
define('BURNER', 'burner');


// End of configuration
//----------------------------------------------------------------------------------------------
require_once(BURNER . '/bootstrap.php');
\Core\Bootstrap::init();