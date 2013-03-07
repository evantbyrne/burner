<?php

namespace Core\Command;

/**
 * Import JSON Command
 * @author Evan Byrne
 */
class Import_Json {
	
	/**
	 * Help
	 */
	public function help() {

		echo "\nimport_json <model> <input_file>\n\n";
		echo "Description:\n";
		echo "\tImports JSON file to MySQL table for model.\n\n";

	}

	/**
	 * Run
	 * @param string Model
	 * @param string File
	 */
	public function run($model, $filename) {
			
		echo "Importing contents of '$filename' to '$model' table...\n";
		
		// Get data
		$data = file_get_contents($filename);
		$json = json_decode($data, true);

		// Insert data into table
		$model_class = "\\App\\Model\\$model";
		$table = $model_class::table();
		$n = 0;

		foreach($json as $row) {

			$n++;
			$insert = $model_class::insert();
			foreach($row as $column => $value) {

				$insert->value($column, $value);

			}

			$insert->execute();

		}

		echo "$n rows inserted.\n\n";
		
	}
	
}