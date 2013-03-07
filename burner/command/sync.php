<?php

namespace Core\Command;

/**
 * Sync Command
 * @author Evan Byrne
 */
class Sync {
	
	/**
	 * Help
	 */
	public function help() {

		echo "\nsync <model> [, <model>, ... ]\n\n";
		echo "Description:\n";
		echo "\tDrops, and then recreates MySQL tables for given model(s).\n";
		echo "\tWarning: All table data will be lost.\n\n";

	}

	/**
	 * Run
	 */
	public function run() {
		
		$models = func_get_args();
		foreach($models as $model) {
			
			echo "Dropping: $model\n";
			$model_class = "\\App\\Model\\$model";
			$model_instance = new $model_class();
			$model_instance->drop_table(true);
			
			echo "Creating: $model\n";
			$model_instance->create_table(true);
			
		}
		
	}
	
}