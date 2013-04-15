<?php

namespace Library;

/**
 * Doc Comment Library
 * @author Evan Byrne
 */
class DocComment {
	
	/**
	 * array Cached class options
	 */
	protected static $cache = array();

	/**
	 * Options
	 * @param mixed Anything with a getDocComment() method, such as ReflectionClass
	 * @return array
	 */
	public static function options($object) {

		$name = $object->getName();
		$is_class = is_a($object, 'ReflectionClass');
		
		if($is_class and isset(self::$cache[$name])) {

			return self::$cache[$name];

		}

		$options = array();
		$doc_lines = explode("\n", $object->getDocComment());
		foreach($doc_lines as $line) {
			
			$line = trim(preg_replace('/^\*/', '', trim($line)));
			if(substr($line, 0, 7) === '@option') {

				$line_halves = explode('=', substr($line, 7));
				$option_name = trim($line_halves[0]);
				$options[$option_name] = (isset($line_halves[1])) ? trim($line_halves[1]) : null;
				
				// Boolean options
				if($options[$option_name] === 'true') {
				
					$options[$option_name] = true;
				
				} elseif($options[$option_name] === 'false') {

					$options[$option_name] = false;

				}
			
			}

		}

		if($is_class) {

			self::$cache[$name] = $options;

		}

		return $options;

	}

}