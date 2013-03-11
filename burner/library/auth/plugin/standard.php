<?php

namespace Library\Auth\Plugin;
use Library\Input as Input;
use Library\Cookie as Cookie;
use Library\Auth\Exception as Ex;
use App\Model\User as User;
use App\Model\UserSession as UserSession;

/**
 * Auth Library Email Plugin
 *
 * Authenticates using 'email' and 'password' credentials. Uses
 * App\Model\User, which must extend Library\Auth\Model\Standard.
 */
class Standard implements \Library\Auth\BaseInterface {

	/**
	 * @inheritdoc
	 */
	public static function logged_in() {

		$logged_in = false;
		$secret = Input::cookie('auth');
		if($secret !== null) {
			
			$session = UserSession::select()->where('secret', '=', $secret)->single();
			if($session !== null) {
				
				$user = User::select()->where('id', '=', $session->user)->single();
				if($user !== null) {
				
					$logged_in = true;
				
				}
				
			}
			
		}

		return $logged_in;

	}

	/**
	 * @inheritdoc
	 */
	public static function logout() {

		$secret = Input::cookie('auth');
		
		if($secret !== null) {
		
			UserSession::delete()
				->where('secret', '=', $secret)
				->limit(1)
				->execute();

			Cookie::delete(array(
				'path' => '/',
				'name' => 'auth'
			));
		
		}

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
	 * Requires 'email' and 'password' credentials
	 */
	public function __construct($credentials) {

		if(empty($credentials['email'])) {

			throw new Ex("'email' credential not provided");

		}

		if(empty($credentials['password'])) {

			throw new Ex("'password' credential not provided");

		}

		$user = User::from_array($credentials, array('email', 'password'));
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

		$table = UserSession::table();
		$secret = UserSession::secret();
		$expire = new \DateTime();
		$expire->modify('+30 days');

		\Core\DB::connection()->execute(new \Mysql\Query("INSERT INTO `$table` (`secret`, `user`, `expire`) VALUES (?, ?, FROM_UNIXTIME(?))", array(
			$secret,
			$this->user->id,
			$expire->format('U'))));

		Cookie::set(array(
			'path'   => '/',
			'name'   => 'auth',
			'value'  => $secret,
			'expire' => '+30 days'
		));

	}

	/**
	 * @inheritdoc
	 */
	public function enforce($group = false) {

		if(!self::logged_in()) {
			
			login_redirect(CURRENT_PAGE);
			
		}

		if($group !== false) {

			if($this->user->type < User::level($group)) {

				\Core\Bootstrap::controller('App.Controller.Error', '_403');
				exit;

			}

		}

	}

	/**
	 * @inheritdoc
	 */
	public function create($params = array()) {

		throw new Ex('Not implemented');

	}

}