<?php

// Application configuration
//----------------------------------------------------------------------------------------------

ini_set('display_errors', 'On');

// Error reporting level
error_reporting(E_STRICT|E_ALL);

// Static location
define('STATIC','static');

// Configuration
define('CONFIGURATION','development');

// Application location
define('APPLICATION','application');

// Allowed characters in URL
define('ALLOWED_CHARS','/^[ \!\,\~\&\.\:\+\@\-_a-zA-Z0-9]+$/');



// End of configuration
//----------------------------------------------------------------------------------------------
require_once(APPLICATION.'/core/bootstrap.php');
\Core\Bootstrap::init();
require_once(APPLICATION.'/core/functions.php');

if(isset($argv)) {
	
	// Command line
	require_once(APPLICATION.'/core/cli.php');
	\Core\CLI::run();
	
} else {

	// Web server
	\Core\Bootstrap::run();
	
}