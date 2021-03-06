<?php

namespace Core;


// You might want to comment this out...
ini_set('display_errors', 'On');

// Error reporting level
error_reporting(E_STRICT|E_ALL);

// Your Application's Default Timezone (http://www.php.net/timezones)
date_default_timezone_set('America/New_York');



// Application's Base URL (including trailing slash)
Config::set('base_url', 'localhost:8888/beaker-burner/');

// Use HTTPS URLs?
Config::set('https', false);

// Does Application Use Mod_Rewrite URLs?
Config::set('mod_rewrite', true);

// Debugging
Config::set('debug', true);

// Error logging
Config::set('error_logging', false);
Config::set('error_logging_file', 'errors.txt');

// Template engine
Config::set('template_library', 'Library.Template.Standard');

// Auth
Config::set('auth_plugin', 'MultipleGroups');

// Admin
Config::set('admin_page_size', 10);
Config::set('admin_https_urls', false);
Config::set('admin_models', array(
	'Users' => array('user', 'group', 'membership')
));

// Default language
Config::set('language', 'english');

// Session
Config::set('session', array(
	'path'   => '/',
	'expire' => '+1 months'
));