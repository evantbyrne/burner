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

		echo "\ntest [<path> <namespace>]\n\n";
		echo "Description:\n";
		echo "\tRuns PHPUnit tests for your application.\n";
		echo "\tBy default tests all files located in application/test/.\n\n";

	}

	/**
	 * Run
	 * @param string Path
	 * @param string Namespace
	 */
	public function run($path = null, $namespace = 'App.Test') {
		
		$path = ($path === null) ? APPLICATION . '/test/*.php' : $path;
		$total = 0;
		$fail = 0;

		foreach(glob($path) as $class) {

			$class = explode('/', $class);
			$class_name = to_php_namespace($namespace) . "\\" . substr(end($class), 0, -4);
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