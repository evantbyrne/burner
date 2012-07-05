<?php

namespace Model\Base {

	/**
	 * Root Model Class
	 * All models should extend this.
	 * @author Evan Byrne
	 */
	abstract class Root {
		
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
		 * Get
		 * @param ID of model
		 * @return \Model\Base object or false
		 */
		public static function get($id) {
		
			$res = \Dingo\DB::connection()
				->select(self::table(), '\\'.get_called_class())
				->where('id', '=', $id)
				->limit(1)
				->execute();

			return (empty($res)) ? false : $res[0];
			
		}
		
		/**
		 * Create Table
		 * @param If true, then create table only if it doesn't exist
		 * @param If true, then the function should return the SQL, and not create the table
		 * @return Result of CREATE TABLE query execution, or SQL
		 */
		public static function create_table($if_not_exists = false, $sql = false) {
		
			$t = \Dingo\DB::connection()
				->create_table(self::table(), $if_not_exists)
				->engine(static::$engine)
				->add(new \Mysql\IncrementingColumn('id'))
				->add(new \Mysql\PrimaryKey('id'));
			
			// Loop model columns (using late static binding)
			foreach(static::columns() as $column) {
			
				// Loop column columns
				$column = $column->column();
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
		public static function drop_table($if_exists = false) {
		
			return \Dingo\DB::connection()->drop_table(self::table(), $if_exists);
			
		}
		
		/**
		 * Whether methods array has been populated
		 */
		private $_methods_set = false;
		
		/**
		 * Array of methods dynamically set by columns
		 */
		private $_methods = array();
		
		/**
		 * Call
		 * @param Name of method
		 * @param Arguments
		 * @return Mixed
		 */
		public function __call($method, $args) {
			
			if(!$this->_methods_set) {
				
				foreach(static::columns() as $column) {

					$methods = $column->methods();
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
		 * Select
		 * @param Boolean if the query should be executed right away (default true)
		 * @return Result of database query
		 */
		public function select($execute = true) {
		
			$query = \Dingo\DB::connection()->select(self::table(), '\\'.get_called_class());
			$columns = static::columns();
			$first = true;
			
			foreach($columns as $column) {
			
				$col = $column->column_name();
				if(isset($this->$col)) {
				
					if($first) {
					
						$query->where($col, '=', $this->$col);
						$first = false;
					
					} else {
					
						$query->and_where($col, '=', $this->$col);
					
					}
				
				}
			
			}
			
			return ($execute) ? $query->execute() : $query;
			
		}

		/**
		 * Single
		 * @return Single database result, or null
		 */
		public function single() {

			$res = $this->select(false)->limit(1)->execute();
			return (empty($res)) ? null : $res[0];

		}
		
		/**
		 * Delete
		 * @param Boolean if the query should be executed right away (default true)
		 * @return Result of query if execute is true, \Model\Query object otherwise
		 */
		public function delete($execute = true) {
		
			$query = \Dingo\DB::connection()->delete(self::table());
			$columns = static::columns();
			$first = true;
			
			foreach($columns as $column) {
			
				$col = $column->column_name();
				if(isset($this->$col)) {
				
					if($first) {
					
						$query->where($col, '=', $this->$col);
						$first = false;
					
					} else {
					
						$query->and_where($col, '=', $this->$col);
					
					}
				
				}
			
			}
			
			return ($execute) ? $query->execute() : $query;
			
		}
		
		/**
		 * Update
		 * @param Boolean if the query should be executed right away (default true)
		 * @return Result of database query
		 */
		public function update($execute = true) {
		
			$query = \Dingo\DB::connection()->update(self::table());
			$columns = static::columns();
			$query->where('id', '=', $this->id);
			
			foreach($columns as $column) {
			
				$col = $column->column_name();
				if($col !== 'id' and isset($this->$col)) {
					
					$query->value($col, $this->$col);
				
				}
			
			}
			
			return ($execute) ? $query->execute() : $query;
			
		}
		
		/**
		 * Insert
		 * @param Boolean if the query should be executed right away (default true)
		 * @return Inserted row ID
		 */
		public function insert($execute = true) {
		
			$values = array();
			$columns = static::columns();
			
			foreach($columns as $column) {
			
				$col = $column->column_name();
				if(isset($this->$col)) {
				
					$values[$col] = $this->$col;
				
				}
			
			}
			
			return \Dingo\DB::connection()->insert(self::table(), $values);
			
		}
		
		/**
		 * Valid
		 * @return True if valid, an associative array of errors otherwise
		 */
		public function valid() {
		
			$errors = array();
			$vars = get_object_vars($this);
			$columns = static::columns();
			
			foreach($columns as $column) {
			
				$res = $column->valid($vars[$column->column_name()]);
				if($res !== true) {
				
					$errors[$column->column_name()] = $res;
				
				}
			
			}
			
			return (empty($errors)) ? true : $errors;
		
		}
	
	}
	
}