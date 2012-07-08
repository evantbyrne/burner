<?php

namespace Model;

/**
 * Base User Model
 * @author Evan Byrne
 */
class User extends Base\Root {
	
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
	 * @inheritdoc
	 */
	public static function columns() {
	
		return array(
		
			new \Column\Email('email', array('length' => 100, 'required' => 'Email field required.')),
			new \Column\Varchar('password', array('length' => 255, 'required' => 'Password field required.')),
			new \Column\TinyInt('type'),
			new \Column\Varchar('verify_code', array('length' => 30, 'null' => true))
		
		);
		
	}
	
	/**
	 * Set Email
	 *
	 * @param string Email address
	 * @return $this
	 */
	public function set_email($email) {
		
		$this->email = $email;
		return $this;
		
	}
	
	/**
	 * Set Password
	 *
	 * Hashes and sets the password
	 * @param string Cleartext password
	 * @return $this
	 */
	public function set_password($password) {
		
		$this->password = sha1($password);
		return $this;
		
	}
	
	/**
	 * Check
	 * @return boolean
	 */
	public function check() {
		
		$res = $this->select(false)
			->and_where_null('verify_code')
			->and_where('type', '>', self::level('banned'))
			->limit(1)
			->execute();
		
		return !empty($res);
		
	}

}