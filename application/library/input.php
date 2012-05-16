<?php

namespace Library;

/**
 * Input Library
 * @author Evan Byrne
 */
class input {
	
	/**
	 * Post
	 * @param Field
	 */
	public static function post($field) {
		
		return (isset($_POST[$field])) ? $_POST[$field] : false;
	
	}
	
	/**
	 * Get
	 * @param Field
	 */
	public static function get($field) {
		
		return (isset($_GET[$field])) ? $_GET[$field] : false;

	}
	
	/**
	 * Cookie
	 * @param Field
	 */
	public static function cookie($field) {
	
		return (isset($_COOKIE[$field])) ? $_COOKIE[$field] : false;
	
	}
	
	/**
	 * Files
	 * @param Field
	 */
	public static function files($field) {
	
		return (isset($_FILES[$field])) ? $_FILES[$field] : false;

	}
	
	/**
	 * Request
	 * @param Field
	 */
	public static function request($field) {

		return (isset($_REQUEST[$field])) ? $_REQUEST[$field] : false;
	
	}

}