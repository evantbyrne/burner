<?php

namespace Core\Command;

/**
 * Clean User Sessions Command
 * @author Evan Byrne
 */
class Clean_User_Sessions {
	
	/**
	 * Run
	 */
	public function run() {
		
		echo "Removing expired sessions...\n";
		\Model\UserSession::clean();
		
	}
	
}