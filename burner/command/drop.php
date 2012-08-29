<?php

namespace Core\Command;

/**
 * Drop Command
 * @author Evan Byrne
 */
class Drop {
	
	/**
	 * Help
	 */
	public function help() {

		echo "\ndrop <model> [, <model>, ... ]\n\n";
		echo "Description:\n";
		echo "\tDrops MySQL tables for given model(s).\n";
		echo "\tWarning: All table data will be lost.\n\n";

	}

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
			
		}
		
	}
	
}