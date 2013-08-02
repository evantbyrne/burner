<?php

namespace Mysql;

/**
 * Small Int Column
 */
class SmallIntColumn extends TableColumn {
	
	/**
	 * @inheritdoc
	 */
	public function build() {
	
		return "`{$this->name}` SMALLINT{$this->build_null()}";
	
	}
	
}