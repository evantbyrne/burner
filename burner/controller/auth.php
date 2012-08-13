<?php

namespace Core\Controller;

use Library\Input, Library\Cookie;

/**
 * Auth Controller
 * @author Evan Byrne
 */
class Auth extends Base {
	
	/**
	 * Cached logged in result
	 */
	private static $logged_in = null;
	
	/**
	 * Cached current user
	 */
	private static $user = null;
	
	/**
	 * Logged In
	 * @param boolean Don't cache result
	 * @return boolean
	 */
	public static function logged_in($no_cache = false) {
		
		// Check for cached result
		if(!$no_cache and self::$logged_in !== null) {
			
			return self::$logged_in;
			
		}
		
		self::$logged_in = false;
		
		$secret = Input::cookie('auth');
		if($secret !== null) {
			
			$session = \Model\UserSession::select()->where('secret', '=', $secret)->single();
			if($session !== null) {
				
				$user = \Model\User::select()->where('id', '=', $session->user)->single();
				if($user !== null) {
				
					self::$user = $user;
					self::$logged_in = true;
				
				}
				
			}
			
		}
		
		return self::$logged_in;
		
	}
	
	/**
	 * User
	 * @param boolean Don't cache
	 * @return mixed Current user, or null
	 */
	public static function user($no_cache = false) {
		
		return (self::logged_in($no_cache)) ? self::$user : null;
		
	}
	
	/**
	 * Enforce
	 */
	public static function enforce($level = false) {
		
		if(!self::logged_in()) {
			
			login_redirect(CURRENT_PAGE);
			
		}

		if($level !== false) {

			$user = self::user();
			if($user->type < \Model\User::level($level)) {

				\Core\Bootstrap::controller('error', '_403');
				exit;

			}

		}
		
	}
	
	/**
	 * Register
	 */
	public function register() {
		
		if(is_post()) {
		
			$errors = array();
			
			$user = \Model\User::from_post(array('email', 'password'));

			$user->type = \Model\User::level('user');
			$password_confirm = Input::post('password_confirm');
			$password_confirm = empty($password_confirm) ? null : \Model\User::hash($password_confirm);
			
			// Validate model fields
			$valid = $user->valid();
			if(is_array($valid)) {
		
				$errors = array_merge($errors, $valid);
		
			}
		
			// Check confirmation password
			if($user->password !== null and $user->password !== $password_confirm) {
		
				$errors['password'] = \Language\Auth::$error_confirmation_password;
		
			}
		
			// Check if email already taken
			if($user->email !== null) {
		
				$res = \Model\User::select()->where('email', '=', $user->email)->single();
				if($res !== null) {
			
					$errors['email'] = \Language\Auth::$error_taken_email;
			
				}
		
			}
		
			// Show form if errors exist
			if(!empty($errors)) {
		
				$this->template('auth/register');
				$this->data('errors', $errors);
				$this->data($user->to_array());
				$this->data('password', null);
		
			} else {
		
				// Create user
				$user->verify_code = \Model\UserSession::secret();
				$user->save();
		
				// Send verification email
				$v_url = url("auth/verify/{$user->verify_code}");
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
	public function login($redirect = false) {
		
		if(is_post()) {
			
			$in = \Model\User::from_post(array('email', 'password'));
		
			
			$user = \Model\User::select()
				->where('email', '=', $in->email)
				->and_where('password', '=', $in->password)
				->and_where_null('verify_code')
				->single();
			
			if($user === null) {
				
				// Doesn't exist
				$this->data('errors', array('email' => \Language\Auth::$error_invalid_login));
				$this->data('email', $in->email);
				
			} else {

				// Create Session
				$table = \Model\UserSession::table();
				$secret = \Model\UserSession::secret();
				$expire = new \DateTime();
				$expire->modify('+30 days');

				\Core\DB::connection()->execute(new \Mysql\Query("INSERT INTO `$table` (`secret`, `user`, `expire`) VALUES (?, ?, FROM_UNIXTIME(?))", array(
					$secret,
					$user->id,
					$expire->format('U'))));

				Cookie::set(array(
					'path'   => '/',
					'name'   => 'auth',
					'value'  => $secret,
					'expire' => '+30 days'
				));

				if($redirect) {
				
					// Redirect
					redirect(base64_decode($redirect));
				
				}
				
				redirect();

			}
		
		}
		
	}

	/**
	 * Logout
	 */
	public function logout() {
	
		$secret = Input::cookie('auth');
		
		if($secret !== null) {
		
			\Model\UserSession::delete()->where('secret', '=', $secret)->limit(1)->execute();
			Cookie::delete(array(
				'path' => '/',
				'name' => 'auth'
			));
		
		}

		redirect('auth/login');
	
	}

	/**
	 * Verify
	 */
	public function verify($code) {
	
		$user = \Model\User::select()->where('verify_code', '=', $code)->single();
		
		if($user !== null) {
		
			\Model\User::update()
				->where('id', '=', $user->id)
				->value('verify_code', null)
				->limit(1)
				->execute();
		
		}
		
		redirect('auth/login');
	
	}

	/**
	 * Reset Request
	 */
	public function reset_request() {
		
		if(is_post()) {
			
			$user = \Model\User::select()->where('email', '=', Input::post('email'))->single();
			if($user === null) {
				
				// User doesn't exist
				$this->data('error', true);
				
			} else {
			
				// Delete existing password reset
				\Model\PasswordReset::delete()
					->where('user', '=', $user->id)
					->limit(1)
					->execute();
				
				// Create password reset
				$secret = \Model\UserSession::secret();
				\Model\PasswordReset::insert()
					->value('user', $user->id)
					->value('secret', $secret)
					->execute();
				
				$r_url = url("auth/reset/$secret");
				mail($user->email, 'Beaker CMS Password Reset', "Hello,\n\nYou have received this " .
					"email because you requested a password reset. To reset your password, visit the following link: $r_url",
					'From: noreply@bekr.me');
				
				$this->template('auth/reset_request_success');

			}

		}
		
	}

	/**
	 * Reset
	 */
	public function reset($secret) {
		
		if(is_post()) {
		
			$password = Input::post('password');
			$reset = \Model\PasswordReset::select()->where('secret', '=', $secret)->single();
			
			if($reset !== null and !empty($password)) {
				
				$user = \Model\User::id($reset->user) or die('Error: User not found');
				$user->merge_post(array('password'));

				// Update password
				\Model\User::update()
					->value('password', $user->password)
					->where('id', '=', $reset->user)
					->limit(1)
					->execute();
				
				// Delete password reset
				\Model\PasswordReset::delete()->where('id', '=', $reset->id)->limit(1)->execute();
				
				$this->template('auth/reset_success');
				
			} else {
			
				$this->data('secret', $secret);
				$this->data('error', true);
				$this->template('auth/reset');

			}

		}
	
	}

}