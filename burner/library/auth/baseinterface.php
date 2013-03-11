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

	/**
	 * Enforce
	 * @param string Group
	 */
	public function enforce($group = false);

	/**
	 * Create
	 * @param array Extra parameters
	 * @return boolean Success
	 */
	public function create($params = array());

}