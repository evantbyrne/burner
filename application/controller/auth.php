<?php

namespace Controller;

use Library\Input, Library\Email;
use Model\User, Model\PasswordReset, Model\Country;

/**
 * Auth Controller
 */
class Auth extends Base {

	/**
	 * Register
	 */
	public function register() { }
	
	/**
	 * Register Action
	 */
	public function register_action() {
		
		$errors = array();
		
		$user = new User();
		$user->email = Input::post('email');
		
		$password = Input::post('password');
		$password_confirm = Input::post('password_confirm');
		$user->password = $password;
		$user->type = User::level('user');
		
		// Validate model fields
		$valid = $user->valid();
		if(is_array($valid)) {
		
			$errors = array_merge($errors, $valid);
		
		}
		
		// Check confirmation password
		if($password !== null and $password !== $password_confirm) {
		
			$errors['password'] = \Language\Auth::$error_confirmation_password;
		
		}
		
		// Check if email already taken
		if($user->email !== null) {
		
			$s = new User();
			$s->email = $user->email;
			$res = $s->single();
			
			if($res !== null) {
			
				$errors['email'] = \Language\Auth::$error_taken_email;
			
			}
		
		}
		
		// Show form if errors exist
		if(!empty($errors)) {
		
			$this->template('auth/register');
			$this->data(array(
			
				'errors' => $errors,
				'email'  => $user->email
			
			));
		
		} else {
		
			// Create user
			$user->verify_code = \Model\UserSession::secret();
			$user->set_password($password);
			$user->insert();
		
			// Send verification email
			$v_url = url("verify/{$user->verify_code}");
			mail($user->email,
				\Language\Auth::$email_success_title,
				\Language\Auth::email_success_message($v_url),
				'From: ' + \Language\Auth::$email_success_from);
		
			$this->template('auth/register_success');
		
		}
	
	}

}