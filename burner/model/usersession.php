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
	 * User
	 * @option type = BelongsTo
	 */
	public $user;
	
}