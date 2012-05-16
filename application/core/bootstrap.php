<?php

namespace Dingo;

/**
 * Bootstrap Class
 * @author Evan Byrne
 */
class Bootstrap {
	
	/**
	 * Autoload
	 * @param String representing class to be loaded
	 */
	public static function autoload($class) {
		
		// Split into segments
		$segments = explode('\\', strtolower($class));
		
		if(empty($segments)) {
		
			throw new \Exception("Nothing to autoload!");
			return false;
		
		}
		
		// Compensate for some classes not starting with backslash
		$first = preg_match('/^\\\/', $class) ? 1 : 0;
		
		switch($segments[$first]) {
		
			case 'dingo':      $start = APPLICATION.'/core'; break;
			case 'library':    $start = APPLICATION.'/library'; break;
			case 'controller': $start = APPLICATION.'/controller'; break;
			case 'model':      $start = APPLICATION.'/model'; break;
			case 'block':      $start = APPLICATION.'/block'; break;
			default: return false; break;
		
		}
		
		// Combine into usuable path
		$path = "$start/{$segments[$first+1]}.php";
		
		if(file_exists($path)) {
		
			include_once($path);
			return true;
		
		} else {
		
			throw new \Exception("File at <strong>$path</strong> could not be autoloaded");
			return false;
		
		}
	
	}
	
	
	/**
	 * Get Request URL
	 * Grabs the requested URL, parses it, then cleans it up.
	 * @return The cleaned up URL
	 */
	public static function get_request_url() {
		
		// Get the filename of the currently executing script relative to docroot
		$url = (empty($_SERVER['PHP_SELF'])) ? $_SERVER['PHP_SELF'] : '/';
		
		// Get the current script name (eg. /index.php)
		$script_name = (isset($_SERVER['SCRIPT_NAME'])) ? $_SERVER['SCRIPT_NAME'] : $url;
		
		// Parse URL, check for PATH_INFO and ORIG_PATH_INFO server params respectively
		$url = (0 !== stripos($url, $script_name)) ? $url : substr($url, strlen($script_name));
		$url = (empty($_SERVER['PATH_INFO'])) ? $url : $_SERVER['PATH_INFO'];
		$url = (empty($_SERVER['ORIG_PATH_INFO'])) ? $url : $_SERVER['ORIG_PATH_INFO'];
		
		// Check for GET __dingo_page
		$url = (input::get('__dingo_page')) ? input::get('__dingo_page') : $url;
		
		//Tidy up the URL by removing trailing slashes
		$url = (!empty($url)) ? rtrim($url, '/') : '/';
		
		return $url;
	
	}
	
	
	/**
	 * Run
	 * Starts everything up.
	 */
	public static function run() {
	
		define('DINGO_VERSION','0.8');
		
		// Start buffer
		ob_start();
		
		// Set autoload
		spl_autoload_register('Dingo\Bootstrap::autoload', true);
		
		// Load core files
		require_once(APPLICATION.'/core/core.php');
		require_once(APPLICATION.'/core/config.php');
		require_once(APPLICATION.'/core/error.php');
		require_once(APPLICATION.'/config/'.CONFIGURATION.'/config.php');
		require_once(APPLICATION.'/config/'.CONFIGURATION.'/db.php');
		require_once(APPLICATION.'/core/mysql/generate.php');
		require_once(APPLICATION.'/core/mysql/connection.php');
		require_once(APPLICATION.'/core/model.php');
		require_once(APPLICATION.'/core/block.php');
		
		set_error_handler('Dingo\dingo_error');
		set_exception_handler('Dingo\dingo_exception');
		
		// Load route configuration
		require_once(APPLICATION.'/config/route.php');
		
		// Get route
		$request_url = self::get_request_url();
		$uri = Route::get($request_url);
		
		// Set current page
		define('CURRENT_PAGE', $request_url);
		
		
		// Load Controller
		//----------------------------------------------------------------------------------------------
		
		// If controller does not exist, give 404 error
		if(!file_exists(APPLICATION."/controller/{$uri['controller']}.php")) {
		
			Load::error('404');
		
		}
		
		// Initialize controller
		$tmp = '\\Controller\\'.ucfirst($uri['controller']);
		$controller = new $tmp();
		
		// Check to see if function exists
		if(!is_callable(array($controller, $uri['method']))) {
		
			Load::error('404');
		
		}
		
		// Run Function
		$response = call_user_func_array(array($controller, $uri['method']), $uri['args']);
		header($response->header());
		echo $response->content();
		
		// Display echoed content
		ob_end_flush();
	
	}

}