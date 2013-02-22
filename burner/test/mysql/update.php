<?php

namespace Core\Test\Mysql;
use \Mysql\Update as U;

class Update extends \Library\Test\Base {

	public function test_value() {

		$u = new U('foo');
		$u->value('bar', 'baz');
		$q = $u->build();
		$this->assert("UPDATE `foo` SET `bar` = ?", $q->sql());
		$this->assert(array('baz'), $q->params());

	}

	public function test_value_null() {

		$u = new U('foo');
		$u->value('bar', null);
		$q = $u->build();
		$this->assert("UPDATE `foo` SET `bar` = NULL", $q->sql());
		$this->assert(array(), $q->params());

	}

	public function test_value_multiple() {

		$u = new U('foo');
		$u->value('bar', 'baz');
		$u->value('foobar', 'yup');
		$q = $u->build();
		$this->assert("UPDATE `foo` SET `bar` = ?, `foobar` = ?", $q->sql());
		$this->assert(array('baz', 'yup'), $q->params());

		$u = new U('foo');
		$u->value('bar', 'baz');
		$u->value('foobar', 'yup');
		$u->value('third', null);
		$q = $u->build();
		$this->assert("UPDATE `foo` SET `bar` = ?, `foobar` = ?, `third` = NULL", $q->sql());
		$this->assert(array('baz', 'yup'), $q->params());

	}


	// ----- Where -----


	public function test_value_where() {

		$u = new U('foo');
		$u->value('bar', 'baz');
		$u->where('foobar', '=', 'yup');
		$q = $u->build();
		$this->assert("UPDATE `foo` SET `bar` = ? WHERE `foobar` = ?", $q->sql());
		$this->assert(array('baz', 'yup'), $q->params());

	}


	// ----- Limit -----


	public function test_where_limit() {

		$u = new U('foo');
		$u->value('bar', 'baz');
		$u->where('foobar', '=', 'yup');
		$u->limit(5);
		$q = $u->build();
		$this->assert("UPDATE `foo` SET `bar` = ? WHERE `foobar` = ? LIMIT 5", $q->sql());
		$this->assert(array('baz', 'yup'), $q->params());

	}

	public function test_limit() {

		$u = new U('foo');
		$u->value('bar', 'baz');
		$u->limit(5);
		$q = $u->build();
		$this->assert("UPDATE `foo` SET `bar` = ? LIMIT 5", $q->sql());
		$this->assert(array('baz'), $q->params());

	}

}