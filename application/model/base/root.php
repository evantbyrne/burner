<?php

namespace Model\Base {

	/**
	 * Root Model Class
	 * All models should extend this.
	 * @author Evan Byrne
	 */
	abstract class Root {
		
		/**
		 * SySQL storage engine to use
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
		
			$select = new \Model\Query\Select(self::table(), '\\'.get_called_class());
			$res = $select->where('id', '=', $id)->limit(1)->execute();
			return (empty($res)) ? false : $res[0];
			
		}
		
		/**
		 * Create Table
		 * @param If true, then create table only if it doesn't exist
		 * @param If true, then the function should return the SQL, and not create the table
		 * @return Result of CREATE TABLE query execution, or SQL
		 */
		public static function create_table($if_not_exists = false, $sql = false) {
		
			$t = new \Mysql\Generate\CreateTable(self::table(), $if_not_exists);
			$t->engine(static::$engine);
			$t->add(new \Mysql\Generate\IncrementingColumn('id'));
			$t->add(new \Mysql\Generate\PrimaryKey('id'));
			
			// Loop model blocks (using late static binding)
			foreach(static::blocks() as $block) {
			
				// Loop block columns
				$column = $block->column();
				if($column !== null) {
				
					$t->add($column);
				
				}
			
			}
			
			return ($sql) ? $t->build()->sql() : \Dingo\DB::connection()->execute($t->build());
		
		}
		
		/**
		 * Drop Table
		 * @param If true, then drop table only if it exists
		 * @return Result of DROP TABLE query execution
		 */
		public static function drop_table($if_exists = false) {
		
			$t = new \Mysql\Generate\DropTable(self::table(), $if_exists);
			return \Dingo\DB::connection()->execute($t->build());
			
		}
		
		/**
		 * Whether methods array has been populated
		 */
		private $_methods_set = false;
		
		/**
		 * Array of methods dynamically set by blocks
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
				
				foreach(static::blocks() as $block) {

					$methods = $block->methods();
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
		
			$query = new \Model\Query\Select(self::table(), '\\'.get_called_class());
			$blocks = static::blocks();
			$first = true;
			
			foreach($blocks as $block) {
			
				$col = $block->column_name();
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
		 * Delete
		 * @param Boolean if the query should be executed right away (default true)
		 * @return Result of query if execute is true, \Model\Query object otherwise
		 */
		public function delete($execute = true) {
		
			$query = new \Model\Query\Delete(self::table());
			$blocks = static::blocks();
			$first = true;
			
			foreach($blocks as $block) {
			
				$col = $block->column_name();
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
		
			$query = new \Model\Query\Update(self::table());
			$blocks = static::blocks();
			$query->where('id', '=', $this->id);
			
			foreach($blocks as $block) {
			
				$col = $block->column_name();
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
		
			$query = new \Model\Query\Insert(self::table());
			$blocks = static::blocks();
			
			foreach($blocks as $block) {
			
				$col = $block->column_name();
				if(isset($this->$col)) {
				
					$query->value($col, $this->$col);
				
				}
			
			}
			
			return ($execute) ? $query->execute() : $query;
			
		}
		
		/**
		 * Valid
		 * @return True if valid, an associative array of errors otherwise
		 */
		public function valid() {
		
			$errors = array();
			$vars = get_object_vars($this);
			$blocks = static::blocks();
			
			foreach($blocks as $block) {
			
				$res = $block->valid($vars[$block->column_name()]);
				if($res !== true) {
				
					$errors[$block->column_name()] = $res;
				
				}
			
			}
			
			return (empty($errors)) ? true : $errors;
		
		}
	
	}
	
}

namespace Model\Query {

	/**
	 * Select Class
	 * @author Evan Byrne
	 */
	class Select extends \Mysql\Generate\Select {
	
		private $result_class;
		
		/**
		 * Construct
		 * @param Table name
		 * @param Class to use for result set
		 */
		public function __construct($table, $result_class) {
		
			parent::__construct($table);
			$this->result_class = $result_class;
		
		}
		
		/**
		 * Execute
		 * @return Result of select
		 */
		public function execute() {
		
			return \Dingo\DB::connection()->fetch($this->build(), $this->result_class);
		
		}
	
	}
	
	/**
	 * Insert Class
	 * @author Evan Byrne
	 */
	class Insert extends \Mysql\Generate\Insert {
	
		/**
		 * Execute
		 * @return Result of insertion
		 */
		public function execute() {
		
			$con = \Dingo\DB::connection();
			$con->execute($this->build());
			return $con->last_insert_id();
		
		}
	
	}
	
	/**
	 * Update Class
	 * @author Evan Byrne
	 */
	class Update extends \Mysql\Generate\Update {
	
		/**
		 * Execute
		 * @return Result of update
		 */
		public function execute() {
		
			return \Dingo\DB::connection()->execute($this->build());
		
		}
	
	}
	
	/**
	 * Delete Class
	 * @author Evan Byrne
	 */
	class Delete extends \Mysql\Generate\Delete {
	
		/**
		 * Execute
		 * @return Result of delete
		 */
		public function execute() {
		
			return \Dingo\DB::connection()->execute($this->build());
		
		}
	
	}

}