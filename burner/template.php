<?php

namespace Core;

/**
 * Template Class
 * @author Evan Byrne
 */
class Template {
	
	private $extensions = array();
	private $sections = array();
	private $current_section = false;
	private $current_new_section = false;
	private $out;
	private $data;
	private $first;
	
	/**
	 * Render
	 * @param string Template
	 * @param array Data
	 * @return string Output
	 */
	public static function render($template, $data = array()) {
	
		$v = new Template($template, $data);
		return $v->output();
	
	}
	
	/**
	 * Construct
	 * @param string Template
	 * @param array Data
	 */
	public function __construct($template, $data = array()) {
		
		$this->out = '';
		$this->data = $data;
		$this->first = true;
		$this->load($template, $data);
		
		// Load extensions
		foreach($this->extensions as $e) {
		
			$this->load($e['template'], $e['data']);
		
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
	 * @param string Template
	 * @param array Data
	 * @return boolean Success
	 */
	public function load($template, $data = NULL) {
		
		// If view does not exist display error
		if(!file_exists(APPLICATION."/template/$template.php")) {
			
			dingo_error(E_USER_WARNING,'The requested template ('.APPLICATION."/template/$template.php) could not be found.");
			return false;
			
		} else {
			
			// If data is array, convert keys to variables
			if(is_array($data)) {
				
				extract($data, EXTR_OVERWRITE);
			
			}
			
			require(APPLICATION."/template/$template.php");
			return true;
		
		}
		
	}
	
	/**
	 * Base
	 * @param string Template
	 * @param array Data
	 */
	public function base($template, $data=array()) {
	
		$this->extensions[] = array('template'=>$template, 'data'=>$data);
	
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
	 * Set
	 * @param string Section name
	 * @param string Data
	 */
	public function set($name, $data) {

		$this->sections[$name] = $data;

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
	 * @param string Data key to run htmlentities on and then display
	 * @param string Fallback value to display
	 */
	public function show($key, $default = null) {
	
		echo (empty($this->data[$key])) ? $default : htmlentities($this->data[$key]);
	
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

	/**
	 * First
	 * @return boolean
	 */
	public function first() {

		if($this->first === true) {

			$this->first = false;
			return true;

		}

		return false;

	}
	
	/**
	 * Reset First
	 */
	public function reset_first() {

		$this->first = true;

	}
	
}