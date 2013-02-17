<?php

namespace Core\Command;

/**
 * Test Command
 * @author Evan Byrne
 */
class Test {
	
	/**
	 * Help
	 */
	public function help() {

		echo "\ntest\n\n";
		echo "Description:\n";
		echo "\tRuns PHPUnit tests for your application.\n\n";

	}

	/**
	 * Run
	 */
	public function run() {
		
		$total = 0;
		$fail = 0;

		foreach(glob(APPLICATION . '/test/*.php') as $class) {

			$class = explode('/', $class);
			$class_name = '\\Test\\' . substr(end($class), 0, -4);
			$klass = new \ReflectionClass($class_name);
			$methods = $klass->getMethods(\ReflectionMethod::IS_PUBLIC);
			$test = new $class_name;

			foreach($methods as $method) {

				$name = $method->getName();
				if(substr($name, 0, 5) === 'test_') {

					$total++;
					try {
					
						$test->{$name}();

					} catch(\Exception $e) {

						echo "FAIL $class_name::$name()\n\t" . str_replace("\n", "\n\t", $e->getMessage()) . "\n\n";
						$fail++;

					}

				}

			}

		}

		echo "Tests run: $total, Failures: $fail\n";
		
	}
	
}