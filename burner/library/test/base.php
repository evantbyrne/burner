<?php

namespace Library\Test;

/**
 * Test Library Base Class
 * @author Evan Byrne
 */
class Base {

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
	 * Assert
	 * @param mixed Epected
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

			throw \Library\Test\Exception::given($expected, $actual, $this->get_backtrace());

		}

	}

}