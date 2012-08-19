<?php

namespace Core\Model;

/**
 * User Session Model
 */
class UserSession extends Session {
	
	/**
	 * @inheritdoc
	 */
	public static $verbose = 'User Session';

	/**
	 * Construct
	 */
	public function __construct() {
	
		parent::__construct();
		$this->schema(new \Column\BelongsTo('user'));
	
	}
	
}