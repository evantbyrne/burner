<?php

namespace Library;

/**
 * Doc Comment Library
 * @author Evan Byrne
 */
class DocComment {
	
	/**
	 * Options
	 * @param mixed Anything with a getDocComment() method, such as RefletionClass
	 * @return array
	 */
	public static function options($object) {

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

		return $options;

	}

}