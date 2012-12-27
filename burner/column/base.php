<?php

namespace Column;

/**
 * Base Column Class
 * @author Evan Byrne
 */
abstract class Base {

	private $column_name;
	private $column;
	private $method;
	private $options;
	
	/**
	 * Construct
	 * @param string Column name
	 * @param array Options
	 * @param mixed \Mysql\TableColumn or null
	 */
	public function __construct($column_name, $options = array(), $column = null) {
	
		$this->column_name = $column_name;
		$this->method = array();
		$this->options = array_merge(array(
			
			'blank' => false,
			'choices' => null,
			'template' => 'text',
			'list_template' => null,
			'default' => null,
			'admin' => true
		
		), $options);
		
		if($column !== null) {
		
			$this->setcolumn($column);
			
		}
	
	}
	
	/**
	 * Column
	 * @return \Mysql\TableColumn
	 */
	public function column() {
	
		return $this->column;
	
	}
	
	/**
	 * Set Column
	 * @param \Mysql\TableColumn
	 * @return $this
	 */
	public function setcolumn($column) {
	
		$this->column = $column;
		return $this;
	
	}
	
	/**
	 * Column Name
	 * @return string
	 */
	public function column_name() {
	
		return $this->column_name;
	
	}

	/**
	 * Options
	 * @return array
	 */
	public function options() {
	
		return $this->options;
	
	}
	
	/**
	 * Get Option
	 * @param string Name
	 * @return mixed
	 */
	public function get_option($option) {
	
		return isset($this->options[$option]) ? $this->options[$option] : null;
	
	}
	
	/**
	 * Set Method
	 * @param string Name of method
	 * @param function Anonymous function
	 */
	public function set_method($name, $method) {
	
		$this->method[$name] = $method;
	
	}

	/**
	 * Get Method
	 * @param string Name
	 * @return mixed
	 */
	public function get_method($name) {
	
		return isset($this->method[$name]) ? $this->method[$name] : null;
	
	}
	
	/**
	 * Methods
	 * @return array Associated array of all set methods
	 */
	public function methods() {
	
		return $this->method;
	
	}
	
	/**
	 * Valid
	 * @param \Core\Model\Base
	 * @return boolean True if valid or no validation function given, a string on failure
	 */
	public function valid($model) {
	
		$value = (isset($model->{$this->column_name})) ? $model->{$this->column_name} : null;
		if(isset($this->options['required']) and empty($value)) {
		
			return $this->options['required'];
		
		}

		if(!empty($this->options['choices']) and !in_array($value, array_keys($this->options['choices']))) {

			return 'Invalid choice.';

		}
	
		if(isset($this->options['valid']) and is_callable($this->options['valid'])) {
		
			return $this->options['valid']($value);
		
		}

		$method = $this->column_name . '_validator';
		if(method_exists($model, $method)) {

			$res = $model->{$method}($value);
			if($res !== true) {

				return $res;

			}

		}
		
		return true;
	
	}

}