<?php

namespace Core;

/**
 * Bootstrap Class
 * @author Evan Byrne
 */
class Bootstrap {
	
	/**
	 * Autoload
	 * @throws \Exception
	 * @param string Class to be loaded
	 * @return boolean
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
		
			case 'core':     $start = BURNER; break;
			case 'column':   $start = BURNER . '/column'; break;
			case 'library':  $start = BURNER . '/library'; break;
			case 'language': $start = APPLICATION . '/language/' . Config::get('language'); break;
			case true:       $start = APPLICATION . "/{$segments[$first]}"; break;
			default:         $start = APPLICATION; break;
		
		}
		
		// Combine into usuable path
		$path = "$start/" . implode('/', array_slice($segments, $first+1)) . '.php';
		
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
	 * @return string The cleaned up URL
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
		$url = (isset($_GET['__dingo_page'])) ? $_GET['__dingo_page'] : $url;
		
		//Tidy up the URL by removing trailing slashes
		$url = (!empty($url)) ? rtrim($url, '/') : '/';
		
		return $url;
	
	}
	
	/**
	 * Init
	 */
	public static function init() {
		
		// Fix magic quotes (from php.net)
		if(get_magic_quotes_gpc()) {
			
			$process = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
			while(list($key, $val) = each($process)) {
				
				foreach($val as $k => $v) {
					
					unset($process[$key][$k]);
					if (is_array($v)) {
					
						$process[$key][stripslashes($k)] = $v;
						$process[] = &$process[$key][stripslashes($k)];
					
					} else {
					
						$process[$key][stripslashes($k)] = stripslashes($v);
					
					}
				
				}
			
			}
			
			unset($process);
			
		}
		
		// Start buffer
		ob_start();
		
		// Set autoload
		spl_autoload_register('Core\Bootstrap::autoload', true);
		
		// Load core files
		require_once(BURNER . '/config.php');
		require_once(BURNER . '/error.php');
		require_once(APPLICATION . '/config/' . CONFIGURATION . '/config.php');
		require_once(APPLICATION . '/config/' . CONFIGURATION . '/db.php');
		require_once(APPLICATION . '/config/' . CONFIGURATION . '/hash.php');
		require_once(BURNER . '/mysql.php');
		require_once(BURNER . '/response.php');
		
		set_error_handler('Core\burner_error');
		set_exception_handler('Core\burner_exception');
		
		// Load route configuration
		require_once(APPLICATION.'/config/route.php');
		
	}
	
	/**
	 * Controller
	 * @param string Controller name
	 * @param string Method
	 * @param array Arguments
	 * @return \Core\Controller\Base Controller instance
	 */
	public static function controller($controller_name, $method, $args = array()) {
		
		$tmp = '\\Controller\\' . ucfirst($controller_name);
		$controller = new $tmp();
		
		// Check to see if method is callable
		if(!is_callable(array($controller, $method))) {
		
			throw new \Exception("Controller method <em>$method</em> not callable.");
		
		}
		
		call_user_func_array(array($controller, $method), $args);
		
		$template = $controller->get_template();
		$response = Response::template(
			($template === null) ? "$controller_name/$method" : $template,
			$controller->get_data(),
			$controller->get_status_code());
		
		header($response->header());
		echo $response->content();
		
		return $controller;
		
	}
	
	/**
	 * Run
	 */
	public static function run() {
		
		// Get route
		$request_url = self::get_request_url();
		$uri = Route::get($request_url);
		
		if($uri === false) {
			
			self::controller('error', '_404');
			exit;
			
		}
		
		// Set current page
		define('CURRENT_PAGE', $request_url);
		
		// Load controller
		self::controller($uri['controller'], $uri['method'], $uri['args']);
		
		// Display echoed content
		ob_end_flush();
	
	}

}