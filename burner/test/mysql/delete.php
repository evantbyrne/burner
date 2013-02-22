<?php

namespace Core\Test\Mysql;
use \Mysql\Delete as D;

class Delete extends \Library\Test\Base {

	public function test_where() {

		$d = new D('foo');
		$d->where('foobar', '=', 'yup');
		$q = $d->build();
		$this->assert("DELETE FROM `foo` WHERE `foobar` = ?", $q->sql());
		$this->assert(array('yup'), $q->params());

	}


	// ----- Limit -----


	public function test_where_limit() {

		$d = new D('foo');
		$d->where('foobar', '=', 'yup');
		$d->limit(5);
		$q = $d->build();
		$this->assert("DELETE FROM `foo` WHERE `foobar` = ? LIMIT 5", $q->sql());
		$this->assert(array('yup'), $q->params());

	}

	public function test_limit() {

		$d = new D('foo');
		$d->limit(5);
		$q = $d->build();
		$this->assert("DELETE FROM `foo` LIMIT 5", $q->sql());
		$this->assert(array(), $q->params());

	}

}