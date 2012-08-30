<?php

namespace Core\Command;

/**
 * Clean User Sessions Command
 * @author Evan Byrne
 */
class Clean_User_Sessions {
	
	/**
	 * Help
	 */
	public function help() {

		echo "\nclean_user_sessions\n\n";
		echo "Description:\n";
		echo "\tDeletes expired user sessions.\n\n";

	}

	/**
	 * Run
	 */
	public function run() {
		
		echo "Removing expired sessions...\n";
		\Model\UserSession::clean();
		
	}
	
}