<?php

namespace Core\Command;

/**
 * Export JSON Command
 * @author Evan Byrne
 */
class Export_Json {
	
	/**
	 * Help
	 */
	public function help() {

		echo "\nexport_json <model> <output_file>\n\n";
		echo "Description:\n";
		echo "\tExports contents of MySQL table to a file.\n\n";

	}

	/**
	 * Run
	 * @param string Model
	 * @param string File
	 */
	public function run($model, $filename) {
			
		echo "Exporting contents of '$model' to $filename...\n\n";
		$model_class = "\\Model\\$model";
		$table = $model_class::table();
		
		$res = \Core\DB::connection()->select($table)->order_asc('id')->fetch();
		
		$fh = fopen($filename, 'w');
		fwrite($fh, json_encode($res));
		fclose($fh);
		
	}
	
}