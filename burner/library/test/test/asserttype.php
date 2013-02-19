<?php

namespace Library\Test\Test;

class AssertType extends \Library\Test\Base {

	public function test_assert_type() {

		$this->assert_type('integer', 123);
		$this->assert_type('double', 1.0);
		$this->assert_type('string', 'foo');
		$this->assert_type('string', '1');
		$this->assert_type('NULL', null);
		$this->assert_type('boolean', true);
		$this->assert_type('boolean', false);
		$this->assert_type('array', array());

		$a = new AssertType();
		$this->assert_type('Library\\Test\\Test\\AssertType', $a);
		$this->assert_type('ReflectionClass', new \ReflectionClass($a));

	}

	public function test_assert_type_integer() {

		$fail = false;
		try {
			
			$this->assert_type('integer', 1.0);

		} catch (\Exception $e) {

			$fail = true;

		}

		if(!$fail) {

			$this->fail('Should have failed assertion.');

		}

	}

	public function test_assert_type_double() {

		$fail = false;
		try {
			
			$this->assert_type('double', 1);

		} catch (\Exception $e) {

			$fail = true;

		}

		if(!$fail) {

			$this->fail('Should have failed assertion.');

		}

	}

	public function test_assert_type_string() {

		$fail = false;
		try {
			
			$this->assert_type('string', 1);

		} catch (\Exception $e) {

			$fail = true;

		}

		if(!$fail) {

			$this->fail('Should have failed assertion.');

		}

	}

	public function test_assert_type_null() {

		$fail = false;
		try {
			
			$this->assert_type('NULL', false);

		} catch (\Exception $e) {

			$fail = true;

		}

		if(!$fail) {

			$this->fail('Should have failed assertion.');

		}

	}

	public function test_assert_type_boolean() {

		$fail = false;
		try {
			
			$this->assert_type('NULL', true);

		} catch (\Exception $e) {

			$fail = true;

		}

		if(!$fail) {

			$this->fail('Should have failed assertion.');

		}

	}

	public function test_assert_type_array() {

		$fail = false;
		try {
			
			$this->assert_type('array', null);

		} catch (\Exception $e) {

			$fail = true;

		}

		if(!$fail) {

			$this->fail('Should have failed assertion.');

		}

	}

	public function test_assert_type_object() {

		$a = new AssertType();
		$this->assert_type('Library\\Test\\Test\\AssertType', $a);

		$fail = false;
		try {
			
			$this->assert_type('ReflectionClass', $a);

		} catch (\Exception $e) {

			$fail = true;

		}

		if(!$fail) {

			$this->fail('Should have failed assertion.');

		}

	}

}