<?php

namespace Mysql;

/**
 * Enum Column
 */
class EnumColumn extends TableColumn {
	
	/**
	 * @inheritdoc
	 */
	public function build() {
		
		// Values
		if(empty($this->options)) {
		
			die("ERROR: No ENUM values given.\n");
		
		}
		
		return "`{$this->name}` ENUM('" . implode("', '", $this->options) . "'){$this->build_null()}";
	
	}
	
}