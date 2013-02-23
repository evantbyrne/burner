<?php

namespace Core\Test;

class Foo extends \Core\Model\Base {

	/**
	 * @option type = Varchar
	 * @option length = 25
	 */
	public $name;

}

class Bar extends Foo {

	public static $verbose = 'Blip';

	/**
	 * @option type = Text
	 * @option null = true
	 */
	public $description;

}

class FooBaz extends Bar {

	public static $verbose = 'Baz';
	public static $verbose_plural = 'Bazings';

	/**
	 * @option type = Boolean
	 * @option xyx = false
	 */
	public $awesome;

}

class Model extends \Library\Test\Base {

	public function test_table() {

		$this->assert('foo', Foo::table());
		$this->assert('bar', Bar::table());
		$this->assert('foobaz', FooBaz::table());

	}


	// ----- Verbose -----


	public function test_verbose() {

		$this->assert('Foo', Foo::get_verbose());
		$this->assert('Blip', Bar::get_verbose());
		$this->assert('Baz', FooBaz::get_verbose());

	}

	public function test_verbose_plural() {

		$this->assert('Foos', Foo::get_verbose_plural());
		$this->assert('Blips', Bar::get_verbose_plural());
		$this->assert('Bazings', FooBaz::get_verbose_plural());

	}


	// ----- Create Table -----


	public function test_create() {

		$foo = new Foo();
		$this->assert("CREATE TABLE `foo`(\n`id` INT NOT NULL AUTO_INCREMENT,\nPRIMARY KEY(`id`),\n`name` VARCHAR(25)\n) ENGINE = MyISAM", $foo->create_table(false, true));

		$bar = new Bar();
		$this->assert("CREATE TABLE `bar`(\n`id` INT NOT NULL AUTO_INCREMENT,\nPRIMARY KEY(`id`),\n`description` TEXT NULL,\n`name` VARCHAR(25)\n) ENGINE = MyISAM", $bar->create_table(false, true));

	}

	public function test_create_engine() {

		Foo::$engine = 'MEMORY';
		$foo = new Foo();
		$this->assert("CREATE TABLE `foo`(\n`id` INT NOT NULL AUTO_INCREMENT,\nPRIMARY KEY(`id`),\n`name` VARCHAR(25)\n) ENGINE = MEMORY", $foo->create_table(false, true));

		$bar = new Bar();
		$this->assert("CREATE TABLE `bar`(\n`id` INT NOT NULL AUTO_INCREMENT,\nPRIMARY KEY(`id`),\n`description` TEXT NULL,\n`name` VARCHAR(25)\n) ENGINE = MEMORY", $bar->create_table(false, true));

	}

}