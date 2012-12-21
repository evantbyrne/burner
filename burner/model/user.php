<?php

namespace Core\Model;
use Core\Config;

/**
 * Base User Model
 * @author Evan Byrne
 */
class User extends Base {
	
	/**
	 * array User levels, which are primarily used for ACLs
	 */
	protected static $levels = array(
	
		'owner'     => 40,
		'admin'     => 30,
		'moderator' => 20,
		'user'      => 10,
		'banned'    => -10
	
	);
	
	/**
	 * All Levels
	 * @return array
	 */
	public static function all_levels() {
	
		return static::$levels;
	
	}
	
	/**
	 * Level
	 * @param string Level to get integer value of
	 * @return int
	 */
	public static function level($level) {
	
		return (isset(static::$levels[$level])) ? static::$levels[$level] : 0;
	
	}
	
	/**
	 * Type
	 * @param int Level to get string value of
	 * @return string
	 */
	public static function type($level) {
	
		$types = array_flip(static::$levels);
		return (isset($types[$level])) ? $types[$level] : '';
	
	}
	
	/**
	 * Hash
	 * @param string Value
	 * @param string Secret
	 * @return string Hashed value
	 */
	public static function hash($value, $secret = null) {
		
		return hash_hmac('sha512', $value, ($secret === null) ? Config::get('hash_secret') : $secret);
		
	}

	/**
	 * Email
	 * @option type = Email
	 * @option length = 100
	 * @option required = Email field is required.
	 */
	public $email;

	/**
	 * Password
	 * @option type = Password
	 * @option required = Password field is required.
	 */
	public $password;

	/**
	 * Type
	 * @option type = TinyInt
	 * @option template = select
	 */
	public $type;

	/**
	 * Verify Code
	 * @option type = Varchar
	 * @option length = 30
	 * @option null = true
	 * @option admin = false
	 */
	public $verify_code;

	/**
	 * To String
	 * @return string Email
	 */
	public function __toString() {

		return $this->email;

	}

	/*public function __construct() {
		
		$this->schema(
			new \Column\Email('email', array('length' => 100, 'required' => 'Email field required.')),
			new \Column\Password('password', array('required' => 'Password field required.')),
			new \Column\TinyInt('type', array('template' => 'select', 'choices' => array_flip(static::$levels))),
			new \Column\Varchar('verify_code', array('length' => 30, 'null' => true, 'admin' => false))
		);
		
	}*/

}