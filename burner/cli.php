<?php

namespace Core;

/**
 * CLI Class
 * @author Evan Byrne
 */
class CLI {
	
	/**
	 * Run
	 */
	public static function run() {
		
		global $argv;
		
		if(count($argv) > 1) {
		
			$name = strtolower($argv[1]);
			$command_class = (file_exists(APPLICATION . "/command/$name.php")) ? "\\App\\Command\\$name" : "\\Core\\Command\\$name";
			$command = new $command_class();
			call_user_func_array(array($command, 'run'), array_slice($argv, 2)); 
		
		}
		
	}
	
}