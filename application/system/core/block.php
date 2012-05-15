<?php

namespace Block;

/**
 * Base Block Class
 * @author Evan Byrne
 */
class Base {

	private $_column_name;
	private $_column;
	private $_options;
	
	/**
	 * Construct
	 */
	public function __construct($column_name, $options = array(), $column = null) {
	
		// TODO: Validate column name
		$this->_column_name = $column_name;
		$this->_options = $options;
		
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
	 */
	public function set_column($column) {
	
		// TODO: Validate that $column inherits \Mysql\Generate\TableColumn
		return $this->_column = $column;
	
	}
	
	/**
	 * Column Name
	 * @return Column name
	 */
	public function column_name() {
	
		return $this->_column_name;
	
	}
	
	/**
	 * Valid
	 * @return True if valid or no validation function given, a string on failure
	 */
	public function valid($value) {
	
		if(isset($this->_options['valid']) and is_callable($this->_options['valid'])) {
		
			return $this->_options['valid']($value);
		
		}
		
		return true;
	
	}

}