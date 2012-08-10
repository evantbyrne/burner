<?php

namespace Model;

/**
 * Example User Model
 */
class User extends \Core\Model\User {

	/**
	 * Construct
	 */
	public function __construct() {

		parent::__construct();

		$this->admin('email');
		$this->admin('type');

	}
	
	/**
	 * To String
	 * @return string Email
	 */
	public function __toString() {

		return $this->email;

	}
	
}