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

// Allowed characters in URL
define('ALLOWED_CHARS', '/^[ \!\,\~\&\.\:\+\@\-_a-zA-Z0-9]+$/');



// End of configuration
//----------------------------------------------------------------------------------------------
require_once(BURNER . '/bootstrap.php');
\Core\Bootstrap::init();
require_once(BURNER . '/functions.php');

if(isset($argv)) {
	
	// Command line
	require_once(BURNER . '/cli.php');
	\Core\CLI::run();
	
} else {

	// Web server
	\Core\Bootstrap::run();
	
}