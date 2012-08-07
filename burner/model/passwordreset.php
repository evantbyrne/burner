<?php

namespace Core\Model;

/**
 * Password Reset Model
 */
class PasswordReset extends Base {
	
	/**
	 * Construct
	 */
	public function __construct() {
	
		$this->schema(
		
			new \Column\Int('user'),
			new \Column\Varchar('secret', array('length' => 30))
			
		);
	
	}
	
}