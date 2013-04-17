<?php

namespace Library;

/**
 * Session Library
 * @author Evan Byrne
 */
class Session {

	/**
	 * Initialize
	 */
	protected static function init() {

		if(!session_id()) {

			$settings = \Core\Config::get('session');
			$expire = isset($settings['expire']) ? $settings['expire'] : '+1 months';
			$path = isset($settings['path']) ? $settings['path'] : null;
			$domain = isset($settings['domain']) ? $settings['domain'] : null;
			$secure = isset($settings['secure']) ? $settings['secure'] : false;
			$httponly = isset($settings['httponly']) ? $settings['httponly'] : false;

			$ex = new \DateTime();
			$ex->modify($expire);
			$time = intval($ex->format('U')) - time();

			ini_set('session.gc_maxlifetime', $time);
			session_set_cookie_params($time, $path, $domain, $secure, $httponly);
			session_start();

		}

	}

	/**
	 * Get
	 * @param string Key
	 * @return mixed Value, or null
	 */
	public static function get($key) {

		self::init();
		return isset($_SESSION[$key]) ? $_SESSION[$key] : null;

	}

	/**
	 * Set
	 * @param string Key
	 * @param mixed Value
	 */
	public static function set($key, $value) {

		self::init();
		$_SESSION[$key] = $value;

	}

	/**
	 * Delete
	 * @param string Key
	 */
	public static function delete($key) {

		self::init();
		unset($_SESSION[$key]);

	}

}