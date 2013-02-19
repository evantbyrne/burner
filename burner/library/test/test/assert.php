<?php

namespace Library\Test\Test;

class Assert extends \Library\Test\Base {
	
	public function test_assert() {

		$this->assert(123, 123);
		$this->assert(2.3, 2.3);
		$this->assert('321', '321');
		$this->assert('Foo', 'Foo');

		$a1 = new Assert();
		$a2 = new Assert();
		$this->assert($a1, $a2);

		$a1->bar = 'baz';
		$a2->bar = 'baz';
		$this->Assert($a1, $a2);

	}

	public function test_assert_integer() {

		$this->assert_not(1, 2);
		$fail = false;
		try {
			
			$this->assert(1, 2);

		} catch (\Exception $e) {

			$fail = true;

		}

		if(!$fail) {

			$this->fail('Should have failed assertion.');

		}

	}

	public function test_assert_double() {

		$this->assert_not(1.1, 1.2);
		$fail = false;
		try {
			
			$this->assert(1.1, 1.2);

		} catch (\Exception $e) {

			$fail = true;

		}

		if(!$fail) {

			$this->fail('Should have failed assertion.');

		}

	}

	public function test_assert_number_type_mismatch() {

		$this->assert_not(1, 1.0);
		$fail = false;
		try {
			
			$this->assert(1, 1.0);

		} catch (\Exception $e) {

			$fail = true;

		}

		if(!$fail) {

			$this->fail('Should have failed assertion.');

		}

	}

	public function test_assert_string() {

		$this->assert_not('abc', 'abcd');
		$fail = false;
		try {
			
			$this->assert('abc', 'abcd');

		} catch (\Exception $e) {

			$fail = true;

		}

		if(!$fail) {

			$this->fail('Should have failed assertion.');

		}

	}

	public function test_assert_string_case() {

		$this->assert_not('abc', 'aBc');
		$fail = false;
		try {
			
			$this->assert('abc', 'aBc');

		} catch (\Exception $e) {

			$fail = true;

		}

		if(!$fail) {

			$this->fail('Should have failed assertion.');

		}

	}

	public function test_assert_object_same_type() {

		$a1 = new Assert();
		$a1->x = 123;
		$a2 = new Assert();
		$a2->x = 321;

		$this->assert_not($a1, $a2);
		$fail = false;
		try {
			
			$this->assert($a1, $a2);

		} catch (\Exception $e) {

			$fail = true;

		}

		if(!$fail) {

			$this->fail('Should have failed assertion.');

		}

	}

	public function test_assert_object_type_string() {

		$a1 = new Assert();

		$this->assert_not($a1, 'foo');
		$fail = false;
		try {
			
			$this->assert($a1, 'foo');

		} catch (\Exception $e) {

			$fail = true;

		}

		if(!$fail) {

			$this->fail('Should have failed assertion.');

		}

	}

	public function test_assert_object_type_another() {

		$a1 = new Assert();
		$a2 = new \Library\Test\Base();

		$this->assert_not($a1, $a2);
		$fail = false;
		try {
			
			$this->assert($a1, $a2);

		} catch (\Exception $e) {

			$fail = true;

		}

		if(!$fail) {

			$this->fail('Should have failed assertion.');

		}

	}


	// ----- Not -----


	public function test_assert_not_integer() {

		$fail = false;
		try {
			
			$this->assert_not(1, 1);

		} catch (\Exception $e) {

			$fail = true;

		}

		if(!$fail) {

			$this->fail('Should have failed assertion.');

		}

	}

	public function test_assert_not_double() {

		$fail = false;
		try {
			
			$this->assert_not(1.2, 1.2);

		} catch (\Exception $e) {

			$fail = true;

		}

		if(!$fail) {

			$this->fail('Should have failed assertion.');

		}

	}

	public function test_assert_not_string() {

		$fail = false;
		try {
			
			$this->assert_not('abc', 'abc');

		} catch (\Exception $e) {

			$fail = true;

		}

		if(!$fail) {

			$this->fail('Should have failed assertion.');

		}

	}

	public function test_assert_not_string_case() {

		$fail = false;
		try {
			
			$this->assert_not('aBc', 'aBc');

		} catch (\Exception $e) {

			$fail = true;

		}

		if(!$fail) {

			$this->fail('Should have failed assertion.');

		}

	}

	public function test_assert_not_object_same_type() {

		$a1 = new Assert();
		$a1->x = 123;
		$a2 = new Assert();
		$a2->x = 123;

		$fail = false;
		try {
			
			$this->assert_not($a1, $a2);

		} catch (\Exception $e) {

			$fail = true;

		}

		if(!$fail) {

			$this->fail('Should have failed assertion.');

		}

	}

}