<?php

namespace Mysql;

/**
 * Fulltext Index
 */
class FulltextIndex extends TableAddition {
	
	/**
	 * @inheritdoc
	 */
	public function build() {
		
		if(empty($this->values)) {
			
			die("ERROR: No columns given for FULLTEXT index.\n");
			
		}
		
		return 'FULLTEXT(`' . implode("`, `", $this->values) . '`)';
		
	}
	
}