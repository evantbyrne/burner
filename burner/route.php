<?php

namespace Core;

/**
 * Route Class
 * @author Evan Byrne
 */
class Route {
	
	/**
	 * Routes
	 */
	private static $route = array();
	
	/**
	 * Current route information
	 */
	private static $current = array();
	
	/**
	 * Routes patterns
	 */
	private static $pattern = array(
	
		'int'           => '/^([0-9]+)$/',
		'numeric'       => '/^([0-9\.]+)$/',
		'alpha'         => '/^([a-zA-Z]+)$/',
		'alpha-int'     => '/^([a-zA-Z0-9]+)$/',
		'alpha-numeric' => '/^([a-zA-Z0-9\.]+)$/',
		'words'         => '/^([_a-zA-Z0-9\- ]+)$/',
		'any'           => '/^(.*?)$/',
		'extension'     => '/^([a-zA-Z]+)\.([a-zA-Z]+)$/'
	
	);
	
	/**
	 * Validate
	 * @param string Route
	 */
	public static function valid($r) {
		
		foreach($r['segments'] as $segment) {
			
			if(!preg_match(ALLOWED_CHARS,$segment)) {
				
				return false;
			
			}
		
		}
		
		return true;
		
	}
	
	/**
	 * Pattern
	 * @param string Name
	 * @param string Regular expression
	 */
	public static function pattern($name, $regex) {
	
		self::$pattern[$name] = $regex;
	
	}

	/**
	 * Vendor
	 * @param string Vendor sub-app name
	 */
	public static function vendor($vendor) {

		$path = APPLICATION . "/vendor/$vendor/config/route.php";
		
		if(!file_exists($path)) {

			throw new \Exception("Route file not found at '$path'");

		}

		require($path);

	}
	
	/**
	 * Add
	 * @param string Namespace of Controller (in dot notation)
	 * @param array Routes in array('url' => 'method', ...) format
	 */
	public static function add($ns, $routes) {
		
		foreach($routes as $url => $method) {
		
			self::$route[$url] = array($ns, $method);
		
		}
		
	}
	
	/**
	 * All
	 * @return array
	 */
	public static function all() {
		
		return self::$route;
		
	}
	
	/**
	 * Get
	 * @param string URL
	 * @return array Route in array('controller', 'method', array()) format
	 */
	public static function get($url) {
	
		$controller = false;
		$method = false;
		
		$url = preg_replace('/^(\/)/','',$url); // Remove beginning slash
		$segments = explode('/', $url);         // Split into segments
		
		
		// 1) Default route
		if(empty($segments[0])) {
			
			// Get
			if(isset(self::$route['GET:/'])) {
			
				return array('controller'=>self::$route['GET:/'][0], 'method'=>self::$route['GET:/'][1], 'args'=>array());
			
			}
			
			// No default route
			else {
			
				throw new Exception('Default route not set.');
			
			}
		
		}
		
		
		// 2) Loops routes
		foreach(self::$route as $pattern => $location) {
			
			$is_get = preg_match('/^GET/', $pattern);
			$is_post = preg_match('/^POST/', $pattern);
			$is_both = preg_match('/^BOTH/', $pattern);
			$pattern = preg_replace('/^(GET|POST|BOTH)\:/', '', $pattern);
			
			// Skip routes of wrong request type
			if((!$is_both) and (($is_get and $_SERVER['REQUEST_METHOD'] != 'GET') or ($is_post and $_SERVER['REQUEST_METHOD'] != 'POST'))) {
			
				continue;
			
			}
			
			// Skip default route
			if($pattern != '/') {
			
				$pattern_segments = explode('/', $pattern);
				
				// Skip if segment count doesn't match
				// TODO: Add checks for special segment types
				if(count($pattern_segments) == count($segments)) {
					
					$args = array_slice($location, 2); // Get defined argument values in route
					
					// Loop pattern segments
					for($i = 0; $i < count($pattern_segments); $i++) {
						
						// Pattern segment
						if(preg_match('/^:/', $pattern_segments[$i])) {
						
							// Check to see if they don't match pattern
							if(!preg_match(self::$pattern[substr($pattern_segments[$i], 1)], $segments[$i])) {
								
								// Skip to next route entry
								continue 2;
							
							} else {
							
								// Add to arguments array
								$args[] = $segments[$i];
							
							}
						
						// Regular segment
						} else {
						
							// Check to see if they don't match
							if($segments[$i] != $pattern_segments[$i]) {
							
								// Skip to next route entry
								continue 2;
							
							}
						
						}
					
					}
					
					// If it gets to here, then everything matches
					return array('controller'=>$location[0], 'method'=>$location[1], 'args'=>$args);
				
				}
			
			}
		
		}
		
		return false;
		
	}
	
	/**
	 * Controller
	 * @param string Path
	 * @return string
	 */
	public static function controller($path = false) {
		
		return ($path) ? self::$current['controller'] : self::$current['controller_class'];
	
	}
	
	/**
	 * Method
	 * @return string
	 */
	public static function method() {
		
		return self::$current['function'];
		
	}
	
	/**
	 * Arguments
	 */
	public static function arguments() {
		
		return self::$current['arguments'];
	
	}
	
}