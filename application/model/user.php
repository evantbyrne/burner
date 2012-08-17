<?php

namespace Model;

/**
 * Example User Model
 */
class User extends \Core\Model\User {
	
	/**
	 * @inheritdoc
	 */
	public function __construct() {
		
		parent::__construct();
		$this->schema(new \Column\Image('avatar', array('dir' => 'static/user/avatar')));
		$this->admin('avatar');
		
	}
	
}