<?php

namespace Dingo;
use Dingo\Load;

/**
 * Dingo Framework View Class
 *
 * @Author          Evan Byrne
 * @Copyright       2008 - 2012
 * @Project Page    http://www.dingoframework.com
 */

class View {
	
	private $extensions = array();
	private $sections = array();
	private $current_section = false;
	private $current_new_section = false;
	private $out;
	
	
	// Render
	// ---------------------------------------------------------------------------
	public static function render($view, $data = array()) {
	
		$v = new View($view, $data);
		return $v->output();
	
	}
	
	
	// Construct
	// ---------------------------------------------------------------------------
	public function __construct($view, $data = array()) {
		
		$this->output = '';
		$this->load($view, $data);
		
		// Load extensions
		foreach($this->extensions as $e) {
		
			//print_r($e);
			$this->load($e['view'], $e['data']);
		
		}
		
		$this->out = ob_get_clean();
		ob_start();
	
	}
	
	
	// Output
	// ---------------------------------------------------------------------------
	public function output() {
	
		return $this->out;
	
	}
	
	
	// Load
	// ---------------------------------------------------------------------------
	public function load($view,$data = NULL) {
		
		// If view does not exist display error
		if(!file_exists(Config::get('application').'/'.Config::get('folder_views')."/$view.php")) {
			
			dingo_error(E_USER_WARNING,'The requested view ('.Config::get('application').'/'.Config::get('folder_views')."/$view.php) could not be found.");
			return false;
			
		} else {
			
			// If data is array, convert keys to variables
			if(is_array($data)) {
				
				extract($data, EXTR_OVERWRITE);
			
			}
			
			require(Config::get('application').'/'.Config::get('folder_views')."/$view.php");
			return true;
		
		}
		
	}
	
	
	// Base
	// ---------------------------------------------------------------------------
	public function base($view, $data=array()) {
	
		$this->extensions[] = array('view'=>$view, 'data'=>$data);
	
	}
	
	
	// Extend
	// ---------------------------------------------------------------------------
	public function extend($name) {
	
		ob_clean();
		$this->current_section = $name;
		ob_end_flush();
		ob_start();
	
	}
	
	
	// End Extend
	// ---------------------------------------------------------------------------
	public function end_extend() {
	
		$data = ob_get_clean();
		$this->sections[$this->current_section] = $data;
		$this->current_section = false;
		ob_start();
	
	}
	
	
	// Section
	// ---------------------------------------------------------------------------
	public function section($name, $default=true) {
	
		if(!$default) {
		
			echo $this->sections[$name];
			
		} else {
			
			$this->current_new_section = $name;
			ob_end_flush();
			ob_start();
		
		}
	
	}
	
	
	// End Section
	// ---------------------------------------------------------------------------
	public function end_section() {
	
		if(isset($this->sections[$this->current_new_section])) {
		
			ob_clean();
			echo $this->sections[$this->current_new_section];
		
		}
		
		$this->current_new_section = false;
	
	}
	
}