<?php

namespace Mysql;

/**
 * Delete
 */
class Delete extends WhereBase {
	
	/**
	 * Build
	 * @return Query
	 */
	public function build() {
	
		$sql = array("DELETE FROM `{$this->table}`");
		
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
	 * @return mixed Result of query execution
	 */
	public function execute() {
	
		if(isset($this->connection)) {
		
			return $this->connection->execute($this->build());
		
		}
	
	}

}