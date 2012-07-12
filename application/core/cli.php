<?php

namespace Core;

/**
 * CLI Class
 */
class CLI {
	
	/**
	 * Run
	 */
	public static function run() {
		
		global $argv;
		
		if(count($argv) > 1) {
		
			$command_class = "\\Command\\{$argv[1]}";
			$command = new $command_class();
			call_user_func_array(array($command, 'run'), array_slice($argv, 2)); 
		
		}
		
	}
	
}