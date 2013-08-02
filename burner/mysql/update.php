<?php

namespace Mysql;

/**
 * Update
 */
class Update extends WhereBase {

	protected $values;
	
	/**
	 * Construct
	 * @param string Table
	 * @param Connection
	 */
	public function __construct($table, $connection = null) {
	
		parent::__construct($table, $connection);
		$this->values = array();
	
	}
	
	/**
	 * @param string Column to update
	 * @param string Value, which may be NULL
	 * @return $this
	 */
	public function value($column, $value=null) {
	
		$this->values[$column] = $value;
		return $this;
	
	}
	
	/**
	 * Build
	 * @return Query
	 */
	public function build() {
	
		$sql = array("UPDATE `{$this->table}` SET");
		
		// Values
		if(empty($this->values)) {
		
			die("ERROR: No values specified in update query.\n");
		
		}
		
		$vals = array();
		foreach($this->values as $column=>$value) {
		
			if($value === null) {
			
				$vals[] = "{$this->tick_column($column)} = NULL";
			
			} else {
			
				$vals[] = "{$this->tick_column($column)} = ?";
				$this->add_param($value);
				
			}
		
		}
		
		$sql[] = implode(', ', $vals);
		
		// Where
		if(count($this->where) > 0) {
		
			$sql[] = $this->build_where();
		
		}
		
		// Order
		if(count($this->order) > 0) {
		
			$sql[] = $this->build_order();
		
		}
		
		// Limit
		if($this->limit !== null) {
		
			$sql[] = $this->build_limit();
		
		}
		
		return new Query(implode(' ', $sql), $this->params());
	
	}
	
	/**
	 * Execute
	 * @return mixed Result of database query
	 */
	public function execute() {
	
		if(isset($this->connection)) {
		
			return $this->connection->execute($this->build());
		
		}
	
	}

}