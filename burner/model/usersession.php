<?php

namespace Core\Model;

/**
 * User Session Model
 */
class UserSession extends Session {
	
	/**
	 * Construct
	 */
	public function __construct() {
	
		parent::__construct();
		$this->schema(new \Column\Int('user'));
	
	}
	
}