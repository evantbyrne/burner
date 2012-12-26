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
	 * User
	 * @option type = BelongsTo
	 */
	public $user;
		
	/**
	 * Secret
	 * @option type = Varchar
	 * @option length = 30
	 */
	public $secret;
	
}