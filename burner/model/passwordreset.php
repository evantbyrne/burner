<?php

namespace Core\Model;

/**
 * Password Reset Model
 */
class PasswordReset extends Base {
	
	/**
	 * @inheritdoc
	 */
	public static $verbose = 'Password Reset';

	/**
	 * Construct
	 */
	public function __construct() {
	
		$this->schema(
		
			new \Column\BelongsTo('user'),
			new \Column\Varchar('secret', array('length' => 30))
			
		);
	
	}
	
}