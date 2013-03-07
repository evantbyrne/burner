<?php

namespace Core\Command;

/**
 * SQL Command
 * @author Evan Byrne
 */
class Sql {
	
	/**
	 * Help
	 */
	public function help() {

		echo "\nsql <model> [, <model>, ... ]\n\n";
		echo "Description:\n";
		echo "\tGenerates SQL for a given model(s). Requires database connection.\n\n";

	}

	/**
	 * Run
	 */
	public function run() {
		
		$models = func_get_args();
		foreach($models as $model) {
			
			$model_class = "\\App\\Model\\$model";
			$model_instance = new $model_class();
			echo "\n" . $model_instance->create_table(false, true) . ";\n\n";
			
		}
		
	}
	
}