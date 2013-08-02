<?php

namespace Mysql;

/**
 * Unique Key
 */
class UniqueKey extends TableAddition {
	
	/**
	 * @inheritdoc
	 */
	public function build() {
		
		if(empty($this->values)) {
			
			die("ERROR: No columns given for unique key.\n");
			
		}
		
		return 'UNIQUE KEY(`' . implode("`, `", $this->values) . '`)';
		
	}
	
}