<?php

namespace Core\Command;

/**
 * Create Model Command
 * @author Evan Byrne
 */
class Create_Model {
	
	/**
	 * Help
	 */
	public function help() {

		echo "\ncreate_model <model> [, <model>, ... ]\n\n";
		echo "Description:\n";
		echo "\tCreates bare-bones model class files.\n";
		echo "\tNote: use the desired model class name(s). ";
		echo "(e.g., 'FooBar' not 'foobar')\n\n";

	}

	/**
	 * Run
	 */
	public function run() {
		
		$models = func_get_args();
		foreach($models as $model) {
			
			echo "Creating: $model\n";
			$path = APPLICATION.'/model/'.strtolower($model).'.php';
			
			if(file_exists($path)) {
				
				echo "  ERROR: Model already exists\n";
				
			} else {
				
				$f = fopen($path, 'w');
				fwrite($f, "<?php\n\nnamespace Model;\n\nclass $model extends \\Core\\Model\\Base {\n\n}");
				fclose($f);
				
			}
			
		}
		
	}
	
}