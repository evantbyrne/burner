<?php

namespace Core\Command;

/**
 * SQL Command
 * @author Evan Byrne
 */
class Sql {
	
	/**
	 * Run
	 */
	public function run() {
		
		$models = func_get_args();
		foreach($models as $model) {
			
			$model_class = "\\Model\\$model";
			$model_instance = new $model_class();
			echo "\n" . $model_instance->create_table(false, true) . ";\n\n";
			
		}
		
	}
	
}