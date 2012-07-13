<?php

namespace Controller;

/**
 * Base Controller
 * @author Evan Byrne
 */
class Base {
	
	private $template = null;
	private $data = array();
	private $status_code = null;
	
	/**
	 * Template
	 * @param string
	 * @return $this
	 */
	public function template($template) {
		
		$this->template = $template;
		return $this;
		
	}
	
	/**
	 * Get Template
	 * @return string
	 */
	public function get_template() {
		
		return $this->template;
		
	}
	
	/**
	 * Data
	 * @param mixed Name or associative array of values
	 * @param mixed Value or null
	 * @return $this
	 */
	public function data($o, $value = null) {
		
		if(is_array($o)) {
			
			$this->data = array_merge($this->data, $o);
			
		} else {
		
			$this->data[$o] = $value;
		
		}
		
		return $this;
		
	}
	
	/**
	 * Get Data
	 * @return array
	 */
	public function get_data() {
		
		return $this->data;
		
	}
	
	/**
	 * Status Code
	 * @param int
	 * @return $this
	 */
	public function status_code($code) {
		
		$this->status_code = $code;
		return $this;
		
	}
	
	/**
	 * Get Status Code
	 * @return int
	 */
	public function get_status_code() {
		
		return $this->status_code;
		
	}
	
}