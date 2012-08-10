<?php

/**
 * Root URL
 * @param Whether to include index.php/ in URL
 * @return The base URL
 */
function root_url() {

	return (!MOD_REWRITE) ? BASE_URL . 'index.php/' : BASE_URL;

}

/**
 * URL
 * @param string Relative path to page
 * @return string Full path to page
 */
function url($path = '') {

	return root_url() . $path;

}

/**
 * Route URL
 * @param string GET or POST
 * @param string Controller
 * @param string Method
 * @param mixed Array of arguments, or null
 * @return mixed Full path to page, or null
 */
function route_url($type, $controller, $method, $args = null) {

	$routes = \Core\Route::all();
	foreach($routes as $path => $route) {
		
		// Check for matching controller and method
		if($route[0] == $controller and $route[1] == $method and preg_match("/^$type\:/is", $path)) {
			
			// Format the path
			$path = preg_replace('/^(get|post)\:/is', '', $path);
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
			
			return url($path);
			
		}
		
	}
	
	return null;

}
	
/**
 * Redirect
 * @param string URL to redirect to
 */
function redirect($path = '') {
	
	header('Location: ' . root_url(true) . $path);
	exit;
	
}

/**
 * Login Redirect
 * @param string URL to redirect to after logging in
 */
function login_redirect($path = '') {
	
	redirect('auth/login/' . base64_encode($path));
	
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

	echo htmlentities($value);

}

/**
 * Hook
 * @param string Hook name
 * @param string Static method to call
 * @param mixed Array of arguments, or null
 * @return mixed Result of method call, or null on hook not found
 */
function hook($hook, $method, $arguments = null) {
	
	if(file_exists(APPLICATION . '/hook/' . strtolower($hook) . '.php')) {
		
		$name = "\\Hook\\$hook::$method";
		if(is_callable($name)) {
		
			return call_user_func_array($name, $arguments);
		
		}
		
	} else {
		
		return null;
		
	}
	
}