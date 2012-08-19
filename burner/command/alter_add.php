<?php

namespace Core\Command;

/**
 * Alter Add Command
 * @author Evan Byrne
 */
class Alter_Add {
	
	/**
	 * Run
	 * @param string Model
	 * @param string Field
	 */
	public function run($model, $field) {
			
		echo "Altering table to add: $model.$field\n";
		$model_class = "\\Model\\$model";
		$table = $model_class::table();
		
		$instance = new $model_class();
		$column = $instance->get_schema_column($field) or die("Error: Column '$field' not found in model.\n");
		
		\Core\DB::connection()
			->alter_table($table)
			->add($column->column())
			->execute();
		
	}
	
}