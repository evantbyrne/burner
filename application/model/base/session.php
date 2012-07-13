<?php

namespace Model\Base;

/**
 * Base Session Model
 * @author Evan Byrne
 */
abstract class Session extends \Model\Base {

	protected static $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789=_';
	
	/**
	 * Secret
	 * @param Minimum length of random range
	 * @param Maximum length of random range
	 * @return A mixture of random characters
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
	 * Construct
	 */
	public function __construct() {
	
		$this->schema(
			new \Column\Text('secret', array('unique' => true)),
			new \Column\Timestamp('expire', array('null' => true))
		);
	
	}

}