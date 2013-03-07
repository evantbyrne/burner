<?php

namespace Core\Command;

/**
 * Create Controller Command
 * @author Evan Byrne
 */
class Create_Controller {

	/**
	 * Help
	 */
	public function help() {

		echo "\ncreate_controller <controller> [, <controller>, ... ]\n\n";
		echo "Description:\n";
		echo "\tCreates bare-bones controller class files.\n";
		echo "\tNote: use the desired controller class name(s). ";
		echo "(e.g., 'FooBar' not 'foobar')\n\n";

	}
	
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
				fwrite($f, "<?php\n\nnamespace App\\Controller;\n\nclass $con extends \Core\Controller\Base {\n\n}");
				fclose($f);
				
			}
			
		}
		
	}
	
}