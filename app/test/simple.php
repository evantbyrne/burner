<?php

namespace App\Test;

class Simple extends \Library\Test\Base {

	public function not_a_test() {

		return 321;

	}

	public function test_equal() {

		$foo = 123;
		$this->assert(123, $foo);

	}

	public function test_should_fail() {

		$this->assert_type('string', $this->not_a_test());

	}

	public function test_should_also_fail() {

		$this->fail('This test was designed to fail');

	}

}