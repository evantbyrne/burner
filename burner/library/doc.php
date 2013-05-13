<?php

namespace Library;

/**
 * Documenter
 */
class Doc {

	/**
	 * Parse
	 * @param mixed Class name or instance of class
	 * @return Library\Doc_ResultClass
	 */
	public static function parse($klass) {

		$reflection = new \ReflectionClass($klass);
		$title = self::parse_title($reflection);
		$description = self::parse_description($reflection);
		$tags = self::parse_tags($reflection);
		$properties = array();
		$methods = array();

		foreach($reflection->getProperties() as $property_reflection) {

			$property_title = self::parse_title($property_reflection);
			$property_description = self::parse_description($property_reflection);
			$property_tags = self::parse_tags($property_reflection);
			$properties[] = new Doc_ResultProperty($property_reflection, $property_title, $property_description, $property_tags);

		}

		foreach($reflection->getMethods() as $method_reflection) {

			$method_title = self::parse_title($method_reflection);
			$method_description = self::parse_description($method_reflection);
			$method_tags = self::parse_tags($method_reflection);
			$methods[] = new Doc_ResultMethod($method_reflection, $method_title, $method_description, $method_tags);

		}

		return new Doc_ResultClass($reflection, $title, $description, $tags, $properties, $methods);

	}

	/**
	 * Parse Title
	 * @param Reflector
	 * @return string Title, which may be null
	 */
	protected static function parse_title($reflection) {

		$lines = explode("\n", $reflection->getDocComment());
		$count = count($lines);
		if($count >= 3) {

			$line = trim(preg_replace('/^\*/', '', trim($lines[1])));
			if(substr($line, 0, 1) !== '@') {

				return $line;

			}

		}

		return null;

	}

	/**
	 * Parse Description
	 * @param Reflector
	 * @return string Description, which may be null
	 */
	protected static function parse_description($reflection) {

		$description = null;
		$lines = explode("\n", $reflection->getDocComment());
		$count = count($lines);
		if($count >= 4) {

			for($i = 2; $i < ($count - 1); $i++) {

				$line = trim(preg_replace('/^\*/', '', trim($lines[$i])));
				if(substr($line, 0, 1) === '@') {

					return $description;

				} elseif(!empty($line)) {

					$description = ($description === null) ? $line : "$description\n$line";

				}

			}

		}

		return $description;

	}

	/**
	 * Parse Tags
	 * @param Reflector
	 * @return array An array of Library\Doc_ResultTag
	 */
	protected static function parse_tags($reflection) {

		$tags = array();
		$lines = explode("\n", $reflection->getDocComment());
		foreach($lines as $line) {

			$line = trim(preg_replace('/^\*/', '', trim($line)));
			if(substr($line, 0, 1) === '@') {

				$parts = explode(' ', $line, 2);
				$name = substr($parts[0], 1);
				$value = (isset($parts[1])) ? $parts[1] : null;
				$tags[] = new Doc_ResultTag($name, $value);

			}

		}

		return $tags;

	}

}