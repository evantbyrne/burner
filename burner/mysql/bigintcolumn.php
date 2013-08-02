<?php

namespace Mysql;

/**
 * Big Int Column
 */
class BigIntColumn extends TableColumn {
	
	/**
	 * @inheritdoc
	 */
	public function build() {
	
		return "`{$this->name}` BIGINT{$this->build_null()}";
	
	}
	
}