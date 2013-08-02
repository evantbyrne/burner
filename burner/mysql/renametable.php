<?php

namespace Mysql;

/**
 * Rename Table
 */
class RenameTable {
	
	private $table;
	private $new_name;
	private $connection;
	
	/**
	 * Construct
	 * @param string Table
	 * @param string New name for table
	 * @param Connection
	 */
	public function __construct($table, $new_name, $connection = null) {
	
		$this->table = $table;
		$this->new_name = $new_name;
		$this->connection = $connection;
	
	}
	
	/**
	 * Build
	 * @return Query
	 */
	public function build() {
	
		return new Query("ALTER TABLE `{$this->table}` RENAME `{$this->new_name}`");
	
	}
	
	/**
	 * Execute
	 * @return mixed Result of query execution
	 */
	public function execute() {
		
		return $this->connection->execute($this->build());
	
	}
	
}