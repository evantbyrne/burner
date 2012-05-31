<?php

namespace Library;

/**
 * Input Library
 * @author Evan Byrne
 */
class Input {
	
	/**
	 * @param Field
	 * @param Default value
	 */
	public static function post($field, $default = null) {
		
		return (isset($_POST[$field])) ? $_POST[$field] : $default;
	
	}
	
	/**
	 * @param Field
	 * @param Default value
	 */
	public static function get($field, $default = null) {
		
		return (isset($_GET[$field])) ? $_GET[$field] : $default;

	}
	
	/**
	 * @param Field
	 * @param Default value
	 */
	public static function cookie($field, $default = null) {
	
		return (isset($_COOKIE[$field])) ? $_COOKIE[$field] : $default;
	
	}
	
	/**
	 * @param Field
	 * @param Default value
	 */
	public static function files($field, $default = null) {
	
		return (isset($_FILES[$field])) ? $_FILES[$field] : $default;

	}
	
	/**
	 * @param Field
	 * @param Default value
	 */
	public static function request($field, $default = null) {

		return (isset($_REQUEST[$field])) ? $_REQUEST[$field] : $default;
	
	}

}