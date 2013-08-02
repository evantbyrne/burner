<?php

namespace Mysql;

/**
 * Alter Table
 */
class AlterTable {
	
	private $table;
	private $operations;
	private $connection;
	
	/**
	 * Construct
	 * @param string Table
	 * @param Connection
	 */
	public function __construct($table, $connection = null) {
	
		$this->table = $table;
		$this->operations = array();
		$this->connection = $connection;
	
	}
	
	/**
	 * Add
	 * @param mixed TableColumn object
	 * @return $this
	 */
	public function add($column) {
	
		$this->operations[] = array('add', $column);
		return $this;
	
	}
	
	/**
	 * Drop
	 * @param string Column name
	 * @return $this
	 */
	public function drop($column_name) {
	
		$this->operations[] = array('drop', $column_name);
		return $this;
	
	}
	
	/**
	 * Modify
	 * @param mixed TableColumn object
	 * @return $this
	 */
	public function modify($column) {
	
		$this->operations[] = array('modify', $column);
		return $this;
	
	}
	
	/**
	 * Build
	 * @return Query
	 */
	public function build() {
	
		$sql = array();
		
		// Operations
		foreach($this->operations as $o) {
		
			// Add
			if($o[0] === 'add') {
			
				$sql[] = "ADD {$o[1]->build()}";
			
			// Drop
			} elseif($o[0] === 'drop') {
			
				$sql[] = "DROP COLUMN `{$o[1]}`";
			
			// Modify
			} elseif($o[0] === 'modify') {
			
				$sql[] = "MODIFY {$o[1]->build()}";
			
			}
		
		}
		
		return new Query("ALTER TABLE `{$this->table}` " . implode(', ', $sql));
	
	}
	
	/**
	 * Execute
	 * @return mixed Result of query execution
	 */
	public function execute() {
		
		return $this->connection->execute($this->build());
	
	}
	
}