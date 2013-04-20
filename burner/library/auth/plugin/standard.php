<?php

namespace Library\Auth\Plugin;
use Library\Session;
use Library\Auth\Exception as Ex;
use App\Model\User;

/**
 * Auth Library Standard Plugin
 *
 * Authenticates using 'email' and 'password' credentials. Uses
 * App\Model\User, which must extend Library\Auth\Model\Standard.
 */
class Standard implements \Library\Auth\BaseInterface {

	/**
	 * mixed User, null, or false if not yet set
	 */
	protected static $current_user = false;

	/**
	 * @inheritdoc
	 */
	public static function logged_in() {

		self::$current_user = null;
		
		$logged_in = false;
		$user_id = Session::get('auth_user_id');
		if($user_id !== null) {
			
			$user = User::select()->where('id', '=', $user_id)->single();
			if($user !== null) {
			
				self::$current_user = $user;
				$logged_in = true;
			
			}
			
		}

		return $logged_in;

	}

	/**
	 * @inheritdoc
	 */
	public static function current_user() {

		if(self::$current_user === false) {

			self::logged_in();

		}

		return self::$current_user;

	}

	/**
	 * @inheritdoc
	 */
	public static function enforce($group = false) {

		if(!self::logged_in()) {
			
			login_redirect(CURRENT_PAGE);
			
		}

		if($group !== false) {

			if(self::current_user()->type < User::level($group)) {

				\Core\Bootstrap::controller('App.Controller.Error', '_403');
				exit;

			}

		}

	}

	/**
	 * @inheritdoc
	 */
	public static function logout() {
		
		Session::delete('auth_user_id');

	}

	/**
	 * App\Model\User
	 */
	protected $user = null;

	/**
	 * boolean
	 */
	protected $valid = false;

	/**
	 * @inheritdoc
	 *
	 * Requires 'email' and 'password' credentials. Password must
	 * be hashed (which is automatically handled when using either
	 * ::from_array() or ::from_post() on the form/model class).
	 */
	public function __construct($credentials) {

		if(empty($credentials['email'])) {

			throw new Ex("'email' credential not provided");

		}

		if(empty($credentials['password'])) {

			throw new Ex("'password' credential not provided");

		}

		$user = new User();
		$user->email = $credentials['email'];
		$user->password = $credentials['password'];
		if($user->get()) {

			$this->valid = true;
			$this->user = $user;

		}

	}

	/**
	 * @inheritdoc
	 */
	public function valid() {

		return $this->valid;

	}

	/**
	 * @inheritdoc
	 */
	public function user() {

		return $this->user;

	}

	/**
	 * @inheritdoc
	 */
	public function login() {

		if($this->valid) {

			Session::set('auth_user_id', $this->user->id);
			return true;

		}

		return false;

	}

}