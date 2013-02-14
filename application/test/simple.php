<?php

namespace Test;

class Simple extends \Library\Test\Base {

	public function not_a_test() {

		return 321;

	}

	public function test_equal() {

		$foo = 123;
		$this->assert(123, $foo);

	}

	public function test_should_fail() {

		$this->assert('321', $this->not_a_test());

	}

}