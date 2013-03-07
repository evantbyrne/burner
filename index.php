<?php

// Application configuration
//----------------------------------------------------------------------------------------------


// Configuration
define('CONFIGURATION', 'development');

// Application location
define('APPLICATION', 'app');

// Location of Burner core
define('BURNER', 'burner');


// End of configuration
//----------------------------------------------------------------------------------------------
require_once(BURNER . '/bootstrap.php');
\Core\Bootstrap::init();