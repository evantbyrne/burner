<?php

namespace Dingo;

/**
 * View Class
 * @author Evan Byrne
 */
class View {
	
	private $extensions = array();
	private $sections = array();
	private $current_section = false;
	private $current_new_section = false;
	private $out;
	private $data;
	
	/**
	 * Render
	 * @param string View
	 * @param array Data
	 * @return string Output
	 */
	public static function render($view, $data = array()) {
	
		$v = new View($view, $data);
		return $v->output();
	
	}
	
	/**
	 * Construct
	 * @param string View
	 * @param array Data
	 */
	public function __construct($view, $data = array()) {
		
		$this->out = '';
		$this->data = $data;
		$this->load($view, $data);
		
		// Load extensions
		foreach($this->extensions as $e) {
		
			//print_r($e);
			$this->load($e['view'], $e['data']);
		
		}
		
		$this->out .= ob_get_clean();
		ob_start();
	
	}
	
	/**
	 * Output
	 * @return string
	 */
	public function output() {
	
		return $this->out;
	
	}
	
	/**
	 * Load
	 * @param string View
	 * @param array Data
	 * @return boolean Success
	 */
	public function load($view,$data = NULL) {
		
		// If view does not exist display error
		if(!file_exists(APPLICATION."/view/$view.php")) {
			
			dingo_error(E_USER_WARNING,'The requested view ('.APPLICATION."/view/$view.php) could not be found.");
			return false;
			
		} else {
			
			// If data is array, convert keys to variables
			if(is_array($data)) {
				
				extract($data, EXTR_OVERWRITE);
			
			}
			
			require(APPLICATION."/view/$view.php");
			return true;
		
		}
		
	}
	
	/**
	 * Base
	 * @param string View
	 * @param array Data
	 */
	public function base($view, $data=array()) {
	
		$this->extensions[] = array('view'=>$view, 'data'=>$data);
	
	}
	
	/**
	 * Extend
	 * @param string Section name
	 */
	public function extend($name) {
	
		ob_clean();
		$this->current_section = $name;
		$this->out .= ob_get_clean();
		ob_start();
	
	}
	
	/**
	 * End Extend
	 */
	public function end_extend() {
	
		$data = ob_get_clean();
		$this->sections[$this->current_section] = $data;
		$this->current_section = false;
		ob_start();
	
	}
	
	
	/**
	 * Section
	 * @param string Section name
	 * @param boolean Default
	 */
	public function section($name, $default=true) {
	
		if(!$default) {
		
			echo $this->sections[$name];
			
		} else {
			
			$this->current_new_section = $name;
			$this->out .= ob_get_clean();
			ob_start();
		
		}
	
	}
	
	/**
	 * End Section
	 */
	public function end_section() {
	
		if(isset($this->sections[$this->current_new_section])) {
		
			ob_clean();
			echo $this->sections[$this->current_new_section];
		
		}
		
		$this->current_new_section = false;
	
	}
	
	/**
	 * Show
	 * @param string Data key to display
	 * @param string Fallback value to display
	 */
	public function show($key, $default = null) {
	
		echo (empty($this->data[$key])) ? $default : $this->data[$key];
	
	}
	
	/**
	 * Page
	 * @param string URL relative to base
	 */
	public function page($page = '') {
	
		echo \Library\Url::page($page);
	
	}

	/**
	 * Error
	 * @param string Name of error
	 */
	public function error($error) {

		if(isset($this->data['errors'][$error])) {

			echo self::render('error/form', array('content' => $this->data['errors'][$error]));

		}

	}
	
}