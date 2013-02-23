<?php

namespace Core\Test\Mysql;

class TableColumn extends \Library\Test\Base {

	public function test_text() {

		$c = new \Mysql\TextColumn('foo');
		$this->assert('`foo` TEXT', $c->build());

		$c = new \Mysql\TextColumn('foo', array('null' => true));
		$this->assert('`foo` TEXT NULL', $c->build());

	}

	public function test_varchar() {

		$c = new \Mysql\VarcharColumn('foo', array('length' => 10));
		$this->assert('`foo` VARCHAR(10)', $c->build());

		$c = new \Mysql\VarcharColumn('bar', array('length' => 10, 'null' => true));
		$this->assert('`bar` VARCHAR(10) NULL', $c->build());

	}

	public function test_char() {

		$c = new \Mysql\CharColumn('foo', array('length' => 10));
		$this->assert('`foo` CHAR(10)', $c->build());

		$c = new \Mysql\CharColumn('bar', array('length' => 10, 'null' => true));
		$this->assert('`bar` CHAR(10) NULL', $c->build());

	}

	public function test_enum() {

		$c = new \Mysql\EnumColumn('foo', array('bar'));
		$this->assert("`foo` ENUM('bar')", $c->build());

		$c = new \Mysql\EnumColumn('foo', array('bar', 'baz'));
		$this->assert("`foo` ENUM('bar', 'baz')", $c->build());

	}

	public function test_int() {

		$c = new \Mysql\IntColumn('foo');
		$this->assert('`foo` INT', $c->build());

		$c = new \Mysql\IntColumn('bar', array('null' => true));
		$this->assert('`bar` INT NULL', $c->build());

	}

	public function test_tiny_int() {

		$c = new \Mysql\TinyIntColumn('foo');
		$this->assert('`foo` TINYINT', $c->build());

		$c = new \Mysql\TinyIntColumn('bar', array('null' => true));
		$this->assert('`bar` TINYINT NULL', $c->build());

	}

	public function test_small_int() {

		$c = new \Mysql\SmallIntColumn('foo');
		$this->assert('`foo` SMALLINT', $c->build());

		$c = new \Mysql\SmallIntColumn('bar', array('null' => true));
		$this->assert('`bar` SMALLINT NULL', $c->build());

	}

	public function test_medium_int() {

		$c = new \Mysql\MediumIntColumn('foo');
		$this->assert('`foo` MEDIUMINT', $c->build());

		$c = new \Mysql\MediumIntColumn('bar', array('null' => true));
		$this->assert('`bar` MEDIUMINT NULL', $c->build());

	}

	public function test_big_int() {

		$c = new \Mysql\BigIntColumn('foo');
		$this->assert('`foo` BIGINT', $c->build());

		$c = new \Mysql\BigIntColumn('bar', array('null' => true));
		$this->assert('`bar` BIGINT NULL', $c->build());

	}

	public function test_decimal() {

		$c = new \Mysql\DecimalColumn('foo', array('max' => 7, 'digits' => 2));
		$this->assert('`foo` DECIMAL(7, 2)', $c->build());

		$c = new \Mysql\DecimalColumn('bar', array('max' => 7, 'digits' => 2, 'null' => true));
		$this->assert('`bar` DECIMAL(7, 2) NULL', $c->build());

	}

	public function test_boolean() {

		$c = new \Mysql\BooleanColumn('foo');
		$this->assert('`foo` BOOLEAN', $c->build());

		$c = new \Mysql\BooleanColumn('bar', array('null' => true));
		$this->assert('`bar` BOOLEAN NULL', $c->build());

	}

	public function test_incrementing() {

		$c = new \Mysql\IncrementingColumn('foo');
		$this->assert('`foo` INT NOT NULL AUTO_INCREMENT', $c->build());

	}

	public function test_date() {

		$c = new \Mysql\DateColumn('foo');
		$this->assert('`foo` DATE', $c->build());

		$c = new \Mysql\DateColumn('bar', array('null' => true));
		$this->assert('`bar` DATE NULL', $c->build());

	}

	public function test_time() {

		$c = new \Mysql\TimeColumn('foo');
		$this->assert('`foo` TIME', $c->build());

		$c = new \Mysql\TimeColumn('bar', array('null' => true));
		$this->assert('`bar` TIME NULL', $c->build());

	}

	public function test_timestamp() {

		$c = new \Mysql\TimestampColumn('foo');
		$this->assert('`foo` TIMESTAMP DEFAULT CURRENT_TIMESTAMP', $c->build());

		$c = new \Mysql\TimestampColumn('foo', array('auto_update' => true));
		$this->assert('`foo` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP', $c->build());

		$c = new \Mysql\TimestampColumn('bar', array('null' => true));
		$this->assert('`bar` TIMESTAMP NULL', $c->build());

		$c = new \Mysql\TimestampColumn('foo', array('null' => true, 'auto_update' => true));
		$this->assert('`foo` TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP', $c->build());

	}

}