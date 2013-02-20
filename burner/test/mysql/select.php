<?php

namespace Core\Test\Mysql;
use \Mysql\Select as S;

class Select extends \Library\Test\Base {
	
	public function test_basic() {

		$s = new S('foo');
		$q = $s->build();
		$this->assert("SELECT * FROM `foo`", $q->sql());
		$this->assert(array(), $q->params());

	}


	// ----- Column -----


	public function test_column() {

		$s = new S('foo');
		$s->column('bar');
		$q = $s->build();
		$this->assert("SELECT `bar` AS `bar` FROM `foo`", $q->sql());
		$this->assert(array(), $q->params());

		$s = new S('foo');
		$s->column('bar', 'baz');
		$q = $s->build();
		$this->assert("SELECT `bar` AS `baz` FROM `foo`", $q->sql());
		$this->assert(array(), $q->params());

	}

	public function test_min_column() {

		$s = new S('foo');
		$s->min_column('bar');
		$q = $s->build();
		$this->assert("SELECT MIN(`bar`) AS `bar` FROM `foo`", $q->sql());
		$this->assert(array(), $q->params());

		$s = new S('foo');
		$s->min_column('bar', 'baz');
		$q = $s->build();
		$this->assert("SELECT MIN(`bar`) AS `baz` FROM `foo`", $q->sql());
		$this->assert(array(), $q->params());

	}

	public function test_max_column() {

		$s = new S('foo');
		$s->max_column('bar');
		$q = $s->build();
		$this->assert("SELECT MAX(`bar`) AS `bar` FROM `foo`", $q->sql());
		$this->assert(array(), $q->params());

		$s = new S('foo');
		$s->max_column('bar', 'baz');
		$q = $s->build();
		$this->assert("SELECT MAX(`bar`) AS `baz` FROM `foo`", $q->sql());
		$this->assert(array(), $q->params());

	}

	public function test_avg_column() {

		$s = new S('foo');
		$s->avg_column('bar');
		$q = $s->build();
		$this->assert("SELECT AVG(`bar`) AS `bar` FROM `foo`", $q->sql());
		$this->assert(array(), $q->params());

		$s = new S('foo');
		$s->avg_column('bar', 'baz');
		$q = $s->build();
		$this->assert("SELECT AVG(`bar`) AS `baz` FROM `foo`", $q->sql());
		$this->assert(array(), $q->params());

	}

	public function test_count_column() {

		$s = new S('foo');
		$s->count_column('bar');
		$q = $s->build();
		$this->assert("SELECT COUNT(`bar`) AS `bar` FROM `foo`", $q->sql());
		$this->assert(array(), $q->params());

		$s = new S('foo');
		$s->count_column('bar', 'baz');
		$q = $s->build();
		$this->assert("SELECT COUNT(`bar`) AS `baz` FROM `foo`", $q->sql());
		$this->assert(array(), $q->params());

	}

	public function test_sum_column() {

		$s = new S('foo');
		$s->sum_column('bar');
		$q = $s->build();
		$this->assert("SELECT SUM(`bar`) AS `bar` FROM `foo`", $q->sql());
		$this->assert(array(), $q->params());

		$s = new S('foo');
		$s->sum_column('bar', 'baz');
		$q = $s->build();
		$this->assert("SELECT SUM(`bar`) AS `baz` FROM `foo`", $q->sql());
		$this->assert(array(), $q->params());

	}

	public function test_column_multiple() {

		$s = new S('foo');
		$s->column('bar');
		$s->max_column('baz', 'foobar');
		$q = $s->build();
		$this->assert("SELECT `bar` AS `bar`, MAX(`baz`) AS `foobar` FROM `foo`", $q->sql());
		$this->assert(array(), $q->params());

	}

	public function test_column_given_table() {

		$s = new S('foo');
		$s->column('bar.baz');
		$q = $s->build();
		$this->assert("SELECT `bar`.`baz` AS `baz` FROM `foo`", $q->sql());
		$this->assert(array(), $q->params());

		$s = new S('foo');
		$s->column('bar.baz', 'foobar');
		$q = $s->build();
		$this->assert("SELECT `bar`.`baz` AS `foobar` FROM `foo`", $q->sql());
		$this->assert(array(), $q->params());

	}


	// ----- Join -----


	public function test_inner_join() {

		$s = new S('foo');
		$s->inner_join('bar', 'foo.baz', '=', 'bar.baz');
		$q = $s->build();
		$this->assert("SELECT * FROM `foo` INNER JOIN `bar` ON `foo`.`baz` = `bar`.`baz`", $q->sql());
		$this->assert(array(), $q->params());

	}

	public function test_left_join() {

		$s = new S('foo');
		$s->left_join('bar', 'foo.baz', '=', 'bar.baz');
		$q = $s->build();
		$this->assert("SELECT * FROM `foo` LEFT JOIN `bar` ON `foo`.`baz` = `bar`.`baz`", $q->sql());
		$this->assert(array(), $q->params());

	}

	public function test_right_join() {

		$s = new S('foo');
		$s->right_join('bar', 'foo.baz', '=', 'bar.baz');
		$q = $s->build();
		$this->assert("SELECT * FROM `foo` RIGHT JOIN `bar` ON `foo`.`baz` = `bar`.`baz`", $q->sql());
		$this->assert(array(), $q->params());

	}

	public function test_inner_join_where() {

		$s = new S('foo');
		$s->inner_join('bar', 'foo.baz', '=', 'bar.baz');
		$s->where('foo.foobar', '=', 'yup');
		$q = $s->build();
		$this->assert("SELECT * FROM `foo` INNER JOIN `bar` ON `foo`.`baz` = `bar`.`baz` WHERE `foo`.`foobar` = ?", $q->sql());
		$this->assert(array('yup'), $q->params());

	}


	// ----- Where -----


	public function test_where_equal() {

		$s = new S('foo');
		$s->where('bar', '=', 'baz');
		$q = $s->build();
		$this->assert("SELECT * FROM `foo` WHERE `bar` = ?", $q->sql());
		$this->assert(array('baz'), $q->params());

	}

	public function test_where_not_equal() {

		$s = new S('foo');
		$s->where('bar', '!=', 'baz');
		$q = $s->build();
		$this->assert("SELECT * FROM `foo` WHERE `bar` != ?", $q->sql());
		$this->assert(array('baz'), $q->params());

	}

	public function test_where_gt() {

		$s = new S('foo');
		$s->where('bar', '>', 'baz');
		$q = $s->build();
		$this->assert("SELECT * FROM `foo` WHERE `bar` > ?", $q->sql());
		$this->assert(array('baz'), $q->params());

	}

	public function test_where_gte() {

		$s = new S('foo');
		$s->where('bar', '>=', 'baz');
		$q = $s->build();
		$this->assert("SELECT * FROM `foo` WHERE `bar` >= ?", $q->sql());
		$this->assert(array('baz'), $q->params());

	}

	public function test_where_lt() {

		$s = new S('foo');
		$s->where('bar', '<', 'baz');
		$q = $s->build();
		$this->assert("SELECT * FROM `foo` WHERE `bar` < ?", $q->sql());
		$this->assert(array('baz'), $q->params());

	}

	public function test_where_lte() {

		$s = new S('foo');
		$s->where('bar', '<=', 'baz');
		$q = $s->build();
		$this->assert("SELECT * FROM `foo` WHERE `bar` <= ?", $q->sql());
		$this->assert(array('baz'), $q->params());

	}

	public function test_where_and() {

		$s = new S('foo');
		$s->where('bar', '!=', 'baz');
		$s->and_where('foobar', '>', 52.1);
		$q = $s->build();
		$this->assert("SELECT * FROM `foo` WHERE `bar` != ? AND `foobar` > ?", $q->sql());
		$this->assert(array('baz', 52.1), $q->params());

	}

	public function test_where_or() {

		$s = new S('foo');
		$s->where('bar', '>=', 'baz');
		$s->or_where('foobar', '<', 52.1);
		$q = $s->build();
		$this->assert("SELECT * FROM `foo` WHERE `bar` >= ? OR `foobar` < ?", $q->sql());
		$this->assert(array('baz', 52.1), $q->params());

	}

	public function test_where_equal_given_table() {

		$s = new S('foo');
		$s->where('bar.baz', '=', 'foobar');
		$q = $s->build();
		$this->assert("SELECT * FROM `foo` WHERE `bar`.`baz` = ?", $q->sql());
		$this->assert(array('foobar'), $q->params());

	}

	public function test_where_order() {

		$s = new S('foo');
		$s->where('bar', '=', 'baz');
		$s->order_desc('foobar');
		$q = $s->build();
		$this->assert("SELECT * FROM `foo` WHERE `bar` = ? ORDER BY `foobar` DESC", $q->sql());
		$this->assert(array('baz'), $q->params());

	}


	// ----- Order -----


	public function test_order_asc() {

		$s = new S('foo');
		$s->order_asc('bar');
		$q = $s->build();
		$this->assert("SELECT * FROM `foo` ORDER BY `bar` ASC", $q->sql());
		$this->assert(array(), $q->params());

	}

	public function test_order_desc() {

		$s = new S('foo');
		$s->order_desc('bar');
		$q = $s->build();
		$this->assert("SELECT * FROM `foo` ORDER BY `bar` DESC", $q->sql());
		$this->assert(array(), $q->params());

	}

	public function test_order_multiple() {

		$s = new S('foo');
		$s->order_asc('bar');
		$s->order_desc('baz');
		$q = $s->build();
		$this->assert("SELECT * FROM `foo` ORDER BY `bar` ASC, `baz` DESC", $q->sql());
		$this->assert(array(), $q->params());

	}

	public function test_order_limit() {

		$s = new S('foo');
		$s->order_asc('bar');
		$s->limit(5);
		$q = $s->build();
		$this->assert("SELECT * FROM `foo` ORDER BY `bar` LIMIT ?", $q->sql());
		$this->assert(array(5), $q->params());

	}


	// ----- Limit / Offset -----


	public function test_limit() {

		$s = new S('foo');
		$s->limit(5);
		$q = $s->build();
		$this->assert("SELECT * FROM `foo` LIMIT ?", $q->sql());
		$this->assert(array(5), $q->params());

	}

	public function test_offset() {

		$s = new S('foo');
		$s->limit(5);
		$s->offset(10);
		$q = $s->build();
		$this->assert("SELECT * FROM `foo` LIMIT ? OFFSET ?", $q->sql());
		$this->assert(array(5, 10), $q->params());

	}

	public function test_page() {

		$s = new S('foo');
		$s->page(2, 15);
		$q = $s->build();
		$this->assert("SELECT * FROM `foo` LIMIT ? OFFSET ?", $q->sql());
		$this->assert(array(15, 15), $q->params());

	}

}