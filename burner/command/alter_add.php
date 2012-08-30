<?php

namespace Core\Command;

/**
 * Alter Add Command
 * @author Evan Byrne
 */
class Alter_Add {
	
	/**
	 * Help
	 */
	public function help() {

		echo "\nalter_add <model> <column>\n\n";
		echo "Description:\n";
		echo "\tAdds a column to the existing MySQL table for a model.\n\n";

	}

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