<?php

namespace Core\Command;

/**
 * Insert Command
 * @author Evan Byrne
 */
class Insert {
	
	/**
	 * Help
	 */
	public function help() {

		echo "\ninsert <model>\n\n";
		echo "Description:\n";
		echo "\tPrompts user for data to insert into the database.\n";
		echo "\tModel class must include full namespace and be in dotted notation.\n\n";

	}

	/**
	 * Run
	 */
	public function run($model) {
		
		$model_class = to_php_namespace($model);
		$model_instance = new $model_class();
		$vars = array();
		
		foreach($model_instance->get_schema() as $name => $column) {

			$type = $column->get_option('type');
			if($type !== 'HasMany' and $type !== 'ManyToMany') {

				// Prompt
				echo $name;

				if($type === 'BelongsTo') {

					echo ' id';

				}
				
				if($column->get_option('required')) {

					echo '*';
				}

				echo " ($type): ";
				
				// Get input
				ob_flush();
				$vars[$name] = trim(fgets(STDIN));

			}

		}

		$ins = $model_class::from_array($vars);
		$errors = $ins->valid();

		if(is_array($errors)) {

			echo "\nErrors:\n";
			foreach($errors as $name => $msg) {

				echo "$name: $msg\n";

			}

		} else {

			$ins->save();
			echo "\nSaved.\n";

		}

		echo "\n";
		
	}
	
}