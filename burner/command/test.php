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

		echo "\ntest <class>\n\n";
		echo "Description:\n";
		echo "\tRuns PHPUnit tests for your application.\n\n";

	}

	/**
	 * Run
	 */
	public function run($class) {
		
		$class_name = "\\Test\\$class";
		$klass = new \ReflectionClass($class_name);
		$methods = $klass->getMethods(\ReflectionMethod::IS_PUBLIC);
		$test = new $class_name;
		
		$total = 0;
		$fail = 0;

		foreach($methods as $method) {

			$name = $method->getName();
			if(substr($name, 0, 5) === 'test_') {

				$total++;
				try {
				
					$test->{$name}();

				} catch(\Exception $e) {

					echo "FAIL $class::$name()\n\t" . str_replace("\n", "\n\t", $e->getMessage()) . "\n\n";
					$fail++;

				}

			}

		}

		echo "Tests run: $total, Failures: $fail\n";
		
	}
	
}