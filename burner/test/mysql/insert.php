<?php

namespace Core\Test\Mysql;
use \Mysql\Insert as I;

class Insert extends \Library\Test\Base {

	public function test_value() {

		$i = new I('foo');
		$i->value('bar', 'baz');
		$q = $i->build();
		$this->assert('INSERT INTO `foo` (`bar`) VALUES (?)', $q->sql());
		$this->assert(array('baz'), $q->params());

	}

	public function test_multiple() {

		$i = new I('foo');
		$i->value('bar', 'baz');
		$i->value('foobar', 37);
		$q = $i->build();
		$this->assert('INSERT INTO `foo` (`bar`, `foobar`) VALUES (?, ?)', $q->sql());
		$this->assert(array('baz', 37), $q->params());

	}

}