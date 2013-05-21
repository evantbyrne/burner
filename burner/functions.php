<?php

/**
 * Root URL
 * @param boolean HTTPS
 * @return string The base URL
 */
function root_url($https = false) {

	return (($https) ? 'https://' : 'http://' ) . ((!\Core\Config::get('mod_rewrite')) ? \Core\Config::get('base_url') . 'index.php/' : \Core\Config::get('base_url'));

}

/**
 * URL
 * @param string Relative path to page
 * @param boolean HTTPS
 * @return string Full path to page
 */
function url($path = '', $https = null) {

	return root_url(($https === null) ? \Core\Config::get('https') : $https) . $path;

}

/**
 * Route URL
 * @param string GET or POST
 * @param string Namespace of Controller (in dot notation)
 * @param string Method
 * @param mixed Array of arguments, or null
 * @param boolean HTTPS
 * @return mixed Full path to page, or null
 */
function route_url($type, $controller, $method, $args = null, $https = false) {

	$routes = \Core\Route::all();
	foreach($routes as $path => $route) {
		
		// Check for matching controller and method
		if($route[0] == $controller and $route[1] == $method and preg_match("/^$type|both\:/is", $path)) {
			
			// Format the path
			$path = preg_replace('/^(get|post|both)\:/is', '', $path);
			$path = preg_replace('/^\//', '', $path);
			
			if(is_array($args)) {
				
				// Add arguments
				$segments = explode('/', $path);
				for($i = 0; $i < count($segments); $i++) {
						
					if(preg_match('/^\:/', $segments[$i])) {
							
						$segments[$i] = array_shift($args);
							
					}
					
				}
				
				$path = implode('/', $segments);
				
			}
			
			return url($path, $https);
			
		}
		
	}
	
	return null;

}
	
/**
 * Redirect
 * @param string URL to redirect to
 * @param boolean HTTPS
 */
function redirect($path = '', $https = false) {
	
	header('Location: ' . root_url($https) . $path);
	exit;
	
}

/**
 * Login Redirect
 * @param string URL to redirect to after logging in
 * @param boolean HTTPS
 */
function login_redirect($path = '', $https = false) {
	
	redirect('auth/login/' . base64_encode($path), $https);
	
}

/**
 * Is Get
 * @return boolean
 */
function is_get() {
	
	return ($_SERVER['REQUEST_METHOD'] == 'GET');
	
}

/**
 * Is Post
 * @return boolean
 */
function is_post() {
	
	return ($_SERVER['REQUEST_METHOD'] == 'POST');
	
}

/**
 * Escape
 */
function e($value) {

	return htmlentities($value);

}

/**
 * Trigger
 * @param string Event path
 * @param array Arguments
 * @return boolean Whether any event listeners were triggered
 */
function trigger($event, $args = array()) {

	$any = false;
	$dir = APPLICATION . "/listener/$event";

	if(is_dir($dir)) {

		$listeners = array();
		foreach(scandir($dir) as $file) {
			
			if(substr($file, -4) === '.php' and file_exists("$dir/$file")) {

				$klass = '\\App\\Listener\\' . str_replace('/', '\\', $event) . '\\'. substr($file, 0, -4);
				$priority = (isset($klass::$priority)) ? $klass::$priority : 0;
				$listeners[$klass] = $priority;
				$any = true;

			}

		}

		asort($listeners);
		foreach($listeners as $klass => $priority) {

			$listener = new $klass();
			call_user_func_array(array($listener, 'run'), $args);

		}

	}

	return $any;

}

/**
 * Random
 * @param int Minimum length of random range
 * @param int Maximum length of random range
 * @param string Available characters to be randomized
 * @return string A mixture of random characters
 */
function random($min = 10, $max = 30, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789=_') {
	
	$len = rand($min, $max);
	$salt = '';

	for($i = 0; $i < $len; $i++) {
	
		$salt .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
	
	}
	
	return $salt;

}

/**
 * To PHP Namespace
 * @param string Class name including full namespace in dot (Java) notation
 * @return string Full class name in traditional PHP namespace notation
 */
function to_php_namespace($class_name) {

	return ('\\' . str_replace('.', '\\', $class_name));

}