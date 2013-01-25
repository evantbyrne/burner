<?php

namespace Core\Controller\Auth;

/**
 * Auth Interface
 * @author Evan Byrne
 */
interface BaseInterface {

	/**
	 * Logged In
	 * @param boolean Don't cache result
	 * @return boolean
	 */
	public static function logged_in($no_cache = false);

	/**
	 * User
	 * @param boolean Don't cache
	 * @return mixed Current user, or null
	 */
	public static function user($no_cache = false);

	/**
	 * Enforce
	 */
	public static function enforce($level = false);

	/**
	 * Register
	 */
	public function register();

	/**
	 * Login
	 */
	public function login($redirect = false);

	/**
	 * Logout
	 */
	public function logout();

}