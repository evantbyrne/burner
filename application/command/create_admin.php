<?php

namespace Command;

/**
 * Create Admin Command
 * @author Evan Byrne
 */
class Create_Admin {
	
	/**
	 * Run
	 */
	public function run() {
		
		$user = new \Model\User();
		
		echo 'Email: ';
		ob_flush();
		$user->email = trim(fgets(STDIN));
		
		echo 'Password: ';
		ob_flush();
		$user->password = trim(fgets(STDIN));
		
		if(is_array($user->valid())) {
			
			echo "Error: valid email and password are required\n";
		
		} else {
			
			$user->set_password($user->password);
			$user->type = \Model\User::level('admin');
			$user->save();
			echo "Successfully created admin user\n";
			
		}
		
	}
	
}