<?php

namespace Page;

/**
 * Base Page Class
 * @author Evan Byrne
 */
class Base {

	public static $table = 'base';
	private $_blocks;
	
	/**
	 * Table
	 * @return Full name of database table (using late static binding)
	 */
	public static function table() {
	
		// TODO: Prepend table prefix if configured
		return static::$table;
	
	}
	
	/**
	 * Get
	 * @param ID of page
	 * @return \Page\Base object or false
	 */
	public static function get($id) {
	
		$s = new \Mysql\Generate\Select(self::table());
		$s->where('id', '=', $id);
		$s->limit(1);
		$res = \Dingo\DB::connection()->fetch($s->build(), '\\Page\\'.get_called_class());
		
		return (empty($res)) ? false : $res[0];
		
	}
	
	/**
	 * Construct
	 * @param Database table name
	 */
	public function __construct() {
	
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
	 * Create Table
	 * @return Result of CREATE TABLE query execution
	 */
	public function create_table() {
	
		$t = new \Mysql\Generate\CreateTable(self::table());
		$t->add(new \Mysql\Generate\IncrementingColumn('id'));
		
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
	
		$t = new \Mysql\Generate\DropTable(self::table());
		return \Dingo\DB::connection()->execute($t->build());
		
	}

}