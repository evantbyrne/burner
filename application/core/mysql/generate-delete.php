<?php

namespace Mysql\Generate;


/* Delete */
class Delete extends WhereBase {
	
	/* Build */
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

}