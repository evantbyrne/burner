<?php

namespace Mysql;

/**
 * Decimal Column
 */
class DecimalColumn extends TableColumn {
	
	/**
	 * @inheritdoc
	 */
	public function build() {
	
		// Max
		if(!isset($this->options['max'])) {
		
			die("ERROR: No decimal max given.\n");
		
		}
		
		// Digits
		if(!isset($this->options['digits'])) {
		
			die("ERROR: No decimal digits given.\n");
		
		}
		
		// Max range
		if($this->options['max'] > 65 or $this->options['max'] < 1) {
		
			die("ERROR: Bag decimal max range given. Must be between 1 and 65.\n");
		
		}
		
		// Digits range
		if($this->options['digits'] > 30 or $this->options['digits'] < 0) {
		
			die("ERROR: Bag decimal max range given. Must be between 0 and 30.\n");
		
		}
		
		return "`{$this->name}` DECIMAL({$this->options['max']}, {$this->options['digits']}){$this->build_null()}";
	
	}
	
}