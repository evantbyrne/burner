<?php

namespace Library\Auth\Model;

/**
 * User Session Model
 */
class UserSession extends \Core\Model\Session {
	
	/**
	 * @inheritdoc
	 */
	public static $verbose = 'User Session';

	/**
	 * User
	 * @option type = BelongsTo
	 */
	public $user;
	
}