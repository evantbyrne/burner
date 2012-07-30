<?php

namespace Core;


// Application's Base URL
define('BASE_URL','http://localhost:8888/beaker-burner/');

// Does Application Use Mod_Rewrite URLs?
define('MOD_REWRITE', true);

// Turn Debugging On?
define('DEBUG', true);

// Turn Error Logging On?
define('ERROR_LOGGING', false);

// Error Log File Location
define('ERROR_LOG_FILE','log.txt');


/**
 * Your Application's Default Timezone
 * Syntax for your local timezone can be found at
 * http://www.php.net/timezones
 */
date_default_timezone_set('America/New_York');


// Default language
Config::set('language', 'english');

/* Sessions */
Config::set('session',array(
	'connection'=>'default',
	'table'=>'sessions',
	'cookie'=>array('path'=>'/','expire'=>'+1 months')
));

/* Notes */
Config::set('notes',array('path'=>'/','expire'=>'+5 minutes'));
