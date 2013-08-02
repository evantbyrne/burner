<?php

namespace Mysql;

/**
 * Create Table
 */
class CreateTable {

	protected $table;
	protected $additions;
	protected $engine;
	protected $id_not_exists;
	protected $connection;
	
	/**
	 * Construct
	 * @param string Table
	 * @param boolean If true, then add IF NOT EXISTS clause
	 * @param Connection
	 */
	public function __construct($table, $if_not_exists = false, $connection = null) {
	
		$this->table = $table;
		$this->additions = array();
		$this->engine = null;
		$this->if_not_exists = $if_not_exists;
		$this->connection = $connection;
	
	}
	
	/**
	 * @param mixed Table addition
	 * @return $this
	 */
	public function add($addition) {
	
		$this->additions[] = $addition;
		return $this;
	
	}
	
	/**
	 * Engine
	 * @param string MySQL table engine
	 * @return $this
	 */
	public function engine($engine) {
	
		$this->engine = $engine;
		return $this;
	
	}
	
	/**
	 * If Not Exists
	 * 
	 * Adds IF NOT EXISTS clause
	 * @return $this
	 */
	public function if_not_exists() {
		
		$this->if_not_exists = true;
		return $this;
		
	}
	
	/**
	 * Build If Not Exists
	 * @return string IF NOT EXISTS portion of SQL query
	 */
	protected function build_if_not_exists() {
		
		return ($this->if_not_exists) ? ' IF NOT EXISTS' : '';
		
	}
	
	/**
	 * Build
	 * @return Query
	 */
	public function build() {
	
		$sql = array("CREATE TABLE{$this->build_if_not_exists()} `{$this->table}`(");
		$sql_cols = array();
		
		// Additions (Columns, Keys, Indexes)
		foreach($this->additions as $addition) {
		
			$sql_cols[] = $addition->build();
		
		}
		
		$sql[] = implode(",\n", $sql_cols);
		
		// Engine
		$sql[] = ($this->engine === null) ? ')' : ") ENGINE = {$this->engine}";
		
		return new Query(implode("\n", $sql));
	
	}
	
	/**
	 * Execute
	 * @return mixed Result of query execution
	 */
	public function execute() {
		
		return $this->connection->execute($this->build());
	
	}
	
}