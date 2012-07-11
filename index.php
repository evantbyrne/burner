<?php

// Application configuration
//----------------------------------------------------------------------------------------------

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
\Dingo\Bootstrap::init();
require_once(APPLICATION.'/core/functions.php');

if(isset($argv)) {
	
	// Command line
	require_once(APPLICATION.'/core/cli.php');
	\Dingo\CLI::run();
	
} else {

	// Web server
	\Dingo\Bootstrap::run();
	
}