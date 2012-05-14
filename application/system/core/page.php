<?php

namespace Page;

/**
 * Base Page Class
 * @author Evan Byrne
 */
class Base {

	private $_table;
	private $_blocks;
	
	/**
	 * Construct
	 * @param Database table name
	 */
	public function __construct($table) {
	
		$this->_table = $table;
		$this->_blocks = array();
	
	}
	
	/**
	 * Add
	 * @param Block object
	 */
	public function add($block) {
	
		// TODO: Validate that $block inherits \Block\Base
		$this->_blocks[] = $block;
	
	}

	/**
	 * Table
	 * @return Full name of database table
	 */
	public function table() {
	
		return $this->_table;
	
	}
	
	/**
	 * Create Table
	 * @return Result of CREATE TABLE query execution
	 */
	public function create_table() {
	
		$t = new \Mysql\Generate\CreateTable($this->table());
		
		// Loop page blocks
		foreach($this->_blocks as $block) {
		
			// Loop block columns
			$columns = $block->columns();
			foreach($columns as $column) {
			
				$t->add($column);
			
			}
		
		}
		
		return \Dingo\DB::connection()->execute($t->build());
	
	}
	
	/**
	 * Drop Table
	 * @return Result of DROP TABLE query execution
	 */
	public function drop_table() {
	
		$t = new \Mysql\Generate\DropTable($this->table());
		return \Dingo\DB::connection()->execute($t->build());
		
	}

}