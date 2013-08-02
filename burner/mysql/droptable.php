<?php

namespace Mysql;

/**
 * Drop Table
 */
class DropTable {
	
	private $table;
	private $if_exists;
	private $connection;
	
	/**
	 * Construct
	 * @param string Table
	 * @param boolean If true, then add IF EXISTS clause
	 * @param Connection
	 */
	public function __construct($table, $if_exists = false, $connection = null) {
	
		$this->table = $table;
		$this->if_exists = $if_exists;
		$this->connection = $connection;
	
	}
	
	/**
	 * If Exists
	 *
	 * Adds IF EXISTS clause
	 * @return $this
	 */
	public function if_exists() {
		
		$this->if_exists = true;
		return $this;
		
	}
	
	/**
	 * Build If Exists
	 * @return string IF NOT EXISTS portion of SQL query
	 */
	protected function build_if_exists() {
		
		return ($this->if_exists) ? ' IF EXISTS' : '';
		
	}
	
	/**
	 * Build
	 * @return Query
	 */
	public function build() {
	
		return new Query("DROP TABLE{$this->build_if_exists()} `{$this->table}`");
	
	}
	
	/**
	 * Execute
	 * @return mixed Result of query execution
	 */
	public function execute() {
		
		return $this->connection->execute($this->build());
	
	}
	
}