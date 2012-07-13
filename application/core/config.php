<?php

namespace Core;

/**
 * Config Class
 * @author Evan Byrne
 */
class Config {
	
	private static $x = array();
	
	/**
	 * Set
	 * @param string Name
	 * @param mixed Value
	 */
	public static function set($name, $val) {
		
		self::$x[$name] = $val;
	
	}
	
	/**
	 * Get
	 * @param string Name
	 * @return mixed Value
	 */
	public static function get($name) {
		
		return (isset(self::$x[$name])) ? self::$x[$name] : false;
		
	}
	
	/**
	 * Remove
	 * @param string Name
	 */
	public static function remove($name) {
		
		if(isset(self::$x[$name])) {
			
			unset(self::$x[$name]);
			
		}
		
	}
	
	/**
	 * Rename
	 * @param string Old name
	 * @param string New name
	 */
	public static function rename($old, $new) {
		
		self::$x[$new] = self::$x[$old];
		unset(self::$x[$old]);
	
	}

}