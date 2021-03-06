<?php

namespace Core;

/**
 * Autoload Class
 */
class Autoload {
	
	/**
	 * array Rules
	 */
	protected static $rules = array();

	/**
	 * Get
	 * @throws \Exception
	 * @param string Class to be loaded
	 */
	public static function get($class) {
		
		$class = ltrim($class, '\\');

		// Special rules
		$path = null;
		foreach(self::$rules as $regex => $func) {

			if(preg_match($regex, $class)) {

				$path = $func($class);
				break;

			}

		}

		// Standard rules
		if($path === null) {

			$segments = explode('/', str_replace('\\', '/', strtolower($class)));
			$last = count($segments) - 1;
			$segments[$last] = str_replace('_', '/', $segments[$last]);

			switch($segments[0]) {

				case 'core':
					$segments[0] = BURNER;
					break;

				case 'mysql':
					$segments[0] = BURNER . '/mysql';
					break;

				case 'column':
					$segments[0] = BURNER . '/column';
					break;

				case 'library':
					$segments[0] = BURNER . '/library';
					break;

			}

			$path = implode('/', $segments) . '.php';

		}

		if(!file_exists($path)) {

			throw new \Exception("Autoloaded file not found at '$path'");

		}

		require($path);
	
	}

	/**
	 * Set
	 * @param string Regex to match
	 * @param callable New path function
	 */
	public static function set($regex, $func) {

		self::$rules[$regex] = $func;

	}

}