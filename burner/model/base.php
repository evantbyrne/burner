<?php

namespace Core\Model;

/**
 * Base Model
 * All models should extend this.
 * @author Evan Byrne
 */
class Base extends \Core\Form\Base {

	/**
	 * string MySQL storage engine to use
	 */
	public static $engine = 'InnoDB';

	/**
	 * mixed Verbose name
	 */
	public static $verbose = null;

	/**
	 * mixed Verbose plural name
	 */
	public static $verbose_plural = null;
	
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
	 * Get Verbose
	 * @return string
	 */
	public static function get_verbose() {

		if(static::$verbose === null) {

			$c = explode('\\', get_called_class());
			return end($c);

		}

		return static::$verbose;

	}

	/**
	 * Get Verbose Plural
	 * @return string
	 */
	public static function get_verbose_plural() {

		return (static::$verbose_plural === null) ? self::get_verbose() . 's' : static::$verbose_plural;

	}


	/**
	 * Fetch
	 * @param string SQL
	 * @param array Parameters to bind to query
	 * @return array An array of the model type
	 */
	public static function fetch($sql, $params = array()) {

		$query = new \Mysql\Query($sql, $params);
		return \Core\DB::connection()->fetch($query, '\\'.get_called_class());

	}

	/**
	 * Select
	 * @return \Mysql\Select
	 */
	public static function select() {
	
		return \Core\DB::connection()->select(self::table(), '\\'.get_called_class());
		
	}

	/**
	 * ID
	 * @param int ID of row
	 * @return mixed \Model\Base object or null
	 */
	public static function id($id) {
	
		return self::select()->where('id', '=', $id)->single();
		
	}

	/**
	 * Insert
	 * @return \Mysql\Insert
	 */
	public static function insert() {
	
		return \Core\DB::connection()->insert(self::table());
		
	}

	/**
	 * Update
	 * @return \Mysql\Update
	 */
	public static function update() {
	
		return \Core\DB::connection()->update(self::table());
		
	}

	/**
	 * Delete
	 * @return \Mysql\Delete
	 */
	public static function delete() {
	
		return \Core\DB::connection()->delete(self::table());
		
	}
	
	/**
	 * Create Table
	 * @param If true, then create table only if it doesn't exist
	 * @param If true, then the function should return the SQL, and not create the table
	 * @return Result of CREATE TABLE query execution, or SQL
	 */
	public function create_table($if_not_exists = false, $sql = false) {
	
		$t = \Core\DB::connection()
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
	
		return \Core\DB::connection()->drop_table(self::table(), $if_exists);
		
	}

	/**
	 * Get
	 *
	 * Updates the contents of current object, if a matching row is found 
	 * in database. Will use \Model\Base::id() if the ID is set.
	 * @return boolean True on success, false otherwise
	 */
	public function get() {
	
		$result = null;
		$schema = $this->get_schema();
		
		// Use ID if set
		if(isset($this->id)) {

			$result = self::id($this->id);

		// Use other column values otherwise
		} else {
		
			$query = self::select();
			$vars = get_object_vars($this);
			$first_where = true;

			foreach($schema as $name => $column) {
			
				if(isset($vars[$name])) {

					if($first_where) {

						$query->where($name, '=', $vars[$name]);
						$first_where = false;

					} else {

						$query->and_where($name, '=', $vars[$name]);

					}

				}
			
			}

			$result = $query->single();

		}

		if($result !== null) {

			// Update model instance
			$this->id = $result->id;
			foreach($schema as $column) {

				if(isset($result->{$column->column_name()})) {

					$this->{$column->column_name()} = $result->{$column->column_name()};

				}

			}

			return true;

		}

		return false;
	
	}

	/**
	 * Save
	 *
	 * Executes update query when ID is set, inserts new row otherwise
	 * @return mixed ID on insert, result of update execution otherwise
	 */
	public function save() {
	
		$query = (isset($this->id)) ? self::update()->where('id', '=', $this->id)->limit(1) : self::insert();
		$vars = get_object_vars($this);
		$schema = $this->get_schema();
		
		foreach($schema as $name => $column) {
		
			if(isset($vars[$name])) {

				$query->value($name, $vars[$name]);

			}
		
		}
		
		// Execute query
		$res = $query->execute();
		
		// Set ID
		if(!isset($this->id)) {
			
			$this->id = $res;
			
		}
		
		// Finalize
		foreach($schema as $column) {
			
			if(is_callable(array($column, 'finalize'))) {

				$column->finalize($this);

			}
			
		}
		
		return $res;
	
	}

	/**
	 * Erase
	 * @return mixed Result of database query
	 */
	public function erase() {
	
		$query = self::delete()->limit(1);
		$vars = get_object_vars($this);
		$schema = $this->get_schema();
		$first = true;

		if(!empty($this->id)) {

			// Use only ID if it is set
			$query->where('id', '=', $this->id);

		} else {

			// Otherwise, use every set column
			foreach($schema as $name => $column) {
			
				if(isset($vars[$name])) {

					if($first) {

						$query->where($name, '=', $vars[$name]);
						$first = false;

					} else {

						$query->and_where($name, '=', $vars[$name]);

					}

				}
			
			}

		}
		
		// Execute query
		return $query->execute();
	
	}

	/**
	 * To String
	 * @return string ID
	 */
	public function __toString() {

		return $this->id;

	}

}