<?php

namespace Page {

	/**
	 * Base Page Class
	 * @author Evan Byrne
	 */
	class Base {
		
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
		 * @param ID of page
		 * @return \Page\Base object or false
		 */
		public static function get($id) {
		
			$res = self::select()->where('id', '=', $id)->limit(1)->execute();
			return (empty($res)) ? false : $res[0];
			
		}
		
		/**
		 * Select
		 * @return \Page\Query\Select object
		 */
		public static function select() {
		
			return new \Page\Query\Select(self::table(), '\\'.get_called_class());
			
		}
		
		/**
		 * Insert
		 * @return \Page\Query\Insert object
		 */
		public static function insert() {
		
			return new \Page\Query\Insert(self::table());
			
		}
		
		/**
		 * Update
		 * @return \Page\Query\Update object
		 */
		public static function update() {
		
			return new \Page\Query\Update(self::table());
			
		}
		
		/**
		 * Delete
		 * @return \Page\Query\Delete object
		 */
		public static function delete() {
		
			return new \Page\Query\Delete(self::table());
			
		}
		
		/**
		 * Create Table
		 * @return Result of CREATE TABLE query execution
		 */
		public static function create_table() {
		
			$t = new \Mysql\Generate\CreateTable(self::table());
			$t->add(new \Mysql\Generate\IncrementingColumn('id'));
			$t->add(new \Mysql\Generate\PrimaryKey('id'));
			
			// Loop page blocks (using late static binding)
			foreach(static::blocks() as $block) {
			
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
		public static function drop_table() {
		
			$t = new \Mysql\Generate\DropTable(self::table());
			return \Dingo\DB::connection()->execute($t->build());
			
		}
	
	}
	
}

namespace Page\Query {

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