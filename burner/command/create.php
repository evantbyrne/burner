<?php

namespace Core\Command;

/**
 * Create Command
 * @author Evan Byrne
 */
class Create {
	
	/**
	 * Help
	 */
	public function help() {

		echo "\ncreate <model> [, <model>, ... ]\n\n";
		echo "Description:\n";
		echo "\tGenerates SQL for and creates MySQL tables for given model(s).\n";
		echo "\tWill not drop or update existing tables.\n\n";

	}

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