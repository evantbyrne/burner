<?php

namespace Library\Test;

/**
 * Test Library Base Class
 * @author Evan Byrne
 */
class Base {

	/**
	 * Get Type
	 * @param mixed
	 * @return string
	 */
	protected function get_type($variable) {

		return (is_object($variable)) ? get_class($variable) : gettype($variable);

	}

	/**
	 * Get Backtrace
	 * @return array Returns debug_backtrace()[1], or ['file' => 'unknown', 'line' => 'unknown']
	 */
	protected function get_backtrace() {

		$backtrace = debug_backtrace();
		if(isset($backtrace[1])) {

			return $backtrace[1];

		}  return array('file' => 'unknown', 'line' => 'unknown');

	}

	/**
	 * Fail
	 * @param string Message
	 * @throws \Library\Test\Exception
	 */
	public function fail($message) {

		throw \Library\Test\Exception::given($message, $this->get_backtrace());

	}

	/**
	 * Assert
	 * @param mixed Expected
	 * @param mixed Actual
	 * @throws \Library\Test\Exception
	 */
	public function assert($expected, $actual) {

		$fail = false;
		if(is_object($expected)) {

			if($expected != $actual) {

				$fail = true;

			}

		} elseif($expected !== $actual) {

			$fail = true;

		}

		if($fail) {

			$e_type = $this->get_type($expected);
			$a_type = $this->get_type($actual);
			$message = "Expected: $e_type = " . json_encode($expected) . "\nActual: $a_type = " . json_encode($actual);
			throw \Library\Test\Exception::given($message, $this->get_backtrace());

		}

	}

	/**
	 * Assert Not
	 * @param mixed Unexpected
	 * @param mixed Actual
	 * @throws \Library\Test\Exception
	 */
	public function assert_not($unexpected, $actual) {

		$fail = false;
		if(is_object($unexpected)) {

			if($unexpected == $actual) {

				$fail = true;

			}

		} elseif($unexpected === $actual) {

			$fail = true;

		}

		if($fail) {

			$e_type = $this->get_type($unexpected);
			$a_type = $this->get_type($actual);
			$message = "Unexpected: $e_type = " . json_encode($unexpected) . "\nActual: $a_type = " . json_encode($actual);
			throw \Library\Test\Exception::given($message, $this->get_backtrace());

		}

	}

	/**
	 * Assert Type
	 * @param string Expected type
	 * @param mixed Variable
	 * @throws \Library\Test\Exception
	 */
	public function assert_type($expected, $variable) {

		$type = $this->get_type($variable);
		if($expected !== $type) {

			$message = "Expected type: $expected\nActual: $type = " . json_encode($variable);
			throw \Library\Test\Exception::given($message, $this->get_backtrace());

		}

	}

}