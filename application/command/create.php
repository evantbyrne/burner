<?php

namespace Command;

/**
 * Create Command
 * @author Evan Byrne
 */
class Create {
	
	/**
	 * Run
	 */
	public function run() {
		
		$models = func_get_args();
		foreach($models as $model) {
			
			echo "Creating: $model\n";
			$model_class = "\\Model\\$model";
			$model_class::create_table(true);
			
		}
		
	}
	
}