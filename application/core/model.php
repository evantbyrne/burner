<?php

namespace Model {

	/**
	 * Base Model Class
	 * @author Evan Byrne
	 */
	class Base {
		
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
		 * Select
		 * @return \Model\Query\Select object
		 */
		public static function select() {
		
			return new \Model\Query\Select(self::table(), '\\'.get_called_class());
			
		}
		
		/**
		 * Insert
		 * @return \Model\Query\Insert object
		 */
		public static function insert() {
		
			return new \Model\Query\Insert(self::table());
			
		}
		
		/**
		 * Update
		 * @return \Model\Query\Update object
		 */
		public static function update() {
		
			return new \Model\Query\Update(self::table());
			
		}
		
		/**
		 * Delete
		 * @return \Model\Query\Delete object
		 */
		public static function delete() {
		
			return new \Model\Query\Delete(self::table());
			
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
				$t->add($column);
			
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