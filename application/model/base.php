<?php

namespace Model;

/**
 * Base Model
 * All models should extend this.
 * @author Evan Byrne
 */
class Base {
	
	/**
	 * MySQL storage engine to use
	 */
	public static $engine = 'MyISAM';
	
	/**
	 * Table
	 * @return Full name of database table (using late static binding)
	 */
	public static function table() {
	
		// TODO: Prepend table prefix if configured
		$parts = explode('\\', get_called_class());
		return strtolower(end($parts));
	
	}

	/**
	 * Select
	 * @return \Mysql\Select
	 */
	public static function select() {
	
		return \Dingo\DB::connection()->select(self::table(), '\\'.get_called_class());
		
	}

	/**
	 * Single
	 * @return \Mysql\Select
	 */
	public static function single() {

		return self::select()->limit(1);

	}

	/**
	 * ID
	 * @param int ID of row
	 * @return mixed \Model\Base object or null
	 */
	public static function id($id) {
	
		$res = self::single()->where('id', '=', $id)->fetch();
		return (empty($res)) ? null : $res[0];
		
	}

	/**
	 * Insert
	 * @return \Mysql\Insert
	 */
	public static function insert() {
	
		return \Dingo\DB::connection()->insert(self::table());
		
	}

	/**
	 * Update
	 * @return \Mysql\Update
	 */
	public static function update() {
	
		return \Dingo\DB::connection()->update(self::table());
		
	}

	/**
	 * Delete
	 * @return \Mysql\Delete
	 */
	public static function delete() {
	
		return \Dingo\DB::connection()->delete(self::table());
		
	}
	
	/**
	 * MySQL schema
	 */
	private $_schema = array();

	/**
	 * Whether methods array has been populated
	 */
	private $_methods_set = false;
	
	/**
	 * Array of methods dynamically set by columns
	 */
	private $_methods = array();
	
	/**
	 * Schema
	 * @param \Column\Base...
	 * @return $this
	 */
	public function schema() {

		foreach(func_get_args() as $addition) {

			$this->_schema[] = $addition;

		}

		return $this;

	}

	/**
	 * Get Schema
	 * @return array
	 */
	public function get_schema() {

		return $this->_schema;

	}
	
	/**
	 * Create Table
	 * @param If true, then create table only if it doesn't exist
	 * @param If true, then the function should return the SQL, and not create the table
	 * @return Result of CREATE TABLE query execution, or SQL
	 */
	public function create_table($if_not_exists = false, $sql = false) {
	
		$t = \Dingo\DB::connection()
			->create_table(self::table(), $if_not_exists)
			->engine(static::$engine)
			->add(new \Mysql\IncrementingColumn('id'))
			->add(new \Mysql\PrimaryKey('id'));
		
		// Loop model columns (using late static binding)
		foreach($this->get_schema() as $addition) {
		
			// Loop column columns
			$column = $addition->column();
			if($column !== null) {
			
				$t->add($column);
			
			}
		
		}
		
		return ($sql) ? $t->build()->sql() : $t->execute();
	
	}
	
	/**
	 * Drop Table
	 * @param If true, then drop table only if it exists
	 * @return Result of DROP TABLE query execution
	 */
	public function drop_table($if_exists = false) {
	
		return \Dingo\DB::connection()->drop_table(self::table(), $if_exists);
		
	}

	/**
	 * Call
	 * @param Name of method
	 * @param Arguments
	 * @return Mixed
	 */
	public function __call($method, $args) {
		
		if(!$this->_methods_set) {
			
			foreach($this->get_schema() as $addition) {

				$methods = $addition->methods();
				foreach($methods as $name => $func) {
					
					$this->_methods[$name] = $func;
					
				}

			}
			
			$this->_methods_set = true;
			
		}
		
		if(isset($this->_methods[$method]) and is_callable($this->_methods[$method])) {
		
			$func = $this->_methods[$method];
			array_unshift($args, $this);
			return call_user_func_array($func, $args);
			
		}
		
	}

}