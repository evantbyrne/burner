<?php

namespace Core;


// You might want to comment this out...
ini_set('display_errors', 'On');

// Error reporting level
error_reporting(E_STRICT|E_ALL);

// Application's Base URL (including trailing slash)
define('BASE_URL', 'localhost:8888/beaker-burner/');

// Does Application Use Mod_Rewrite URLs?
define('MOD_REWRITE', true);

// Turn Debugging On?
define('DEBUG', true);

// Turn Error Logging On?
define('ERROR_LOGGING', false);

// Error Log File Location
define('ERROR_LOG_FILE', 'log.txt');

// Template engine
define('TEMPLATE_LIBRARY', 'Library.Template.Standard');

// Admin
define('ADMIN_PAGE_SIZE', 10);



// Default language
Config::set('language', 'english');

// Sessions
Config::set('session', array(
	'path'   => '/',
	'expire' => '+1 months'
));



/**
 * Your Application's Default Timezone
 * Syntax for your local timezone can be found at
 * http://www.php.net/timezones
 */
date_default_timezone_set('America/New_York');