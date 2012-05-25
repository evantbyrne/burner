<?php

namespace Command;

/**
 * Create Model Command
 * @author Evan Byrne
 */
class Create_Model {
	
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
				fwrite($f, "<?php\n\nnamespace Model;\n\nclass $model extends \Model\Base\Root {\n\n}");
				fclose($f);
				
			}
			
		}
		
	}
	
}