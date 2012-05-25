<?php

namespace Command;

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
			echo "\n" . $model_class::create_table(false, true) . ";\n\n";
			
		}
		
	}
	
}