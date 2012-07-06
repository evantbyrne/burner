<?php

namespace Controller;

use Library\Input, Library\Url, Library\Email, Dingo\Shortcut as S;
use Model\User, Model\PasswordReset, Model\Country;

/**
 * Auth Controller
 */
class Auth {

	/**
	 * Register
	 */
	public function register() {
		
		return S::render_response('auth/register');
	
	}
	
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
		
		// Validate
		$valid = $user->valid();
		if(is_array($valid)) {
		
			$errors = array_merge($errors, $valid);
		
		}
		
		if($password !== null and $password !== $password_confirm) {
		
			$errors[] = 'Confirmation password did not match.';
		
		}
		
		if($user->email !== null) {
		
			$s = new User();
			$s->email = $user->email;
			$res = $s->select(false)->limit(1)->execute();
			
			if(!empty($res)) {
			
				$errors[] = 'Given email already belongs to registered user. ' .
					"Are you sure you don't already have an account?";
			
			}
		
		}
		
		if(!empty($errors)) {
		
			// Show form if errors exist
			return S::render_response('auth/register', array(
			
				'errors' => $errors,
				'email'  => $user->email
			
			));
		
		}
		
		$user->verify_code = \Model\UserSession::secret();
		$user->set_password($password);
		$user->insert();
		
		$v_url = Url::page("verify/{$user->verify_code}");
		mail($user->email, 'Verify Your Registration', "We would like to " .
			"welcome you to our site! However, before you can log in, you will have to visit the following link " .
			"to verify your email address is correct: $v_url", 'From: noreply@example.me');
		
		return S::render_response('auth/register_success');
	
	}
	
	/**
	 * Login
	 */
	public function login() {
		
		return S::render_response('auth/login');
	
	}
	
	/**
	 * Login Action
	 */
	public function login_action() {
		
		$email = Input::post('email');
		$password = Input::post('password');
		
		if(\Library\Auth::login($email, $password)) {
			
			Url::redirect('login');
		
		}
		
		return S::render_response('auth/login', array('error' => true));
	
	}
	
	/**
	 * Logout Action
	 */
	public function logout_action() {
	
		\Library\Auth::logout();
		Url::redirect('login');
	
	}
	
	/**
	 * Verify Action
	 */
	public function verify_action($code) {
	
		$user = new User();
		$user->verify_code = $code;
		$res = $user->select(false)->limit(1)->execute();
		
		if(!empty($res)) {
		
			$update = new \Model\Query\Update(User::table());
			$update->where('id', '=', $res[0]->id)->value('verify_code', null)->limit(1)->execute();
		
		}
		
		Url::redirect('login');
	
	}
	
	/**
	 * Reset
	 */
	public function reset_request() {
		
		return S::render_response('auth/reset_request');
	
	}
	
	/**
	 * Reset Request Action
	 */
	public function reset_request_action() {
		
		$user = new User();
		$user->email = Input::post('email');
		$res = $user->select(false)->limit(1)->execute();
		
		if(empty($res)) {
			
			return S::render_response('auth/reset_request', array('error' => true));
			
		}
		
		// Delete existing password reset
		$old = new \Model\Query\Delete(PasswordReset::table());
		$old->where('id', '=', $res[0]->id)->limit(1)->execute();
		
		// Create password reset
		$reset = new PasswordReset();
		$reset->user = $res[0]->id;
		$reset->secret = \Model\UserSession::secret();
		$reset->insert();
		
		$r_url = Url::page("reset/{$reset->secret}");
		mail($user->email, 'Password Reset', "{$res[0]->first_name},\n\nYou have received this " .
			"email because you requested a password reset. To reset your password, visit the following link: $r_url",
			'From: noreply@bekr.me');
		
		return S::render_response('auth/reset_request_success');
		
	}
	
	/**
	 * Reset
	 */
	public function reset($secret) {
		
		return S::render_response('auth/reset', array('secret' => $secret));
	
	}
	
	/**
	 * Reset Action
	 */
	public function reset_action($secret) {
		
		$password = Input::post('password');
		
		$reset = new PasswordReset();
		$reset->secret = $secret;
		$res = $reset->select(false)->limit(1)->execute();
		
		if(!empty($res) and !empty($password)) {
			
			// Update password
			$user = User::get($res[0]->user) or die('Error: User not found');
			$user->set_password($password);
			$user->update();
			
			// Delete password reset
			$res[0]->delete(false)->limit(1)->execute();
			
			return S::render_response('auth/reset_success');
			
		}
		
		return S::render_response('auth/reset', array('secret' => $secret, 'error' => true));
	
	}

}