<?php

namespace Mysql\Generate;


/* Insert */
class Insert extends Base {

	protected $table;
	protected $values;
	
	/* Construct */
	public function __construct($table) {
	
		parent::__construct();
		$this->table = $table;
		$this->values = array();
	
	}
	
	/* Add Value */
	public function value($column, $value) {
	
		$this->values[$column] = $value;
		$this->add_param($value);
		return $this;
	
	}
	
	/* Build */
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

}