<?php

namespace Command;

/**
 * Create Controller Command
 * @author Evan Byrne
 */
class Create_Controller {
	
	/**
	 * Run
	 */
	public function run() {
		
		$controllers = func_get_args();
		foreach($controllers as $con) {
			
			echo "Creating: $con\n";
			$path = APPLICATION.'/controller/'.strtolower($con).'.php';
			
			if(file_exists($path)) {
				
				echo "  ERROR: Controller already exists\n";
				
			} else {
				
				$f = fopen($path, 'w');
				fwrite($f, "<?php\n\nnamespace Controller;\n\nclass $con {\n\n}");
				fclose($f);
				
			}
			
		}
		
	}
	
}