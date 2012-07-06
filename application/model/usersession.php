<?php

namespace Model;

/**
 * User Session Model
 */
class UserSession extends Base\Session {
	
	/**
	 * @inheritdoc
	 */
	public static function blocks() {
	
		return array_merge(parent::blocks(), array(
		
			new \Block\Int('user')
			
		));
	
	}
	
}