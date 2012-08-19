<?php

namespace Core\Command;

/**
 * Setup Command
 * @author Evan Byrne
 */
class Setup {
	
	/**
	 * Run
	 */
	public function run() {
		
		echo "\nCreating model tables\n------------------------\n";
		$create = new Create();
		$create->run('user', 'usersession', 'passwordreset');
		
		echo "\nCreate admin user\n------------------------\n";
		$admin = new Create_Admin();
		$admin->run();
		
		echo "\n";
		
	}
	
}