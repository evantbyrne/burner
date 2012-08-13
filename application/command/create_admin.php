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
		
		echo 'Email: ';
		ob_flush();
		$email = trim(fgets(STDIN));
		
		echo 'Password: ';
		ob_flush();
		$password = trim(fgets(STDIN));
		
		$user = \Model\User::from_array(array(
			'email'    => $email,
			'password' => $password,
			'type'     => \Model\User::level('admin')
		));
		
		if(is_array($user->valid())) {
			
			echo "Error: valid email and password are required\n";
		
		} else {
			
			$user->save();
			echo "Successfully created admin user\n";
			
		}
		
	}
	
}