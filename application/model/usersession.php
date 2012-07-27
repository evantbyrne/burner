<?php

namespace Model;

/**
 * User Session Model
 */
class UserSession extends \Core\Model\Session {
	
	/**
	 * Construct
	 */
	public function __construct() {
	
		parent::__construct();
		$this->schema(new \Column\Int('user'));
	
	}
	
}