<?php

namespace Core\Command;

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
			$model_instance = new $model_class();
			$model_instance->create_table(true);
			
		}
		
	}
	
}