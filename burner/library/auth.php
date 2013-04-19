<?php

namespace Library;

/**
 * Auth Library
 */
class Auth implements Auth\BaseInterface {

	/**
	 * @inheritdoc
	 */
	public static function logged_in() {

		$plugin_class = to_php_namespace('Library.Auth.Plugin.' . \Core\Config::get('auth_plugin'));
		return $plugin_class::logged_in();

	}

	/**
	 * @inheritdoc
	 */
	public static function current_user() {

		$plugin_class = to_php_namespace('Library.Auth.Plugin.' . \Core\Config::get('auth_plugin'));
		return $plugin_class::current_user();

	}

	/**
	 * @inheritdoc
	 */
	public static function enforce($group = false) {

		$plugin_class = to_php_namespace('Library.Auth.Plugin.' . \Core\Config::get('auth_plugin'));
		return $plugin_class::enforce($group);

	}

	/**
	 * @inheritdoc
	 */
	public static function logout() {

		$plugin_class = to_php_namespace('Library.Auth.Plugin.' . \Core\Config::get('auth_plugin'));
		$plugin_class::logout();

	}

	/**
	 * Hash
	 * @param string Value
	 * @param string Secret
	 * @return string Hashed value
	 */
	public static function hash($value, $secret = null, $iterations = null) {
		
		if($secret === null) {

			$secret = \Core\Config::get('hash_secret');

		}

		if($iterations === null) {
			
			$iterations = \Core\Config::get('hash_iterations');

		}

		for($i = 0; $i < $iterations; $i++) {

			$value = hash_hmac('sha512', $value, $secret);

		}

		return $value;
		
	}

	/**
	 * string
	 */
	public $plugin_class;

	/**
	 * Library\Auth\BaseInterface Auth plugin
	 */
	public $plugin;

	/**
	 * @inheritdoc
	 */
	public function __construct($credentials) {
		
		$plugin_class = to_php_namespace('Library.Auth.Plugin.' . \Core\Config::get('auth_plugin'));
		$this->plugin = new $plugin_class($credentials);

	}

	/**
	 * @inheritdoc
	 */
	public function valid() {

		return $this->plugin->valid();

	}

	/**
	 * @inheritdoc
	 */
	public function user() {

		return $this->plugin->user();

	}

	/**
	 * @inheritdoc
	 */
	public function login() {

		return $this->plugin->login();

	}

}