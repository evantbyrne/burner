<?php

namespace Model;

/**
 * Password Reset Model
 */
class PasswordReset extends \Core\Model\Base {
	
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