<?php

namespace Core\Command;

/**
 * Help Command
 * @author Evan Byrne
 */
class Help {
	
	/**
	 * Run
	 */
	public function run($command = null) {
		
		if($command === null) {

			echo "\nhelp <command>\n\n";
			echo "Description:\n";
			echo "\tDisplays help for given command.\n\n";

		} else {
		
			$command_class = (file_exists(APPLICATION . "/command/$command.php")) ? "\\App\\Command\\$command" : "\\Core\\Command\\$command";
			
			try {

				$command_instance = new $command_class();

			} catch(\Exception $e) {

				die("Error: Command '$command' not found.\n\n");

			}
			
			if(!is_callable(array($command_instance, 'help'))) {

				die("Error: No help found for '$command' command.\n\n");

			}

			$command_instance->help();

		}
		
	}
	
}