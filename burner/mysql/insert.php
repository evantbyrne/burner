<?php

namespace Mysql;

/**
 * Insert
 */
class Insert extends Base {

	protected $table;
	protected $values;
	
	/**
	 * Construct
	 * @param string Table
	 * @param Connection
	 */
	public function __construct($table, $connection = null) {
	
		parent::__construct($connection);
		$this->table = $table;
		$this->values = array();
	
	}
	
	/**
	 * Value
	 * @param string Column
	 * @param string Value
	 */
	public function value($column, $value) {
	
		$this->values[$column] = $value;
		$this->add_param($value);
		return $this;
	
	}
	
	/**
	 * Build
	 * @return Query
	 */
	public function build() {
	
		$sql = array("INSERT INTO `{$this->table}`");
		
		if(count($this->values) > 0) {
		
			// Columns
			$sql[] = '(`' . implode('`, `', array_keys($this->values)) . '`)';
		
			// Values
			$vals = array();
			for($i = 0; $i < count($this->values); $i++) {
			
				$vals[] = '?';
			
			}
			
			$sql[] = 'VALUES (' . implode(', ', $vals) . ')';
		
		}
		
		return new Query(implode(' ', $sql), $this->params());
	
	}
	
	/**
	 * Execute
	 * @return mixed Result of database query
	 */
	public function execute() {
	
		if(isset($this->connection)) {
		
			$this->connection->execute($this->build());
			return $this->connection->last_insert_id();
		
		}
	
	}

}