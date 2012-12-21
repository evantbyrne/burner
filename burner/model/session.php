<?php

namespace Core\Model;

/**
 * Base Session Model
 * @author Evan Byrne
 */
abstract class Session extends Base {

	/**
	 * string Possible characters for secret
	 */
	protected static $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789=_';
	
	/**
	 * Secret
	 * @param int Minimum length of random range
	 * @param int Maximum length of random range
	 * @return string A mixture of random characters
	 */
	public static function secret($min=10, $max=30) {
		
		$len = rand($min, $max);
		$salt = '';

		for($i = 0; $i < $len; $i++) {
		
			$char = substr(static::$chars, mt_rand(0, strlen(static::$chars) - 1), 1);
			$salt .= $char;
		
		}
		
		return $salt;
	
	}

	/**
	 * Clean
	 */
	public static function clean() {

		self::delete()->where('expire', '<=', date('Y-m-d H:i:s', time()))->execute();

	}

	/**
	 * Secret
	 * @option type = Text
	 * @option unique = true
	 */
	public $secret;

	/**
	 * Expire
	 * @option type = Timestamp
	 * @option null = true
	 */
	public $expire;

}