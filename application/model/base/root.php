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
		
			$res = self::select()->where('id', '=', $id)->limit(1)->execute();
			return (empty($res)) ? false : $res[0];
			
		}
		
		/**
		 * Create Table
		 * @param If true, then the function should return the SQL, and not create the table
		 * @return Result of CREATE TABLE query execution, or SQL
		 */
		public static function create_table($sql = false) {
		
			$t = new \Mysql\Generate\CreateTable(self::table());
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
		 * @return Result of DROP TABLE query execution
		 */
		public static function drop_table() {
		
			$t = new \Mysql\Generate\DropTable(self::table());
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
		 * @return Result of database query
		 */
		public function select() {
		
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
			
			return $query->execute();
			
		}
		
		/**
		 * Delete
		 * @return Result of database query
		 */
		public function delete() {
		
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
			
			return $query->execute();
			
		}
		
		/**
		 * Update
		 * @return Result of database query
		 */
		public function update() {
		
			$query = new \Model\Query\Update(self::table());
			$blocks = static::blocks();
			$query->where('id', '=', $this->id);
			
			foreach($blocks as $block) {
			
				$col = $block->column_name();
				if($col !== 'id' and isset($this->$col)) {
					
					$query->value($col, $this->$col);
					
				
				}
			
			}
			
			return $query->execute();
			
		}
		
		/**
		 * Insert
		 * @return Result of database query
		 */
		public function insert() {
		
			$query = new \Model\Query\Insert(self::table());
			$blocks = static::blocks();
			
			foreach($blocks as $block) {
			
				$col = $block->column_name();
				if(isset($this->$col)) {
				
					$query->value($col, $this->$col);
				
				}
			
			}
			
			return $query->execute();
			
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
		
			return \Dingo\DB::connection()->execute($this->build());
		
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