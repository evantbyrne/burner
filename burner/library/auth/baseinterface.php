<?php

namespace Library\Auth;

/**
 * Auth Library Base Interface
 */
interface BaseInterface {

	/**
	 * Logged In
	 * @return boolean
	 */
	public static function logged_in();

	/**
	 * Current User
	 * @return mixed User, or null
	 */
	public static function current_user();

	/**
	 * Enforce
	 * @param string Group
	 */
	public static function enforce($group = false);

	/**
	 * Logout
	 */
	public static function logout();

	/**
	 * Constructor
	 * @param array User credentials
	 */
	public function __construct($credentials);

	/**
	 * Valid
	 * @return boolean
	 */
	public function valid();

	/**
	 * User
	 * @return mixed User, or null
	 */
	public function user();

	/**
	 * Login
	 * @param array Extra parameters
	 * @return boolean Success
	 */
	public function login();

}