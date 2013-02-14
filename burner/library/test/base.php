<?php

namespace Library\Test;

/**
 * Test Library Base Class
 * @author Evan Byrne
 */
class Base {

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

			throw \Library\Test\Exception::given($expected, $actual);
			
		}

	}

}