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
	
}