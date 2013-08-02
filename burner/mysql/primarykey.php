<?php

namespace Mysql;

/**
 * Primary Key
 */
class PrimaryKey extends TableAddition {
	
	/**
	 * @inheritdoc
	 */
	public function build() {
		
		if(empty($this->values)) {
			
			die("ERROR: No columns given for primary key.\n");
			
		}
		
		return 'PRIMARY KEY(`' . implode("`, `", $this->values) . '`)';
		
	}
	
}