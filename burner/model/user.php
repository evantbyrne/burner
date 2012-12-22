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
	protected static $type_choices = array(

		40 => 'owner',
		30 => 'admin',
		20 => 'moderator',
		10 => 'user',
		-10 => 'banned'

	);
	
	/**
	 * All Levels
	 * @return array
	 */
	public static function all_levels() {
	
		return array_flip(static::$type_choices);
	
	}
	
	/**
	 * Level
	 * @param string Level to get integer value of
	 * @return int
	 */
	public static function level($level) {
	
		$levels = static::all_levels();
		return (isset($levels[$level])) ? $levels[$level] : 0;
	
	}
	
	/**
	 * Type
	 * @param int Level to get string value of
	 * @return string
	 */
	public static function type($level) {
	
		return (isset(static::$type_choices[$level])) ? $type_choices[$level] : '';
	
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
	 * @option choices = true
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

}