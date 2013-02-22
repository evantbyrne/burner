<?php

namespace Core\Test\Mysql;
use \Mysql\CreateTable as T;

class CreateTable extends \Library\Test\Base {

	public function test_empty() {

		$t = new T('foo');
		$q = $t->build();
		$this->assert("CREATE TABLE `foo`(\n\n)", $q->sql());

	}

	public function test_add() {

		$t = new T('foo');
		$t->add(new \Mysql\TextColumn('bar'));
		$q = $t->build();
		$this->assert("CREATE TABLE `foo`(\n`bar` TEXT\n)", $q->sql());

	}

	public function test_add_multiple() {

		$t = new T('foo');
		$t->add(new \Mysql\TextColumn('bar'));
		$t->add(new \Mysql\TextColumn('baz'));
		$q = $t->build();
		$this->assert("CREATE TABLE `foo`(\n`bar` TEXT,\n`baz` TEXT\n)", $q->sql());

	}

}