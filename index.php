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

// Config directory location (in relation to application location)
define('CONFIG','config');

// Allowed characters in URL
define('ALLOWED_CHARS','/^[ \!\,\~\&\.\:\+\@\-_a-zA-Z0-9]+$/');



// End of configuration
//----------------------------------------------------------------------------------------------
define('DINGO',1);
require_once(APPLICATION.'/system/core/bootstrap.php');
\Dingo\Bootstrap::run();