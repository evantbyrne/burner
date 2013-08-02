<?php

namespace Mysql;

/**
 * Varchar Column
 */
class VarcharColumn extends TableColumn {
	
	/**
	 * @inheritdoc
	 */
	public function build() {
		
		// Max length
		if(!isset($this->options['length'])) {
		
			die("ERROR: No varchar length given.\n");
		
		}
		
		return "`{$this->name}` VARCHAR({$this->options['length']}){$this->build_null()}";
	
	}
	
}