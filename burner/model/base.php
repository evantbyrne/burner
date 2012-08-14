<?php

namespace Core\Model;

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
	 * Verbose name
	 */
	public static $verbose = null;

	/**
	 * Verbose plural name
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
	 * From Array
	 * @param array Associated array of data
	 * @param mixed Whitelist or null
	 * @return \Model\Base Populated model object
	 */
	public static function from_array($data, $whitelist = null) {
	
		$instance = new static();
		$schema = $instance->get_schema();
		
		foreach($schema as $column) {
		
			$name = $column->column_name();
			if(($whitelist === null or in_array($name, $whitelist)) and isset($data[$name])) {

				//$instance->{$name} = $data[$name];
				$instance->{$name} = (is_callable(array($column, 'set'))) ? $column->set($data[$name]) : $data[$name];

			}
		
		}
		
		return $instance;
	
	}
	
	/**
	 * From Post
	 * @param mixed Whitelist or null
	 * @return \Model\Base Model object populated from $_POST
	 */
	public static function from_post($whitelist = null, $include_files = false) {
		
		return self::from_array(($include_files) ? array_merge($_POST, $_FILES) : $_POST, $whitelist);
		
	}
	
	/**
	 * MySQL schema
	 */
	private $_schema = array();

	/**
	 * Admin column settings
	 */
	private $_admin = array();

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
	 * Get Schema Column
	 * @param string Column name
	 * @return mixed \Column\Base, or null
	 */
	public function get_schema_column($name) {
		
		foreach($this->_schema as $column) {
			
			if($column->column_name() == $name) {
				
				return $column;
				
			}
			
		}
		
		return null;
		
	}

	/**
	 * Admin
	 * @param string Column
	 * @param array Options
	 */
	public function admin($column, $options = array()) {

		$this->_admin[$column] = array_merge(array('list' => true), $this->get_schema_column($column)->options(), $options);

	}

	/**
	 * Get Admin
	 * @return array
	 */
	public function get_admin() {

		return $this->_admin;

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
	 * Valid
	 * @return True if valid, an associative array of errors otherwise
	 */
	public function valid() {
	
		$errors = array();
		$vars = get_object_vars($this);
		$schema = $this->get_schema();
		
		foreach($schema as $column) {
		
			$res = $column->valid((isset($vars[$column->column_name()])) ? $vars[$column->column_name()] : null);
			if($res !== true) {
			
				$errors[$column->column_name()] = $res;
			
			}
		
		}
		
		return (empty($errors)) ? true : $errors;
	
	}

	/**
	 * Sync
	 *
	 * Updates the contents of current object, if a matching row is found 
	 * in database. Will use \Model\Base::id() if the ID is set.
	 *
	 * @return boolean True on success, false otherwise
	 */
	public function sync() {
	
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

			foreach($schema as $column) {
			
				if(isset($vars[$column->column_name()])) {

					if($first_where) {

						$query->where($column->column_name(), '=', $vars[$column->column_name()]);

					} else {

						$query->and_where($column->column_name(), '=', $vars[$column->column_name()]);

					}

				}
			
			}

			$result = $query->single();

		}

		if($result !== null) {

			// Update model instance
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
	 *
	 * @return mixed ID on insert, result of update execution otherwise
	 */
	public function save() {
	
		$query = (isset($this->id)) ? self::update()->where('id', '=', $this->id)->limit(1) : self::insert();
		$vars = get_object_vars($this);
		$schema = $this->get_schema();
		
		foreach($schema as $column) {
		
			$name = $column->column_name();
			if(isset($vars[$name])) {

				if(is_callable(array($column, 'finalize'))) {

					$vars[$name] = $column->finalize($vars[$name]);

				}

				$query->value($name, $vars[$name]);

			}
		
		}
		
		return $query->execute();
	
	}
	
	/**
	 * Merge Array
	 * @param array Associated array of data
	 * @param mixed Whitelist array or null
	 * @return $this
	 */
	public function merge_array($data, $whitelist = null) {
	
		$schema = $this->get_schema();
		
		foreach($schema as $column) {
		
			$name = $column->column_name();
			if(($whitelist === null or in_array($name, $whitelist)) and isset($data[$name])) {

				if(!empty($data[$name]) or !$column->get_option('blank')) {

					if(!empty($data[$name]['tmp_name']) or !is_a($column, '\\Column\\File')) {

						$this->{$name} = (is_callable(array($column, 'set'))) ? $column->set($data[$name]) : $data[$name];

					}

				}

			}
		
		}
		
		return $this;
	
	}
	
	/**
	 * Merge Post
	 * @param mixed Whitelist array or null
	 * @return $this
	 */
	public function merge_post($whitelist = null) {
	
		return $this->merge_array($_POST, $whitelist);
	
	}
	
	/**
	 * To Array
	 * @param mixed Whitelist array or null
	 * @return array Associated array of data from model instance
	 */
	public function to_array($whitelist = null) {
	
		$data = array();
		$schema = $this->get_schema();
		$schema['id'] = new \Column\Int('id');
		
		foreach($schema as $column) {
		
			$name = $column->column_name();
			if(($whitelist === null or in_array($name, $whitelist))) {

				$data[$name] = (isset($this->$name)) ? $this->$name : null;

			}
		
		}
		
		return $data;
	
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

	/**
	 * To String
	 * @return string ID
	 */
	public function __toString() {

		return $this->id;

	}

}