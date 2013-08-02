<?php

namespace Mysql;

/**
 * Char Column
 */
class CharColumn extends TableColumn {
	
	/**
	 * @inheritdoc
	 */
	public function build() {
		
		// Max length
		if(!isset($this->options['length'])) {
		
			die("ERROR: No char length given.\n");
		
		}
		
		return "`{$this->name}` CHAR({$this->options['length']}){$this->build_null()}";
	
	}
	
}