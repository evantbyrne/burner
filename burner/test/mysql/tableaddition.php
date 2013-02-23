<?php

namespace Core\Test\Mysql;

class TableAddition extends \Library\Test\Base {

	public function test_primary_key() {

		$a = new \Mysql\PrimaryKey('foo');
		$this->assert('PRIMARY KEY(`foo`)', $a->build());

		$a = new \Mysql\PrimaryKey('foo', 'bar');
		$this->assert('PRIMARY KEY(`foo`, `bar`)', $a->build());

	}

	public function test_unique_key() {

		$a = new \Mysql\UniqueKey('foo');
		$this->assert('UNIQUE KEY(`foo`)', $a->build());

		$a = new \Mysql\UniqueKey('foo', 'bar');
		$this->assert('UNIQUE KEY(`foo`, `bar`)', $a->build());

	}

	public function test_fulltext_index() {

		$a = new \Mysql\FulltextIndex('foo');
		$this->assert('FULLTEXT(`foo`)', $a->build());

		$a = new \Mysql\FulltextIndex('foo', 'bar');
		$this->assert('FULLTEXT(`foo`, `bar`)', $a->build());

	}

}