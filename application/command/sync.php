<?php

namespace Command;

/**
 * Sync Command
 * @author Evan Byrne
 */
class Sync {
	
	/**
	 * Run
	 */
	public function run() {
		
		$models = func_get_args();
		foreach($models as $model) {
			
			echo "Dropping: $model\n";
			$model_class = "\\Model\\$model";
			$model_instance = new $model_class();
			$model_instance->drop_table(true);
			
			echo "Creating: $model\n";
			$model_instance->create_table(true);
			
		}
		
	}
	
}