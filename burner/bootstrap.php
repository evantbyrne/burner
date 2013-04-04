<?php

namespace Core;

/**
 * Bootstrap Class
 * @author Evan Byrne
 */
class Bootstrap {
	
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
		require_once(BURNER . '/autoload.php');
		spl_autoload_register('Core\Autoload::get', true);
		
		// Load core files
		require_once(BURNER . '/config.php');
		require_once(BURNER . '/error.php');
		require_once(APPLICATION . '/config/' . CONFIGURATION . '/config.php');
		require_once(APPLICATION . '/config/' . CONFIGURATION . '/db.php');
		require_once(APPLICATION . '/config/' . CONFIGURATION . '/hash.php');
		require_once(BURNER . '/functions.php');
		require_once(BURNER . '/mysql.php');
		require_once(BURNER . '/response.php');
		
		set_error_handler('Core\burner_error');
		set_exception_handler('Core\burner_exception');
		
		// Load route configuration
		require_once(APPLICATION.'/config/route.php');
		
		global $argv;
		if(isset($argv)) {

			// Command line
			require_once(BURNER . '/cli.php');
			\Core\CLI::run();

		} else {

			// Web server
			\Core\Bootstrap::run();

		}
		
	}
	
	/**
	 * Controller
	 * @param string Namespace of Controller (in dot notation)
	 * @param string Method
	 * @param array Arguments
	 * @return \Core\Controller\Base Controller instance
	 */
	public static function controller($controller_ns, $method, $args = array()) {
		
		$ns = to_php_namespace($controller_ns);
		$controller = new $ns();
		
		// Check to see if method is callable
		if(!is_callable(array($controller, $method))) {
		
			throw new \Exception("Controller method <em>$method</em> not callable.");
		
		}
		
		$response = call_user_func_array(array($controller, $method), $args);
		if(!is_a($response, 'Core\Response')) {

			$controller_segments = explode('.', $controller_ns);
			$controller_name = end($controller_segments);

			$template = $controller->get_template();
			$response = Response::template(
				($template === null) ? "$controller_name/$method" : $template,
				$controller->get_data(),
				$controller->get_status_code());

		}
		
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
			
			self::controller('App.Controller.Error', '_404');
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