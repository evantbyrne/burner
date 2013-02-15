<?php

namespace Library\Test;

/**
 * Test Library Exception
 * @author Evan Byrne
 */
class Exception extends \Exception {
	
	/**
	 * Given
	 * @param string Message
	 * @return \Library\Test\Exception
	 */
	public static function given($message, $backtrace) {

		return new static("$message\nFile: {$backtrace['file']}\nLine: {$backtrace['line']}");

	}

}