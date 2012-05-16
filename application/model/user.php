<?php

namespace Model;

/**
 * User Model
 * @author Evan Byrne
 */
class User extends Base {
	
	/**
	 * Blocks
	 * @return Array of blocks that make up model
	 */
	public static function blocks() {
	
		return array(
		
			new \Block\Email('email'),
			new \Block\Text('password')
		
		);
		
	}
	
	/**
	 * Set Email
	 * @param Email address
	 * @return This
	 */
	public function set_email($email) {
		
		$this->email = $email;
		return $this;
		
	}
	
	/**
	 * Set Password
	 * Hashes and sets the password
	 * @param Cleartext password
	 * @return This
	 */
	public function set_password($password) {
		
		// TODO: Add other hash options via encryption library
		$this->password = sha1($password);
		return $this;
		
	}
	
	/**
	 * Check
	 */
	public function check() {
		
		$res = self::select()
			->where('email', '=', $this->email)
			->and_where('password', '=', $this->password)
			->limit(1)
			->execute();
		
		return !empty($res);
		
	}

}