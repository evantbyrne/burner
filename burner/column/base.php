<?php

namespace Column;

/**
 * Base Column Class
 * @author Evan Byrne
 */
abstract class Base {

	private $_column_name;
	private $_column;
	private $_methods;
	private $_options;
	
	/**
	 * Construct
	 */
	public function __construct($column_name, $options = array(), $column = null) {
	
		// TODO: Validate column name
		$this->_column_name = $column_name;
		$this->_methods = array();
		$this->_options = array_merge(array('blank' => false, 'choices' => null, 'template' => 'text'), $options);
		
		if($column !== null) {
		
			$this->set_column($column);
			
		}
	
	}
	
	/**
	 * Column
	 * @return Database column
	 */
	public function column() {
	
		return $this->_column;
	
	}
	
	/**
	 * Set Column
	 * @param Database column
	 * @return This
	 */
	public function set_column($column) {
	
		// TODO: Validate that $column inherits \Mysql\TableColumn
		$this->_column = $column;
		return $this;
	
	}
	
	/**
	 * Column Name
	 * @return Column name
	 */
	public function column_name() {
	
		return $this->_column_name;
	
	}

	/**
	 * Options
	 * @return array
	 */
	public function options() {
	
		return $this->_options;
	
	}
	
	/**
	 * Get Option
	 * @param string Name
	 * @return mixed
	 */
	public function get_option($option) {
	
		return isset($this->_options[$option]) ? $this->_options[$option] : null;
	
	}
	
	/**
	 * Set Method
	 * @param Name of method
	 * @param Anonymous function
	 */
	public function set_method($name, $method) {
	
		$this->_methods[$name] = $method;
	
	}

	/**
	 * Get Method
	 * @param string Name
	 * @return mixed
	 */
	public function get_method($name) {
	
		return isset($this->_methods[$name]) ? $this->_methods[$name] : null;
	
	}
	
	/**
	 * Methods
	 * @return Associated array of all set methods
	 */
	public function methods() {
	
		return $this->_methods;
	
	}
	
	/**
	 * Valid
	 * @return True if valid or no validation function given, a string on failure
	 */
	public function valid($value) {
	
		if(isset($this->_options['required']) and empty($value)) {
		
			return $this->_options['required'];
		
		}

		if(!empty($this->_options['choices']) and !in_array($value, array_keys($this->_options['choices']))) {

			return 'Invalid choice.';

		}
	
		if(isset($this->_options['valid']) and is_callable($this->_options['valid'])) {
		
			return $this->_options['valid']($value);
		
		}
		
		return true;
	
	}

}