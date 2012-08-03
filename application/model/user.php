<?php

namespace Model;

/**
 * Example User Model
 * @author Evan Byrne
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