<?php

namespace Model\Base;

/**
 * Base Session Model
 * @author Evan Byrne
 */
abstract class Session extends Root {

	protected static $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789=_';
	
	/**
	 * Blocks
	 * @return Array of blocks that make up model
	 */
	public static function blocks() {
	
		return array(
		
			new \Block\Text('secret', array('unique' => true)),
			new \Block\Timestamp('expire', array('null' => true))
		
		);
	
	}
	
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

}