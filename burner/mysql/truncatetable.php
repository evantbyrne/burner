<?php

namespace Mysql;

/**
 * Truncate Table
 */
class TruncateTable {
	
	private $table;
	private $connection;
	
	/**
	 * Construct
	 * @param string Table
	 * @param Connection
	 */
	public function __construct($table, $connection = null) {
	
		$this->table = $table;
		$this->connection = $connection;
	
	}
	
	/**
	 * Build
	 * @return Query
	 */
	public function build() {
	
		return new Query("TRUNCATE TABLE `{$this->table}`");
	
	}
	
	/**
	 * Execute
	 * @return mixed Result of query execution
	 */
	public function execute() {
		
		return $this->connection->execute($this->build());
	
	}
	
}