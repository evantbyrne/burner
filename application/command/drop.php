<?php

namespace Command;

/**
 * Create Command
 * @author Evan Byrne
 */
class Drop {
	
	/**
	 * Run
	 */
	public function run() {
		
		$models = func_get_args();
		foreach($models as $model) {
			
			echo "Dropping: $model\n";
			$model_class = "\\Model\\$model";
			$model_class::drop_table(true);
			
		}
		
	}
	
}