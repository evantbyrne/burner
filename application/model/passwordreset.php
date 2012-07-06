<?php

namespace Model;

/**
 * Password Reset Model
 */
class PasswordReset extends \Model\Base\Root {
	
	/**
	 * @inheritdoc
	 */
	public static function blocks() {
	
		return array(
		
			new \Block\TinyInt('user'),
			new \Block\Varchar('secret', array('length' => 30))
			
		);
	
	}
	
}