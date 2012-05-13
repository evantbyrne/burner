<?php

namespace Block;

/**
 * Base Block Class
 * @author Evan Byrne
 */
class Base {

	private $_columns;
	
	/**
	 * Construct
	 */
	public function __construct() {
	
		$this->_columns = array();
	
	}
	
	/**
	 * Add
	 * @param Database column
	 */
	public function add($column) {
	
		// TODO: Validate that $column inherits \Mysql\Generate\TableColumn
		$this->_columns[] = $column;
	
	}
	
	/**
	 * Columns
	 * @return Array of database columns
	 */
	public function columns() {
	
		return $this->_columns;
	
	}

}