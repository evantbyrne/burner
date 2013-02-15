<?php

namespace Library\Test;

/**
 * Test Library Exception
 * @author Evan Byrne
 */
class Exception extends \Exception {
	
	/**
	 * Given
	 * @param mixed Epected
	 * @param mixed Actual
	 * @return \Library\Test\Exception
	 */
	public static function given($expected, $actual, $backtrace) {

		$e_type = (is_object($expected)) ? get_class($expected) : gettype($expected);
		$a_type = (is_object($actual)) ? get_class($actual) : gettype($actual);
		return new static("File: {$backtrace['file']}\nLine: {$backtrace['line']}\nExpected: $e_type = " . json_encode($expected) . "\nActual: $a_type = " . json_encode($actual));

	}

}