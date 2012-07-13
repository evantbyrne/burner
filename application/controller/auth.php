<?php

namespace Controller;

use Library\Input, Library\Cookie;
use Model\User, Model\UserSession, Model\PasswordReset;

/**
 * Auth Controller
 */
class Auth extends Base {
	
	/**
	 * Register
	 */
	public function register() {
		
		if(is_post()) {
		
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
		
				$res = User::select()->where('email', '=', $user->email)->single();
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
				
				User::insert()
					->value('email', $user->email)
					->value('password', $user->password)
					->value('type', $user->type)
					->value('verify_code', $user->verify_code)
					->execute();
		
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
	
	/**
	 * Login
	 */
	public function login() {
		
		if(is_post()) {
			
			$user = new User();
			$user->set_email(Input::post('email'));
			$user->set_password(Input::post('password'));
			
			$errors = $user->valid();
			
			if(!empty($errors)) {
				
				// Bad form input
				$this->data('errors', $errors);
				
			} else {
				
				$user = User::select()
					->where('email', '=', $user->email)
					->and_where('password', '=', $user->password)
					->and_where_null('verify_code')
					->single();
				
				if($user === null) {
					
					// Doesn't exist
					$this->data('errors', array('email' => \Language\Auth::$error_invalid_login));
					
				} else {

					$table = UserSession::table();
					$secret = UserSession::secret();
					$expire = new \DateTime();
					$expire->modify('+30 days');

					\Core\DB::connection()->execute(new \Mysql\Query("INSERT INTO `$table` (`secret`, `id`, `expire`) VALUES (?, ?, FROM_UNIXTIME(?))", array(
						$secret,
						$user->id,
						$expire->format('U'))));

					Cookie::set(array(
						'path'   => '/',
						'name'   => 'auth',
						'value'  => $secret,
						'expire' => '+30 days'
					));

					$this->template('auth/login_success');

				}
				
			}
			
		}
		
	}

}