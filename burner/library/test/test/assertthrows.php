<?php

namespace Library\Test\Test;

class CustomException extends \Exception {}

class AssertThrows extends \Library\Test\Base {

	public function test_throws() {

		$this->assert_throws('Exception', function() {

			throw new \Exception('foo');

		});

	}

	public function test_throws_inherits() {

		$this->assert_throws('Exception', function() {

			throw new CustomException('foo');

		});

	}

	public function test_throws_missing_exception() {

		$fail = false;
		try {
		
			$this->assert_throws('Exception', function() {

				// ...

			});

		} catch(\Exception $e) {

			$fail = true;

		}

		if(!$fail) {

			$this->fail('Should have failed assertion');

		}

	}

	public function test_throws_wrong_exception() {

		$fail = false;
		try {
		
			$this->assert_throws('Library\Test\Test\CustomException', function() {

				throw new \Exception('foo');

			});

		} catch(\Exception $e) {

			$fail = true;

		}

		if(!$fail) {

			$this->fail('Should have failed assertion');

		}

	}

}