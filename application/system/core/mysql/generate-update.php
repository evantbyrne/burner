<?php

namespace Mysql\Generate;


/* Update */
class Update extends WhereBase {

	protected $values;
	
	/* Construct */
	public function __construct($table) {
	
		parent::__construct($table);
		$this->values = array();
	
	}
	
	/* Add Value */
	public function value($column, $value=null) {
	
		$this->values[$column] = $value;
		return $this;
	
	}
	
	/* Build */
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

}