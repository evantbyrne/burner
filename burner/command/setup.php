<?php

namespace Core\Command;

/**
 * Setup Command
 * @author Evan Byrne
 */
class Setup {
	
	/**
	 * Help
	 */
	public function help() {

		echo "\nsetup\n\n";
		echo "Description:\n";
		echo "\tGenerates a unique hash secret for active configruation.\n";
		echo "\tThen creates tables for User, UserSession, and PasswordReset models.\n";
		echo "\tFinally prompts you to create an admin user.\n\n";

	}

	/**
	 * Run
	 */
	public function run() {
		
		$gen = new Generate_Hash_Secret();
		$gen->run(\CONFIGURATION);

		echo "\nCreating model tables\n------------------------\n";
		$create = new Create();
		$create->run('user', 'usersession', 'passwordreset');

		echo "\nCreate admin user\n------------------------\n";
		$admin = new Create_Admin();
		$admin->run();
		
		echo "\n";
		
	}
	
}